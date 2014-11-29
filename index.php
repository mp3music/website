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
    $xmlString = Memcache\Handler::factory()->cache('maintop', Memcache\Handler::DAY, function () {
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
});
/**
 *
 */
$app->get('/now.html', function () use ($app) {
    $results = Memcache\Handler::factory()->cache('now', Memcache\Handler::MINUTE, function () {
        $source = Sunra\PhpSimple\HtmlDomParser::file_get_html('http://mp3skull.com/latest.html');
        $links = $source->find('#content a');
        $result = [];

        foreach ($links as $link) {
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
    if(banPage($query)) {
        header('Status: 404 Not Found');
        echo '<h1>Page not found</h1>';
        exit;
    }

    $query = queryLimit(urlclean($query));
    // Save query
    saveRequest($query);

    $app->render('layout.php', [
        'page' => 'search',
        'results' => search($query),
        'query' => $query,
        'video' => getVideo($query),
        'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
        'description' => 'Download ' . ucwords($query) . ' mp3 and listen online song ' . ucwords($query) . ' just now unlimited. Watch video '
    ]);
})->conditions([
    'query' => '.+'
]);

$app->get('/search', function () use ($app) {
    $query = queryLimit(urlclean($_GET['q']));
    if (strlen($query) < 1) {
        $app->redirect('/');
    }

    // Save query
    saveRequest($query);

    $app->render('layout.php', [
        'page' => 'search',
        'results' => search($query),
        'query' => $query,
        'video' => getVideo($query),
        'title' => ucwords($query) . ' download mp3 music | Mp3Cooll.com',
        'description' => 'Download ' . ucwords($query) . ' mp3 and listen online song ' . ucwords($query) . ' just now unlimited. Watch video '
    ]);
});

// Search route
$app->get('/:query', function ($query) use ($app) {
    $app->redirect('/' . urlclean($query, '-') . '.html');
})->conditions([
    'query' => '.+'
]);

$app->run();