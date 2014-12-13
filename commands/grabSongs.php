<?php
define('ROOT_DIR', __DIR__ . '/..');
require_once __DIR__ . '/../libs/Searcher/Handler.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$client = new MongoClient(MONGO_DSN);
$requestCollection = $client->music->requests;
$requests = $requestCollection->find()->sort(['views' => -1])->limit(100);

$client = new Elasticsearch\Client();
$params = array();

$params['index'] = 'music';
$params['type']  = 'tracks';

foreach ($requests as $query) {
    $vkClient = new Searcher\Handler($query['request']);
    $result = $vkClient->searchWithParse();

    foreach ($result['result'] as $item) {
        try {
            $item['artist'] = $item['artist']['name'];
            $item['rating'] = 0;
            $params['body']  = $item;
            $ret = $client->index($params);
        } catch (Exception $e) {

        }
    }

    echo $query['request'] . "\n";
    $requestCollection->remove(['request' => $query['request']]);
}