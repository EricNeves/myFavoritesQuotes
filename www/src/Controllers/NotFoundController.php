<?php 

namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;

class NotFoundController
{
    public function index(Request $request, Response $response)
    {
        $response->json([
            'error'   => false,
            'success' => true,
            'message' => 'Sorry, the endpoint not found.'
        ], 404);
        return;
    }
}