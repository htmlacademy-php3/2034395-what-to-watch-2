<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFilmsList()
    {
        Film::factory(10)->create();

        $response = $this->getJson(route('films.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testGetFilm()
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('film.get', ['film' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddFilm()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->postJson(
            route('film.add'),
            [
                'name' => 'The Shawshank Redemption',
                'imdb_id' => 'tt0111161',
                'status' => 'ready',
                'is_promo' => false,
            ],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testChangeFilm()
    {
        $film = Film::factory()->create();

        $user = User::factory()->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->patchJson(
            route('film.change'),
            ['id' => $film->id, 'name' => 'The Shawshank Redemption'],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }
}
