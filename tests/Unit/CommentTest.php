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
    public function testComment(): void
    {
        $comment = Comment::factory()
            ->for(Film::factory())
            ->for(User::factory())
            ->create();

        $anonymousComment = Comment::factory()
            ->for(Film::factory())
            ->create();

        $this->assertIsString($comment->user()->first()?->name);
        $this->assertNull($anonymousComment->user()->first()?->name);
    }
}
