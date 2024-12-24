<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostToggleReactionRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PostResource;
use App\Http\Filters\PostFilter;
use App\Facades\ApiResponse;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function list(PostFilter $filters): JsonResponse
    {
        // Include relationships
        // /?include=likes,tags,author
        
        // Filter column values
        // /?filter[createdAt]=2024-12-21&filter[ids]=1,2,3
            
        return ApiResponse::dataPaginated(
            PostResource::collection(
                Post::filter($filters)->paginate()
            )
        )->success();
    }

    /**
     * Toggle reaction for current user.
     */
    public function toggleReaction(PostToggleReactionRequest $request)
    {              
        $post = Post::findOrFail($request->post_id);
        
        // user tries to like his own post
        $this->authorize('likeOwnPost', $post);
        
        $post->load('likes');

        // user already liked the post
        $this->authorize('likedPost', [$post, $request->like]);
        
        if (! $request->like) {
            $post->likes()->where('user_id', Auth::id())->delete();
        
            return ApiResponse::message('You unlike this post successfully')
                            ->success();
        } 
        
        $post->likes()->create(['user_id' => Auth::id()]);
        
        return ApiResponse::message('You like this post successfully')
                            ->success();
    }
}
