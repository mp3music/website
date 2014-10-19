<?php

namespace Vkontakte;

use \dHttp\Client;

/**
 * Class Handler
 *
 * @package Vkontakte
 */
class Handler
{
    /**
     * @var null
     */
    private $query = null;
    /**
     * @var null
     */
    private $limit = null;

    /**
     * @param $query
     * @param int $limit
     */
    public function __construct($query, $limit = 40)
    {
        $this->query = $query;
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function search()
    {
        $http = new Client($this->buildRequestUri());
        return json_decode($http->get()->getBody(), true);
    }

    /**
     * @return mixed
     */
    public function searchWithParse()
    {
        $results = $this->search();
        if (count($results['result']) < 1) {
            $newQuery = explode(' ', $this->query);
            $wordsCount = count($newQuery);

            if ($wordsCount > 1) {
                for ($i = 0; $i < $wordsCount; $i++) {
                    unset($newQuery[$wordsCount - 1]);
                    $this->setQuery(implode(' ', $newQuery));
                    return $this->searchWithParse();
                }
            }
        }

        return $results;
    }

    /**
     * @param $query
     * @return Handler
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param $limit
     * @return Handler
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    private function buildRequestUri()
    {
        return 'http://api.mp3cooll.com/api/?query=' . urlencode($this->query) . '&api_key=123';
    }
}