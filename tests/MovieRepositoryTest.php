<?php

namespace tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Mentalaffect\WhatToWatch\repositories\MovieRepository;

final class MovieRepositoryTest extends TestCase
{
    final public function testRepository(): void
    {
        global $argv;

        $client = new Client();
        $movieRepository = new MovieRepository($client, $argv[2]);

        try {
            $movie = $movieRepository->getById($argv[3]);
        } catch (GuzzleException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertIsArray($movie);
        $this->assertArrayNotHasKey('Error', $movie);
    }
}