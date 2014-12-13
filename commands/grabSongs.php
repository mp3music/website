<?php
define('ROOT_DIR', __DIR__ . '/..');
require_once __DIR__ . '/../libs/Searcher/Handler.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
$client = new MongoClient();

$requestCollection = $client->music->requests;
$requests = $requestCollection->find()->sort(['views' => -1])->limit(100);

foreach($requests as $query) {
    $vkClient = new Searcher\Handler($query['request']);
    $result = $vkClient->searchWithParse();
    $collection = $client->music->tracks;

    foreach($result['result'] as $item) {
        try {
            $item['artist'] = $item['artist']['name'];
            $item['rating'] = 0;
            if(!$collection->findOne(['url' => $item['url']])) {
                $collection->insert($item);
            }
        }
        catch(Exception $e) {

        }
    }

    echo $query['request'] . "\n";
    $requestCollection->remove(['request' => $query['request']]);
}
