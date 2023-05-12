<?php

namespace App\Jobs;

use App\Models\Film;
use App\Services\FilmsApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class AddFilm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string $imdbId
     *
     * @return void
     */
    public function __construct(private readonly string $imdbId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(FilmsApiService $apiService): void
    {
        $film = Film::query()->create(['imdb_id' => $this->imdbId]);

        $data = $apiService->getFilm($this->imdbId);

        abort_if(!$data, Response::HTTP_UNPROCESSABLE_ENTITY, 'Request failed');

        $film->update($data);

        foreach ($data['actors'] as $actor) {
            $film->actors()->create(['name' => $actor]);
        }

        foreach ($data['genres'] as $genre) {
            $film->genres()->create(['name' => $genre]);
        }
    }
}
