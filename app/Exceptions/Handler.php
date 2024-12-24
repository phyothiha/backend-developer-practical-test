<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UserAlreadyLikedPostException;
use App\Exceptions\UserLikeOwnPostException;
use Illuminate\Validation\ValidationException;
use App\Facades\ApiResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        
        $this->renderable(function (AuthenticationException $e) {
            return ApiResponse::status(Response::HTTP_UNAUTHORIZED)
                            ->message($e->getMessage())
                            ->failed();
        });

        $this->renderable(function (ValidationException $e) {
            return ApiResponse::status(Response::HTTP_UNPROCESSABLE_ENTITY)
                            ->error($e->errors())
                            ->message($e->getMessage())
                            ->failed();
        });
        
        $this->renderable(function (UserLikeOwnPostException $e) {
            return ApiResponse::status(Response::HTTP_INTERNAL_SERVER_ERROR)
                            ->message('You cannot like your post')
                            ->failed();
        });
        
        $this->renderable(function (UserAlreadyLikedPostException $e) {
            return ApiResponse::status(Response::HTTP_INTERNAL_SERVER_ERROR)
                            ->message('You already liked this post')
                            ->failed();
        });

        $this->renderable(function (ModelNotFoundException $e) {
            return ApiResponse::status(Response::HTTP_NOT_FOUND)
                            ->message('Model not found.')
                            ->failed();
        });

        $this->renderable(function (Throwable $e) {
            return ApiResponse::status(Response::HTTP_INTERNAL_SERVER_ERROR)
                            ->message('Internal server error.')
                            ->failed();
        });
    }
}
