<?php

namespace App\Policies;

use App\Model\Post;
use App\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

/**
     * Determine if the given post can be deleted by the user.
     *
     * @param  App\Model\User  $user
     * @param  App\Model\Post  $post
     * @return bool
     */
    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
