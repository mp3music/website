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
    $results = Memcache\Handler::factory()->cache('now', 5, function () {
        $source = Sunra\PhpSimple\HtmlDomParser::file_get_html('http://mp3skull.com/latest.html');
        $links = $source->find('#content a');
        $result = [];

        foreach ($links as $link) {
            $result[] = $link->innertext;
        }

        return $result;
    });

    if (count($results) <= $limit) {
        return $results;
    }

    return array_slice($results, 0, $limit);
}

/**
 * @param $limit
 * @return array
 */
function randomArtists($limit = 10)
{
    return Memcache\Handler::factory()->cache(__FUNCTION__, \Memcache\Handler::MINUTE, function () use ($limit) {
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
    return Memcache\Handler::factory()->cache($query . '_video', Memcache\Handler::DAY, function () use ($query) {
        $json = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/videos?max-results=1&alt=json&q=' . urlencode($query)),
            true);

        if (!isset($json['feed']['entry'][0]['media$group']['media$content'][0]['url'])) {
            return null;
        }

        $url = str_replace(['/v/', 'http:'], ['/embed/', 'https:'], $json['feed']['entry'][0]['media$group']['media$content'][0]['url']);
        return '<iframe id="ytplayer" type="text/html" width="100%" height="200" src="' . $url . '&autohide=1&iv_load_policy=3&color=white&theme=light&showinfo=0" frameborder="0"></iframe>';
    });
}

/**
 * @return bool
 */
function isBot()
{
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return true;
    }

    $bots = array(
        'rambler',
        'googlebot',
        'aport',
        'yahoo',
        'msnbot',
        'turtle',
        'mail.ru',
        'omsktele',
        'yetibot',
        'picsearch',
        'sape.bot',
        'sape_context',
        'gigabot',
        'snapbot',
        'alexa.com',
        'megadownload.net',
        'askpeter.info',
        'igde.ru',
        'ask.com',
        'qwartabot',
        'yanga.co.uk',
        'scoutjet',
        'similarpages',
        'oozbot',
        'shrinktheweb.com',
        'aboutusbot',
        'followsite.com',
        'dataparksearch',
        'google-sitemaps',
        'appEngine-google',
        'feedfetcher-google',
        'liveinternet.ru',
        'xml-sitemaps.com',
        'agama',
        'metadatalabs.com',
        'h1.hrn.ru',
        'googlealert.com',
        'seo-rus.com',
        'yaDirectBot',
        'yandeG',
        'yandex',
        'yandexSomething',
        'Copyscape.com',
        'AdsBot-Google',
        'domaintools.com',
        'Nigma.ru',
        'bing.com',
        'dotnetdotcom'
    );

    foreach ($bots as $bot) {
        if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
            return $bot;
        }
    }

    return false;
}

/**
 * @param $query
 * @return array
 */
function queryLimit($query)
{
    return implode(' ', array_slice(explode(' ', $query), 0, 5));
}

/**
 * @param $query
 */
function saveRequest($query)
{
    if (!isBot()) {
        // Save request
        $client = new MongoClient(MONGO_DSN);
        $collection = $client->selectDB(MONGO_DBNAME)->selectCollection(MONGO_COLLECTION);
        if (!$collection->count(['request' => $query])) {
            $collection->insert([
                'request' => $query,
                'created' => new MongoDate(),
                'views' => 1
            ]);
        } else {
            $collection->update(['request' => $query], ['$inc' => ['views' => 1]]);
        }
    }
}

/**
 * @param $query
 * @return bool
 */
function banPage($query)
{
    $bans = [
        'weird-al-all',
        'skrillex-pop',
        'weird-al-headline-news'
    ];

    foreach ($bans as $ban) {
        if ($ban == $query) {
            return true;
        }
    }

    return false;
}

/**
 * @param $query
 * @return mixed
 */
function search($query) {
    return Memcache\Handler::factory()->cache($query, \Memcache\Handler::HOUR, function () use ($query) {
        require_once __DIR__ . '/libs/Mongo/MongoCache.php';

        $mongoSearch = new MongoCache();
        if(($result = $mongoSearch->search($query)) === null) {
            require_once __DIR__ . '/libs/Searcher/Handler.php';

            $vkClient = new Searcher\Handler($query);
            $result = $vkClient->searchWithParse();

            $mongoSearch->set($query, $result);
        }

        return $result;
    });
}