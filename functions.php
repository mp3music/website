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
    return Memcache\Handler::factory()->cache(__FUNCTION__, 1800, function () use ($limit) {
        $client = new MongoClient(MONGO_DSN);
        $collection = $client->selectDB(MONGO_DBNAME)->selectCollection('artists');

        return iterator_to_array($collection->find()->skip(mt_rand(0, $collection->count() - $limit))->limit($limit));
    });
}

/**
 * @param $query
 * @return null|string
 */
function getVideo($query)
{
    return Memcache\Handler::factory()->cache($query . '_video', Memcache\Handler::HOUR, function () use ($query) {
        $json = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/videos?max-results=1&alt=json&q=' . urlencode($query)), true);

        if(!isset($json['feed']['entry'][0]['media$group']['media$content'][0]['url'])) {
            return null;
        }

        return '<iframe id="ytplayer" type="text/html" width="100%" height="200" src="' . str_replace('/v/', '/embed/', $json['feed']['entry'][0]['media$group']['media$content'][0]['url']) . '&autohide=1&
iv_load_policy=3&color=white&theme=light&showinfo=0" frameborder="0"></iframe>';
    });
}