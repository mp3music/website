<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

// Save request
$client = new \Sokil\Mongo\Client(MONGO_DSN);
$collection = $client->getDatabase(MONGO_DBNAME)->getCollection('artists');
for($i = 1; $i <= 6451447; $i++) {
	$collection->insert(json_decode(file_get_contents('http://api.deezer.com/artist/' . $i), true));
}