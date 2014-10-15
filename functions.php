<?php
/**
 * @param $string
 * @param string $delimiter
 * @return string
 */
function urlclean($string, $delimiter = ' ')
{
    // Clean
    $string = preg_replace('/[^\p{L}\d]/u', ' ', $string);
    return mb_strtolower(preg_replace('/(\s{1})\1*/ui', $delimiter, trim($string)), 'utf-8');
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
    return Memcache\Handler::factory()->cache(__FUNCTION__, Memcache\Handler::MINUTE, function () use ($limit) {
        // Save request
        $client = new MongoClient(MONGO_DSN);
        $collection = $client->selectDB(MONGO_DBNAME)->selectCollection(MONGO_COLLECTION);

        $results = $collection->find()->sort(['created' => -1])->limit($limit);
        $return = [];
        foreach ($results as $item) {
            $return[] = $item['request'];
        }

        return $return;
    });
}

/**
 * @param $limit
 * @return array
 */
function randomArtists($limit = 10)
{
    return Memcache\Handler::factory()->cache(__FUNCTION__, Memcache\Handler::HOUR, function () use ($limit) {
        $client = new MongoClient(MONGO_DSN);
        $collection = $client->selectDB(MONGO_DBNAME)->selectCollection('artists');

        return iterator_to_array($collection->find()->skip(mt_rand(0, $collection->count() - $limit))->limit($limit));
    });
}