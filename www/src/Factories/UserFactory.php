<?php 

namespace App\Factories;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Utils\Validator;
use App\Http\JWT;
use PDO;

class UserFactory
{
    public function __construct(private PDO $pdo, private mixed $userAuth = null) 
    {
    }

    public function generateInstance()
    {
        $userRepository = new UserRepository($this->pdo);
        $validator      = new Validator();
        $jwt            = new JWT($this->userAuth);
        $userService    = new UserService($userRepository, $validator, $jwt);

        return $userService;
    }
}