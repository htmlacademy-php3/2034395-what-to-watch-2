<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenresTest extends TestCase
{
    use RefreshDatabase;

    public function testGetGenresList()
    {
        Genre::factory(10)->create();

        $response = $this->getJson(route('genres.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genres' => [], 'total']]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testAddGenre()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->postJson(
            route('genre.add'),
            ['name' => 'Триллер'],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genre' => []]]);
    }

    public function testChangeGenre()
    {
        $genre = Genre::factory()->create();

        $user = User::factory()->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->patchJson(
            route('genre.change'),
            ['id' => $genre->id, 'name' => 'Комедия'],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genre' => []]]);
    }
}
