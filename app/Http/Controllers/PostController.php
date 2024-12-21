<?php

namespace App\Http\Controllers;

use App\Exceptions\UserAlreadyLikedPostException;
use App\Exceptions\UserLikeOwnPostException;
use App\Http\Requests\PostToggleReactionRequest;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PostResource;
use App\Http\Filters\PostFilter;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function list(PostFilter $filters): JsonResource
    {
        // Include relationships
        // /?include=likes,tags,author
        
        // Filter column values
        // /?filter[createdAt]=2024-12-21&filter[ids]=1,2,3
            
        return PostResource::collection(
            Post::filter($filters)->paginate()
        );        
    }

    public function toggleReaction(PostToggleReactionRequest $request)
    {
        try {
            $post = Post::query()
                ->with([
                    'likes' => function (HasMany $query) {
                        $query->whereBelongsTo(Auth::user());
                    },
                ])
                ->findOrFail($request->validated('post_id'));

            // user tries to like his own post
            throw_if(Gate::denies('like-post', $post), UserLikeOwnPostException::class);

            // user already liked the post
            if ($post->likes->isNotEmpty()) {
                // reaction is like the post
                throw_if($request->boolean('like'), UserAlreadyLikedPostException::class);

                $post->likes->map->delete();

                return response()->json([
                    'status'  => Response::HTTP_OK,
                    'message' => 'You unlike this post successfully',
                ]);
            }

            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'status'  => Response::HTTP_OK,
                'message' => 'You like this post successfully',
            ]);
        } catch (UserLikeOwnPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You cannot like your post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UserAlreadyLikedPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You already liked this post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'model not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
