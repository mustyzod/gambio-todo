<?php

namespace Gambio\Router;

class Response
{
    /**
     * Handle Request response in controller
     */
    public static function json($result, $message = null, $status = 200)
    {
        header('Content-type:application/json;charset=utf-8');
        http_response_code($status);
        echo json_encode([
            "success" => true,
            "data" => $result,
            "message" => $message
        ]);
    }
}
