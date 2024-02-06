<?php 

namespace App\Middlewares;

use App\Http\Request;
use App\Http\Response;
use App\Http\JWT;

class AuthMiddleware
{
    public static function handle(array $authorization)
    {
        if (isset($authorization['error'])) {
            Response::json([
                'error'   => true,
                'success' => false,
                'message' => 'Sorry, you are not authorized.'
            ], 401);
            exit;
        }

        $jwt = new JWT();

        $parsedToken = $jwt->validate($authorization['token']);

        if (!$parsedToken) {
            Response::json([
                'error'   => true,
                'success' => false,
                'message' => 'Sorry, you are not authorized.'
            ], 401);
            exit;
        }

        return $parsedToken;
    }
}