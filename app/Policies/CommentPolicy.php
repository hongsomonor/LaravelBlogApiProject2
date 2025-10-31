<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user,Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function update(User $user,Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function __construct()
    {
        //
    }
}
