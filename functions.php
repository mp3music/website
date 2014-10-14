<?php
/**
 * @param $string
 * @param string $delimeter
 * @return string
 */
function urlclean($string, $delimeter = ' ')
{
	// Clean
	$string = preg_replace('/[^\p{L}\d]/u', ' ', $string);
	return mb_strtolower(preg_replace('/(\s{1})\1*/ui', $delimeter, trim($string)), 'utf-8');
}

/**
 * Cut string by limit
 *
 * @param string $string
 * @param int $limit
 * @param boolean $points
 * @return string
 */
function s($string, $limit = 34, $points = true)
{
	if (mb_strlen($string) < $limit) {
		return $string;
	}

	return mb_substr($string, 0, $limit, 'utf-8') . ($points ? '...' : '');
}

/**
 * @param int $limit
 * @return array
 */
function getLastQueries($limit = 10)
{
	// Search from Vk or memcache
	$cache = new memcache();
	$cache->connect('localhost');
	$key = __FUNCTION__;

	if(($return = $cache->get($key)) === false) {
		// Save request
		$client = new MongoClient(MONGO_DSN);
		$collection = $client->selectDB(MONGO_DBNAME)->selectCollection(MONGO_COLLECTION);

		$results = $collection->find()->sort(['created' => -1])->limit($limit);
		$return = [];
		foreach($results as $item) {
			$return[] = $item['request'];
		}

		$cache->set($key, $return, 0, 60);
	}


	return $return;
}

/**
 * @param $limit
 * @return array
 */
function randomArtists($limit = 10)
{
	$cache = new memcache();
	$cache->connect('localhost');

	if(($results = $cache->get('random_artists')) === false) {
		$client = new MongoClient(MONGO_DSN);
		$collection = $client->selectDB(MONGO_DBNAME)->selectCollection('artists');

		$results = iterator_to_array($collection->find()->skip(rand(0, $collection->count() - $limit))->limit($limit));
		$cache->set('random_artists', $results, 0, 3600);
	}

	return $results;
}