<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_comment(): void
    {
        $comment = Comment::factory()
            ->for(Film::factory(), 'commentable')
            ->for(User::factory())
            ->create();

        $this->assertIsString($comment->user()->first()->name);
    }
}
