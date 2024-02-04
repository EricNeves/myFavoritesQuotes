<?php 

namespace App\Http;

class JWT
{
    private static string $secret = 'admin';
    private static mixed $userAuth;

    public function __construct(mixed $userAuth = null)
    {
        self::$userAuth = $userAuth;
    }

    public static function generate(array $data = [])
    {
        $header  = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($data);

        $header_encoded  = self::base64url_encode($header);
        $payload_encoded = self::base64url_encode($payload);

        $signature = self::signature($header_encoded, $payload_encoded);

        $jwt = $header_encoded . '.' . $payload_encoded . '.' . $signature;

        return $jwt;
    }

    private static function signature(string $header, string $payload)
    {
        $signature = hash_hmac('SHA256', $header . '.' . $payload, self::$secret, true);

        return self::base64url_encode($signature);
    }

    private static function base64url_encode($data) 
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    private static function base64url_decode($data)
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat('=', 4 - $padding);

        $data = strtr($data, '-_', '+/');

        return base64_decode($data);
    }

    public static function validate(string $token = ''): mixed
    {
        $token = explode('.', $token);

        if (count($token) !== 3) {
            return false;
        }

        [$header, $payload, $signature_token] = $token;

        $signature = self::signature($header, $payload);

        if ($signature !== $signature_token) {
            return false;
        }

        $data = self::base64url_decode($payload);

        return json_decode($data, true);
    }

    public static function user()
    {
        return self::$userAuth;
    }
}