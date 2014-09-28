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
function urlclean($string, $delimeter = ' ')
{
	// Clean
	$string = preg_replace('/[^\p{L}\d]/u', ' ', $string);
	return  mb_strtolower(preg_replace('/(\s{1})\1*/ui', $delimeter, trim($string)), 'utf-8');
}

// Set routes
// Main page route
$app->get('/', function () use ($app) {
		// Search from Vk or memcache
		$cache = new memcache();
		$cache->connect('localhost');

		if(($xmlString = $cache->get('top')) === false) {
			$xmlString = file_get_contents('http://www.billboard.com/rss/charts/hot-100');
			$cache->set('top', $xmlString, 0, 8600);
		}

		$xml = new SimpleXMLElement($xmlString);
		$results = $xml->channel[0]->item;

		$app->render('layout.php', ['page' => 'main', 'results' => $results]);
	}
);

// Search route
$app->get('/:query.html', function ($query) use ($app) {
		$query = urlclean($query);
		// Save request
		$client = new \Sokil\Mongo\Client(MONGO_DSN);
		$collection = $client->getDatabase(MONGO_DBNAME)->getCollection(MONGO_COLLECTION);
		if (!$collection->find(['request' => c])->count()) {
			$collection->insert([
				'request' => $query,
				'created' => new MongoDate(),
				'views' => 1
			]);
		}
		else {
			$collection->getMongoCollection()->update(['request' => $query], ['$inc' => ['views' => 1]]);
		}

		// Search from Vk or memcache
		$http = new dHttp\Client('http://api.mp3.loc/api/?query=' . urlencode($query) . '&api_key=123');

		$app->render('layout.php', [
			'page' => 'search',
			'results' => json_decode($http->get()->getBody(), true),
			'query' => $query
		]);
	}
)->conditions([
	'query' => '.+'
]);

$app->run();