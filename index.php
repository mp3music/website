<?php
define('ROOT_DIR', __DIR__);
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
            return file_get_contents('http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/topsongs/limit=50/xml');
        });

        $xml = new SimpleXMLElement($xmlString);
        $results = $xml->entry;

        $app->render('layout.php', [
            'page' => 'main',
            'results' => $results,
            'title' => 'Download mp3 free | Quick Search music | Download music for free',
            'description' => 'Download free most popular mp3 and listen online music just now. Watch music video online'
        ]);
    }
);
/**
 *
 */
$app->get('/now.html', function() use ($app) {
    $results = Memcache\Handler::factory()->cache('now', Memcache\Handler::MINUTE, function () {
        $source = Sunra\PhpSimple\HtmlDomParser::file_get_html('http://mp3skull.com/latest.html');
        $links = $source->find('#content a');
        $result = [];

        foreach($links as $link) {
            $result[] = $link->innertext;
        }

        return $result;
    });

    $app->render('layout.php', [
        'page' => 'now',
        'results' => $results,
        'title' => 'Now Playing On Mp3Cooll.com',
        'description' => 'Users listen now on mp3cooll.com'
    ]);
});

// Search route
$app->get('/:query.html', function ($query) use ($app) {
        $query = urlclean($query);

        if(!isBot()) {
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
        }

        $results = Memcache\Handler::factory()->cache($query, \Memcache\Handler::HOUR, function () use ($query) {
            require_once __DIR__ . '/libs/Vkontakte/Handler.php';

            $vkClient = new Vkontakte\Handler($query);
            return $vkClient->searchWithParse();
        });

        $app->render('layout.php', [
            'page' => 'search',
            'results' => $results,
            'query' => $query,
            'video' => getVideo($query),
            'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
            'description' => 'Download ' . ucwords($query) . ' mp3 and listen online song ' . ucwords($query) . ' just now unlimited. Watch video '
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