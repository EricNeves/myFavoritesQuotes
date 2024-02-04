<?php 

namespace App\Http;

class Response 
{
    public static function json(array $data = [], int $status = 200, array $headers = ['Content-type' => 'application/json']): void
    {
        http_response_code($status);

        foreach ($headers as $key => $value) {
            header("{$key}: {$value}");
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}