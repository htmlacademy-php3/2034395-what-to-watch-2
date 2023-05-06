<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FilmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Film::factory(10)->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);
    }

    public function testGetFilmsList()
    {
        $response = $this->getJson(route('films.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['films' => [], 'total']]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testGetFilm()
    {
        $film = Film::query()->inRandomOrder()->get()->first();

        $response = $this->getJson(route('film.get', ['film' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['film' => []]]);
    }

    public function testAddFilm()
    {
        $response = $this->postJson(
            route('film.add'),
            [
                'name' => 'The Shawshank Redemption',
                'imdb_id' => 'tt0111161',
                'status' => 'ready',
                'is_promo' => false,
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['film' => []]]);
    }

    public function testChangeFilm()
    {
        $film = Film::query()->inRandomOrder()->get()->first();

        $response = $this->patchJson(
            route('film.change', ['film' => $film->id]),
            ['name' => 'The Shawshank Redemption'],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['film' => []]]);
    }
}
