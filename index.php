<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$app = new \Slim\Slim();

// Set view settings
$view = $app->view();
$view->setTemplatesDirectory(TEMPLATES_DIR);

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
		if (!$collection->find(['request' => $query])->count()) {
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
		$cache = new memcache();
		$cache->connect('localhost');

		// Поиск в ВК и отправка пользователю
		if(($results = $cache->get($query)) === false) {
			// Search from Vk or memcache
			$http = new dHttp\Client('https://api.vk.com/method/audio.search.json?access_token=096fb2d19fc28da6694e9db15f47ff9561c36628f5485fbcd642f7edc6185ea413ab2f2fa4a5c1789cb79&q=' . urlencode($query));
			$results = json_decode($http->get()->getBody(), true);
			$cache->set($query, json_decode($http->get()->getBody(), true), 0, 72000);
		}

		$app->render('layout.php', [
			'page' => 'search',
			'results' => $results,
			'query' => $query
		]);
	}
)->conditions([
	'query' => '.+'
]);

$app->run();