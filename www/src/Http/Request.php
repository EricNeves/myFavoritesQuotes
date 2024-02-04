<?php

namespace App\Http;

class Request
{
    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function body()
    {
        $json = json_decode(file_get_contents('php://input'), true);

        $data = match(self::getMethod()) {
            'GET'                 => $_GET,
            'POST','PUT','DELETE' => $json,
            default               => [],
        };

        return $data;
    }

    public static function authorization()
    {
        $headers = getallheaders();

        $authorization = $headers['Authorization'] ?? '';

        if (!$authorization) return ['error' => 'Please, use Bearer token.'];

        $authorizationParts = explode(' ', $authorization);

        if (isset($authorization[0]) && $authorizationParts[0] !== 'Bearer') {
            return ['error' => 'Please, use Bearer token.'];
        }

        if (isset($authorization[1]) && empty($authorizationParts[1])) {
            return ['error' => 'Please, insert a valid token.'];
        }

        return [
            'token' => $authorizationParts[1] ?? '',
        ];
    }
}