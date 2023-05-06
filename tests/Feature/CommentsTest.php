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
        $response->assertJsonStructure(['data' => ['comments' => [], 'total']]);
        $response->assertJsonFragment(['total' => 10]);
    }

    public function testAddComment()
    {
        $user = User::factory()->create();

        $film = Film::factory()->create();

        Auth::login($user);

        $response = $this->postJson(
            route('comment.add', ['type' => 'film', 'id' => $film->id]),
            [
                'text' => 'Test comment',
                'rating' => '4',
            ],
        );

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
        $response->assertJsonFragment(['user_id' => $user->id]);
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

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testChangeComment()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->for(User::factory())
            ->create();

        Auth::login($comment->user()->get()->first());

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
            ['Accept' => 'application/json'],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testChangeAnonymousCommentByModerator()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);

        $response = $this->patchJson(
            route('comment.change', ['comment' => $comment->id]),
            ['text' => 'Changed test comment text'],
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }

    public function testDeleteComment()
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->create();

        $user = User::factory()->has(Role::factory())->create();

        Auth::login($user);

        $response = $this->deleteJson(route('comment.delete', ['comment' => $comment->id]));

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['comment' => []]]);
    }
}
