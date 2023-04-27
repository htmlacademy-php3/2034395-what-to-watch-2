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
                Comment::factory(10, ['rating' => 4])
                    ->for(User::factory())
            )
            ->create();

        $this->assertEquals(4, $film->rating());
    }
}
