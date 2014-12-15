<?php
define('ROOT_DIR', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/libs/Memcache/Handler.php';

$app = new \Slim\Slim([
    'templates.path' => TEMPLATES_DIR
]);

/**
 * Main page
 */
$app->get('/', function () use ($app) {
    $results = Memcache\Handler::factory()->cache('maintop', Memcache\Handler::DAY, function () {
        $xml = new SimpleXMLElement(file_get_contents('http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/topsongs/limit=30/xml'));
        return json_encode($xml);
    });

    $app->render('layout.php', [
        'page' => 'main',
        'results' => json_decode($results, true)['entry'],
        'title' => 'Download mp3 free | Quick Search music | Download music for free',
        'description' => 'Download free most popular mp3 and listen online music just now. Watch music video online'
    ]);
});

/**
 * Last requests
 */
$app->get('/now.html', function () use ($app) {
    $app->render('layout.php', [
        'page' => 'now',
        'results' => getLastQueries(30),
        'title' => 'Now Playing On Mp3Cooll.com',
        'description' => 'Users listen now on mp3cooll.com'
    ]);
});

/**
 * Disclamer route
 */
$app->get('/disclamer.html', function () use ($app) {
    $app->render('layout.php', [
        'page' => 'disclamer',
        'title' => 'Disclamer | Mp3Cooll.com',
        'description' => 'Download mp3 and listen online song just now unlimited. Watch video'
    ]);
});

/**
 * Search route
 */
$app->get('/:query.html', function ($query) use ($app) {
    if(banPage($query)) {
        header('Status: 404 Not Found');
        echo '<h1>Page not found</h1>';
        exit;
    }

    $query = urlclean($query);
    // Save query
    saveRequest($query);

    $app->render('layout.php', [
        'page' => 'searchtest',
        'results' => searchMongo($query),
        'query' => $query,
        'video' => getVideo($query),
        'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
        'description' => 'Download ' . ucwords($query) . ' mp3 and listen online song ' . ucwords($query) . ' just now unlimited. Watch video '
    ]);
})->conditions([
    'query' => '.+'
]);

/**
 * Search route
 */
$app->get('/search', function () use ($app) {
    $query = urlclean($_GET['q']);
    if (strlen($query) < 1) {
        $app->redirect('/');
    }

    // Save query
    saveRequest($query);

    $app->render('layout.php', [
        'page' => 'searchtest',
        'results' => searchMongo($query),
        'query' => $query,
        'video' => getVideo($query),
        'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
        'description' => 'Download ' . ucwords($query) . ' mp3 and listen online song ' . ucwords($query) . ' just now unlimited. Watch video '
    ]);
});

/**
 * Rating
 */
$app->get('/rating/:id', function ($id) use ($app) {
    $client = new MongoClient(MONGO_DSN);
    $client->music->tracks->update(['_id' => new MongoId($id)], ['$inc' => ['rating' => 1]], ['upsert' => true]);
})->conditions([
    'id' => '[a-z0-9]+'
]);

/**
 * Search route
 */
$app->get('/:query', function ($query) use ($app) {
    $app->redirect('/' . urlclean($query, '-') . '.html');
})->conditions([
    'query' => '.+'
]);

/**
 * Run application
 */
$app->run();