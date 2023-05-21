<?php

namespace Tests\Feature;

use App\Jobs\AddFilm;
use App\Models\Film;
use App\Services\FilmsApiService;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    public function testQueue()
    {
        Queue::fake();

        $film = Film::factory()->make(['imdb_id' => 'tt0111161']);

        $apiService = $this->getMockBuilder(FilmsApiService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiService->expects($this->any())
            ->method('getFilm')
            ->willReturn(['film' => $film, 'actors' => [], 'genres' => []]);

        $this->app->instance(FilmsApiService::class, $apiService);

        dispatch(new AddFilm($film));

        Queue::assertPushed(AddFilm::class);
    }
}
