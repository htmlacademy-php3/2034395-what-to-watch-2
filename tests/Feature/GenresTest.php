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

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Genre::factory(10)->create();

        $this->user = User::factory()->has(Role::factory())->create();
    }

    public function testGetGenresList()
    {
        $response = $this->getJson(route('genres.get'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddGenre()
    {
        $response = $this->actingAs($this->user)->postJson(
            route('genre.add'),
            ['name' => 'Триллер'],
        );

        $response->assertValid();
        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testChangeGenre()
    {
        $genre = Genre::query()->inRandomOrder()->get()->first();

        $response = $this->actingAs($this->user)->patchJson(
            route('genre.change', ['genre' => $genre->id]),
            ['name' => 'Комедия'],
        );

        $response->assertValid();
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }
}
