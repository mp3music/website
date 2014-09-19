<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

$app = new \Slim\Slim();

// MongoDB settings
$elasticaClient = new \Elastica\Client();
$type = $elasticaClient->getIndex(ELASTIC_INDEX)->getType(ELASTIC_TYPE);

// Set view settings
$view = $app->view();
$view->setTemplatesDirectory(TEMPLATES_DIR);

function urlclean($string)
{
	// Clean
	$string = preg_replace('/[^\p{L}\d]/u', ' ', $string);
	$string = mb_strtolower(preg_replace('/(\s{1})\1*/ui', ' ', trim($string)), 'utf-8');

	return $string;
}

// Set routes

// Main page route
$app->get('/', function () use ($app) {
		$app->render('layout.php', ['page' => 'main']);
	}
);

// Search route
$app->get('/:query.html', function ($query) use ($app, $type, $elasticaClient) {
		// Save request
		$client = new \Sokil\Mongo\Client(MONGO_DSN);
		$collection = $client->getDatabase(MONGO_DBNAME)->getCollection(MONGO_COLLECTION);

		if(!$collection->find(['request' => $query])) {
			$collection->insert([
					'request' => urlclean($query),
					'created' => new MongoDate(),
					'status' => 0
				]);
		}

		$response = $elasticaClient->request('songs/songs/_search', \Elastica\Request::GET, array(
			'query' => array(
				'query_string' => array(
					'query' => urlclean($query),
				)
			),
			'sort' => array(
				'_score' => 'desc',
				'rating' => 'desc'
			),
			'size' => 20
		))->getData();

		$app->render('layout.php', [
				'page' => 'search',
				'results' => isset($response['hits']['hits']) ? $response['hits']['hits'] : []
			]);
	}
)->conditions([
			'query' => '[а-яёa-z\d\-]{3,}'
		]);

// Search route
$app->get('/download/:id', function ($id) use ($app, $type, $elasticaClient) {
		$response = $elasticaClient->request('songs/songs/' . $id . '', \Elastica\Request::GET, [])->getData();

		if($response['found']) {
			$elasticaClient->request('songs/songs/' . $id . '/_update', \Elastica\Request::POST, [
				"script" => "ctx._source.rating += 1"
			]);

			$app->response()->redirect($response['_source']['link']);
		}

		$app->response()->setStatus(404);
	}
);

$app->run();