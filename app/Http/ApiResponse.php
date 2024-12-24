<?php

namespace App\Http;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResponse
{
    /**
     * The "data" wrapper
     *
     * @var array
     */
    protected $data = [];

    /**
     * The "pagination" wrapper
     *
     * @var array
     */
    protected $pagination = [];

    /**
     * The "error" wrapper
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Response message
     *
     * @var string
     */
    protected $message = '';
    
    /**
     * Response status code
     *
     * @var int
     */
    protected $statusCode = 200;
    
    /**
     * Response object
     *
     * @var array
     */
    protected $responseObj = [];

    /**
     * Set the data
     *
     * @param  array|\Illuminate\Http\Resources\Json\JsonResource  $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }
    
    /**
     * Set the status
     *
     * @param  int  $status
     * @return $this
     */
    public function status($status)
    {
        $this->statusCode = $status;

        return $this;
    }

    /**
     * Set the paginated data
     *
     * @param  \Illuminate\Http\Resources\Json\ResourceCollection  $data
     * @return $this
     */
    public function dataPaginated($data)
    {
        $arr = $data->response()->getData(true);
        
        $this->responseObj = $arr;

        return $this;
    }

    /**
     * Set the error
     *
     * @param  array  $errors
     * @return $this
     */
    public function error(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Set the message
     *
     * @param  string  $message
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Return success json response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success()
    {
        $responseObj = [
            'success' => true,
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data,
            ...$this->responseObj,
        ];

        return response()->json($responseObj, $this->statusCode);
    }

    /**
     * Return failed json response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed()
    {
        return response()->json([
            'success' => false,
            'status' => $this->statusCode,
            'message' => $this->message,
            'errors' => $this->errors,
            ...$this->responseObj,
        ], $this->statusCode);
    }
}
