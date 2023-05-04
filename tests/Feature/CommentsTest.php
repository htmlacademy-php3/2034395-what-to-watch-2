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

    public function testGetCommentsList()
    {
        $film = Film::factory()
            ->has(Comment::factory(5)->for(User::factory()))
            ->has(Comment::factory(5))
            ->create();

        $response = $this->getJson(route('comments.get', ['type' => 'film', 'id' => $film->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddComment()
    {
        $user = User::factory()->create();

        $film = Film::factory()->create();

        $response = $this->postJson(
            route('comment.add', ['type' => 'film', 'id' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
                'user_id' => $user->id,
            ],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testAddAnonymousComment()
    {
        $film = Film::factory()->create();

        $response = $this->postJson(
            route('comment.add', ['type' => 'film', 'id' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
            ],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testChangeComment()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->for(User::factory())
            ->create();

        $token = $comment->user()->get()->first()->createToken('auth-token')->plainTextToken;

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testChangeAnonymousCommentByModerator()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }

    public function testDeleteComment()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->deleteJson(
            route('comment.delete', ['comment' => $comment->id]),
            [],
            ['Authorization' => "Bearer $token"],
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => []]);
    }
}
