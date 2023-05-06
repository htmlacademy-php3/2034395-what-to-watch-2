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

    protected function setUp(): void
    {
        parent::setUp();

        Film::factory()
            ->has(Comment::factory(5)->for(User::factory()))
            ->has(Comment::factory(5))
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);
    }

    public function testGetCommentsList()
    {
        $film = Film::query()->get()->first();

        $response = $this->getJson(route('comments.get', ['type' => 'film', 'id' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['comments' => [], 'total']]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testAddComment()
    {
        $film = Film::query()->get()->first();

        $response = $this->postJson(
            route('comment.add', ['type' => 'film', 'id' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
            ],
        );

        $this->assertAuthenticated();
        $response->assertValid();
        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
        $response->assertJsonFragment(['user_id' => Auth::user()->id]);
    }

    public function testAddAnonymousComment()
    {
        $film = Film::factory()->create();

        Auth::logout();

        $response = $this->postJson(
            route('comment.add', ['type' => 'film', 'id' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
            ],
        );

        $this->assertGuest();
        $response->assertValid();
        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testChangeComment()
    {
        $comment = Comment::query()->inRandomOrder()->get()->first();

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
            ['Accept' => 'application/json'],
        );

        $this->assertAuthenticated();
        $response->assertValid();
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testChangeAnonymousCommentByModerator()
    {
        $comment = Comment::query()->whereNull('user_id')->get()->first();

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
        );

        $response->assertValid();
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testDeleteComment()
    {
        $comment = Comment::query()->inRandomOrder()->get()->first();

        $response = $this->deleteJson(route('comment.delete', ['comment' => $comment->id]));

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }
}
