<?php

require_once "vendor/autoload.php";

use Mentalaffect\WhatToWatch\repositories\MovieRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

$client = new Client();
$repository = new MovieRepository($client, $argv[1]);

try {
    $movie = $repository->getById($argv[2]);
    fputs(STDOUT, json_encode($movie));
} catch (GuzzleException $e) {
    fputs(STDOUT, $e->getMessage());
}