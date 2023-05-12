<?php

namespace App\Jobs;

use App\Models\Film;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveFilm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Film $film, private readonly array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->film->update($this->data);

        foreach ($this->data['actors'] as $actor) {
            $this->film->actors()->create(['name' => $actor]);
        }

        foreach ($this->data['genres'] as $genre) {
            $this->film->genres()->create(['name' => $genre]);
        }
    }
}
