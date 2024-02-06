<?php 

namespace App\Http;

class JWT
{
    public function __construct(private mixed $userAuth = null, private string $secret = 'admin')
    {
    }

    public function generate(array $data = [])
    {
        $header  = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($data);

        $header_encoded  = $this->base64url_encode($header);
        $payload_encoded = $this->base64url_encode($payload);

        $signature = $this->signature($header_encoded, $payload_encoded);

        $jwt = $header_encoded . '.' . $payload_encoded . '.' . $signature;

        return $jwt;
    }

    private function signature(string $header, string $payload)
    {
        $signature = hash_hmac('SHA256', $header . '.' . $payload, $this->secret, true);

        return $this->base64url_encode($signature);
    }

    private function base64url_encode($data) 
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    private function base64url_decode($data)
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat('=', 4 - $padding);

        $data = strtr($data, '-_', '+/');

        return base64_decode($data);
    }

    public function validate(string $token = ''): mixed
    {
        $token = explode('.', $token);

        if (count($token) !== 3) {
            return false;
        }

        [$header, $payload, $signature_token] = $token;

        $signature = $this->signature($header, $payload);

        if ($signature !== $signature_token) {
            return false;
        }

        $data = $this->base64url_decode($payload);

        return json_decode($data, true);
    }

    public function user()
    {
        return $this->userAuth;
    }
}