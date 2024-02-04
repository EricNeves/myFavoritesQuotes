<?php 

namespace App\Controllers;

use App\Factories\UserFactory;
use App\Http\Request;
use App\Http\Response;

class UserController
{
    private $userService;

    public function __construct(private UserFactory $userFactory) 
    {
        $this->userService = $this->userFactory->generateInstance();
    }

    public function store(Request $request, Response $response)
    {
        $body = $request::body() ?? [];

        $createUser = $this->userService->save($body);

        if (isset($createUser['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $createUser['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $createUser['success']
        ], 201);
        return;
    }

    public function login(Request $request, Response $response)
    {
        $body = $request::body() ?? [];

        $loginUser = $this->userService->authentication($body);

        if (isset($loginUser['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $loginUser['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'jwt'     => $loginUser['token']
        ], 200);
        return;
    }

    public function fetch(Request $request, Response $response)
    {
        $user = $this->userService->fetchUser();

        if (isset($user['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $user['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $user
        ], 200);
        return;
    }

    public function update(Request $request, Response $response)
    {
        $body = $request::body() ?? [];

        $updateUser = $this->userService->updateUser($body);

        if (isset($updateUser['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $updateUser['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $updateUser['success']
        ], 200);
        return;
    }
}