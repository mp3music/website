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
			$xmlString = file_get_contents('http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/topsongs/limit=30/xml');
			$cache->set('top', $xmlString, 0, 8600);
		}

		$xml = new SimpleXMLElement($xmlString);
		$results = $xml->entry;

		$app->render('layout.php', ['page' => 'main', 'results' => $results, 'title' => 'Mp3Cooll.com - Mp3 free download | Quick Search music | Download music for free - mp3cooll.com']);
	}
);

// Search route
$app->get('/:query.html', function ($query) use ($app) {
		$query = urlclean($query);
		// Save request
		$client = new MongoClient(MONGO_DSN);
		$collection = $client->selectDB(MONGO_DBNAME)->selectCollection(MONGO_COLLECTION);
		if ($collection->find(['request' => $query])) {
			$collection->insert([
				'request' => $query,
				'created' => new MongoDate(),
				'views' => 1
			]);
		}
		else {
			$collection->update(['request' => $query], ['$inc' => ['views' => 1]]);
		}

		// Search from Vk or memcache
		$cache = new memcache();
		$cache->connect('localhost');

		// Поиск в ВК и отправка пользователю
		if(($results = $cache->get($query)) === false) {
			// Search from Vk or memcache
			$http = new dHttp\Client('https://api.vk.com/method/audio.search.json?access_token=096fb2d19fc28da6694e9db15f47ff9561c36628f5485fbcd642f7edc6185ea413ab2f2fa4a5c1789cb79&q=' . urlencode($query) . '&lyrics=1&count=30&sort=2');
			$results = json_decode($http->get()->getBody(), true);
			$cache->set($query, json_decode($http->get()->getBody(), true), 0, 72000);
		}

		$app->render('layout.php', [
			'page' => 'search',
			'results' => $results,
			'query' => $query,
			'title' => ucwords($query) . ' download mp3 music'
		]);
	}
)->conditions([
	'query' => '.+'
]);

$app->run();