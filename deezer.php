<?php
// Save request
$client = new MongoClient();
$collection = $client->music->artists;
for($i = 300000; $i <= 6451447; $i++) {
	$result = json_decode(file_get_contents('http://api.deezer.com/artist/' . $i), true);
	if(!isset($result['error'])) {
        if($collection->findOne(['name' => $result['name']]) == null) {
            $collection->insert($result);
        }
	}
}