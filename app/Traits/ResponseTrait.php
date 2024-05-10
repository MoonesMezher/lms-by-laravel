<?php

namespace App\Traits;

trait ResponseTrait
{
    protected function response($state , $message, $data, $statusCode)
    {
        return response()->json([
            'state' => $state,
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }
}
