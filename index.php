<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/libs/Memcache/Handler.php';

$app = new \Slim\Slim();

// Set view settings
$view = $app->view();
$view->setTemplatesDirectory(TEMPLATES_DIR);

// Set routes
// Main page route
$app->get('/', function () use ($app) {
        $xmlString = Memcache\Handler::factory()->cache('top', Memcache\Handler::DAY, function () {
            return file_get_contents('http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/topsongs/limit=40/xml');
        });

        $xml = new SimpleXMLElement($xmlString);
        $results = $xml->entry;

        $app->render('layout.php', [
            'page' => 'main',
            'results' => $results,
            'title' => 'Mp3 free download | Quick Search music | Download music for free',
            'description' => 'Download free most popular mp3 and listen online music just now'
        ]);
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
        } else {
            $collection->update(['request' => $query], ['$inc' => ['views' => 1]]);
        }

        $results = Memcache\Handler::factory()->cache($query, 72000, function () use ($query) {
            require_once __DIR__ . '/libs/Vkontakte/Handler.php';

            $vkClient = new Vkontakte\Handler($query);
            return $vkClient->searchWithParse();
        });

        $app->render('layout.php', [
            'page' => 'search',
            'results' => $results,
            'query' => $query,
            'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
            'description' => 'Search ' . ucwords($query) . ' download free mp3 and listen online song ' . ucwords($query) . ' just now unlimited.'
        ]);
    }
)->conditions([
    'query' => '.+'
]);

// Search route
$app->get('/:query', function ($query) use ($app) {
        $app->redirect('/' . urlclean($query, '-') . '.html');
    }
)->conditions([
    'query' => '.+'
]);

$app->run();