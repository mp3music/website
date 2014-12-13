<?php

/**
 * Class MongoSearch
 */
class MongoCache
{
    /**
     * @var MongoClient
     */
    private $client = null;
    /**
     *
     */
    const  EXPIRE_SEC = 72000;

    /**
     *
     */
    public function __construct()
    {
        if ($this->client == null) {
            $this->client = new MongoClient(MONGO_DSN);
        }
    }

    /**
     * @param $query
     * @return array
     */
    public function search($query)
    {
        $doc = $this->client->selectDB('search')->selectCollection('cache')->findOne(['query' => $query]);
        return ($doc != null) ? $doc['data'] : null;
    }

    /**
     * @param $query
     * @param $data
     * @return mixed
     */
    public function set($query, $data)
    {
        return $this->client->selectDB('search')->selectCollection('cache')->insert([
            'query' => $query,
            'data' => $data,
            'created' => time() + self::EXPIRE_SEC
        ]);
    }

    /**
     * @return mixed
     */
    public function cleanExpiredCache()
    {
        return $this->client->selectDB('search')->selectCollection('cache')->remove([
            'created' => ['$lte' => time()]
        ]);
    }
}