<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GenresTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Genre::factory(10)->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);
    }

    public function testGetGenresList()
    {
        $response = $this->getJson(route('genres.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genres' => [], 'total']]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testAddGenre()
    {
        $response = $this->postJson(
            route('genre.add'),
            ['name' => 'Триллер'],
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['genre' => []]]);
    }

    public function testChangeGenre()
    {
        $genre = Genre::query()->inRandomOrder()->get()->first();

        $response = $this->patchJson(
            route('genre.change', ['genre' => $genre->id]),
            ['name' => 'Комедия'],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['genre' => []]]);
    }
}
