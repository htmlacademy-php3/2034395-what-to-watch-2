<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_film(): void
    {
        $film = Film::factory()
            ->has(
                Comment::factory(10)
                    ->for(User::factory())
            )
            ->create();

        $ratingSum = array_reduce($film->comments()->get()->all(), function ($carry, $item) {
            $carry += $item->rating;
            return $carry;
        }, 0);

        $expectedRating = $ratingSum / count($film->comments()->get()->all());

        $this->assertEquals($expectedRating, $film->rating());
    }
}
