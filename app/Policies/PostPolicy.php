<?php

namespace App\Policies;

use Auth;
use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function create(User $user, Post $post)
    {
        return ($user->role === 'administrator');
    }

    public function update(User $user, Post $post)
    {
        return ($user->role === 'administrator' || $user->id === $post->user_id);
    }

    public function delete(User $user, Post $post)
    {
        return ($user->role === 'administrator' || $user->id === $post->user_id);
    }

    public function rate(User $user, Post $post)
    {
        return $user->hasRated($post);
    }
}
