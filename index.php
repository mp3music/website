<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

$app = new \Slim\Slim();

// Set view settings
$view = $app->view();
$view->setTemplatesDirectory(TEMPLATES_DIR);

/**
 * @param $string
 * @return mixed|string
 */
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
		$xml = new SimpleXMLElement(file_get_contents('http://www.billboard.com/rss/charts/hot-100'));
		$app->render('layout.php', ['page' => 'main', 'results' => $xml->channel[0]->item]);
	}
);


// Search route
$app->get('/:query.html', function ($query) use ($app) {
		// Save request
		$client = new \Sokil\Mongo\Client(MONGO_DSN);
		$collection = $client->getDatabase(MONGO_DBNAME)->getCollection(MONGO_COLLECTION);
		if (!$collection->find(['request' => $query])->count()) {
			$collection->insert([
				'request' => urlclean($query),
				'created' => new MongoDate(),
				'views' => 1
			]);
		}
		else {
			$collection->getMongoCollection()->update(['request' => $query], ['$inc' => ['views' => 1]]);
		}

		// Search from Vk or memcache
		$cache = new memcache();
		$cache->connect('localhost');

		if(($results = $cache->get($query)) === false) {
			require_once __DIR__ . '/libs/vk/cloud.php';
			require_once __DIR__ . '/libs/vk/vkontakte.php';

			$vk = new vkontakte([
				'query' => $query,
				'offset' => 0
			]);
			$results = $vk->search();
			$cache->set($query, $results, 0, 3600);
		}

		$app->render('layout.php', [
			'page' => 'search',
			'results' => $results
		]);
	}
)->conditions([
	'query' => '.+'
]);

$app->run();