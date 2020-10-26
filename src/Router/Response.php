<?php

namespace Gambio\Router;

class Response
{
    /**
     * Handle Request response in controller
     */
    public static function json($result = [], $message = null, $status = 200)
    {
        http_response_code($status);
        echo json_encode([
            "success" => ($status === 200) ? true : false,
            "data" => $result,
            "message" => $message
        ]);
    }
}
