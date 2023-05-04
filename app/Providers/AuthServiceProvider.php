<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\User;
use http\Env\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('comment.delete', function (User $user) {
            return $user->isModerator();
        });

        Gate::define('comment.change', function (User $user, Comment $comment) {
            if ($user->isModerator() || $comment->user_id === $user->id) {
                return !$comment->reply()->exists();
            }

            return false;
        });
    }
}
