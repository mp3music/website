<?php

namespace Vkontakte;

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
        require_once(ROOT_DIR . '/../api.mp3cooll.com/lib/cloud.php');
        require_once(ROOT_DIR . '/../api.mp3cooll.com/lib/vkontakte.php');

        $handler = new \vkontakte([
            'query' => $this->query,
            'offset' => 0
        ]);

        if(count(($results = $handler->search())) == 0) {
            require_once(ROOT_DIR . '/../api.mp3cooll.com/lib/eee.php');
            $handler = new \eee([
                'query' => $this->query,
                'offset' => 0
            ]);

            $results = $handler->search();
        }

        return ['result' => $results];
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
}