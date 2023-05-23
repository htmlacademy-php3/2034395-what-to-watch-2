<?php

namespace Tests\Feature;

use App\Jobs\AddFilm;
use App\Models\Actor;
use App\Models\Comment;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use App\Services\FilmsApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FilmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Film::factory(10)
            ->has(Actor::factory(5))
            ->has(Genre::factory(2))
            ->has(Comment::factory(15))
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);
    }

    public function testGetFilmsList()
    {
        $response = $this->getJson(route('films.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'current_page',
            'first_page_url',
            'next_page_url',
            'prev_page_url',
            'per_page',
            'total',
        ]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testGetFilm()
    {
        $film = Film::query()->inRandomOrder()->get()->first();

        $response = $this->getJson(route('film.get', ['film' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddFilm()
    {
        $response = $this->postJson(
            route('film.add'),
            ['imdb_id' => 'tt0111161']
        );

        $response->assertValid();
        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testSimilarFilms()
    {
        $film = Film::query()->inRandomOrder()->get()->first();

        $response = $this->getJson(route('film.similar.get', ['film' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }
}
