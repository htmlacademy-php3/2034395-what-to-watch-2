<?php

use Mentalaffect\WhatToWatch\repositories\MovieRepository;
use GuzzleHttp\Client;

require_once('vendor/autoload.php');

$client = new Client();
$repository = new MovieRepository($client);
$movieId = 'tt3581920';

$movieData = $repository->getById($movieId);

var_dump($movieData);