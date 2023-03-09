<?php

require_once "vendor/autoload.php";

use Mentalaffect\WhatToWatch\repositories\MovieRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

if (isset($argv[1], $argv[2])) {
    $client = new Client();
    $repository = new MovieRepository($client, $argv[1]);

    try {
        $movie = $repository->getById($argv[2]);
        fputs(STDOUT, json_encode($movie));
    } catch (GuzzleException $e) {
        fputs(STDOUT, $e->getMessage());
    }
} else {
    fputs(STDOUT, 'Error: Two parameters must be entered: (php index.php "api_key" "movie IMDB id")');
}
