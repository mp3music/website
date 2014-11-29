<?php
/**
 * Created by PhpStorm.
 * User: Askar
 * Date: 29.11.2014
 * Time: 12:46
 */
require_once __DIR__ . '/../libs/Mongo/MongoCache.php';

$mongoSearch = new MongoCache();
$mongoSearch->cleanExpiredCache();