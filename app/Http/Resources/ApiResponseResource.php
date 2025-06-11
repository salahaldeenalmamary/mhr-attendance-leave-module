<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseResource extends JsonResource
{
    /**
     * The success status of the response.
     *
     * @var bool
     */
    protected $successStatus;

    /**
     * The message for the response.
     *
     * @var string
     */
    protected $responseMessage;

    /**
    
     *
     * @param  mixed  $resource The data payload for the 'data' key.
     * @param  bool   $success  The success status of the operation.
     * @param  string $message  A descriptive message for the operation.
     * @return void
     */
    public function __construct($resource, bool $success = true, string $message = 'Operation successful.')
    {
        parent::__construct($resource); // Sets $this->resource
        $this->successStatus = $success;
        $this->responseMessage = $message;
    }


    public function toArray($request): array
    {

        return [
            'data' => $this->resource,
        ];
    }

    /**
     
     *
     * @param  Request  $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'success' => $this->successStatus,
            'message' => $this->responseMessage,
        ];
    }

    /**
    
     *
     * @param mixed $data The payload for the 'data' key. Can be null.
     * @param string $message
     * @return static
     */
    public static function success($data = null, string $message = 'Operation successful.')
    {
        return new static($data, true, $message);
    }

    /**
    
    
     */
    public static function error($data = null, string $message = 'An error occurred.')
    {
        return new static($data, false, $message);
    }
}
