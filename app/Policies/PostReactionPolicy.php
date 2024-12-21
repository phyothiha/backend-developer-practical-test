<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Exceptions\UserLikeOwnPostException;
use App\Exceptions\UserAlreadyLikedPostException;

class PostReactionPolicy
{
    /**
     * Determine whether the user can like the model.
     */
    public function likeOwnPost(User $user, Post $post): bool
    {
        return $user->id == $post->author_id
            ? throw new UserLikeOwnPostException
            : true;
    }
    
    /**
     * Determine whether the user can like the model that is already liked.
     */
    public function likedPost(User $user, Post $post, bool $isLiked): bool
    {
        return $post->likes->contains('user_id', $user->id) && $isLiked
            ? throw new UserAlreadyLikedPostException
            : true;
    }
}
