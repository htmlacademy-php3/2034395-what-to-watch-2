<?php

require_once "vendor/autoload.php";

use Mentalaffect\WhatToWatch\repositories\MovieRepository;
use GuzzleHttp\Client;

$client = new Client();
$movieRepository = new MovieRepository($client, $argv[1]);