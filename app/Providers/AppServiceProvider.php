<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //pagination
        Paginator::useBootstrapFive();

        //gates
        Gate::define('update-blog', function(User $user, Blog $blog) {
            return $user->id === $blog->author_id
            ? Response::allow()
            : Response::deny('You must be the author.');
        });
    }
}
