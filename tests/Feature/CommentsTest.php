<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Film;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Film::factory()
            ->has(Comment::factory(5)->for(User::factory()))
            ->has(Comment::factory(5))
            ->create();

        $this->user = User::factory()->has(Role::factory())->create();
    }

    public function testGetCommentsList()
    {
        $film = Film::query()->get()->first();

        $response = $this->getJson(route('comments.get', ['film' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddComment()
    {
        $film = Film::query()->get()->first();

        $response = $this->actingAs($this->user)->postJson(
            route('comment.add', ['film' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
            ],
        );

        $this->assertAuthenticated();
        $response->assertValid();
        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testChangeComment()
    {
        $comment = Comment::query()->inRandomOrder()->get()->first();

        $response = $this->actingAs($this->user)->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
            ['Accept' => 'application/json'],
        );

        $this->assertAuthenticated();
        $response->assertValid();
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testDeleteComment()
    {
        $comment = Comment::query()->inRandomOrder()->get()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('comment.delete', ['comment' => $comment->id]));

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }
}
