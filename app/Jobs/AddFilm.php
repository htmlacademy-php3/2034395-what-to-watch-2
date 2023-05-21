<?php

namespace App\Jobs;

use App\Models\Film;
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
     * @param Film $film
     *
     * @return void
     */
    public function __construct(private readonly Film $film)
    {
    }

    /**
     * Execute the job.
     */
    public function handle($apiService): void
    {
        $data = $apiService->getFilm($this->film->imdb_id);

        abort_if(!$data, Response::HTTP_UNPROCESSABLE_ENTITY, 'Request failed');

        $this->film->update($data['film']);

        foreach ($data['actors'] as $actor) {
            $this->film->actors()->create(['name' => $actor]);
        }

        foreach ($data['genres'] as $genre) {
            $this->film->genres()->create(['name' => $genre]);
        }
    }
}
