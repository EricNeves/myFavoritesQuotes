<?php 

use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Utils\Validator;
use App\Http\JWT;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSaveUser() 
    {
        $userData = [
            'username' => 'John Doe',
            'email'    => 'johndoe@email.com',
            'password' => '123456'
        ];

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('create')
            ->willReturn(true);
        
        $validatorMock = $this->createMock(Validator::class);
        $jwtMock       = $this->createMock(JWT::class);

        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);

        $response    = $userService->save($userData);
        $expected    = ['success' => 'Your account has been created.'];

        $this->assertEquals($expected, $response);
    }

    /**
     * @test
     */
    public function shouldReturnErrorWhenExistsErrorOnSaveUser() 
    {
        $userData = [
            'username' => 'John Doe',
            'email'    => 'johndoe@email.com',
            'password' => '123456'
        ];
        
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('create')
            ->willReturn(false);

        $validatorMock = $this->createMock(Validator::class);
        $jwtMock       = $this->createMock(JWT::class);

        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->save($userData);

        $expected    = ['error' => 'Sorry, we could not create your account.'];

        $this->assertEquals($expected, $response);
    }

    /**
     * @test
     */
    public function shouldAuthenticateUser() 
    {
        $userData = [
            'email'    => 'johndoe@email.com',
            'password' => '123456'
        ];

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('auth')
            ->willReturn([
                'id'       => 1, 
                'username' => 'John Doe',
                'email'    => 'johndoe@email.com'
            ]);
        
        $validatorMock = $this->createMock(Validator::class);
        $jwtMock       = $this->createMock(JWT::class);

        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->authentication($userData);

        $this->assertArrayHasKey('token', $response);
    }
    
    /**
     * @test
     */
    public function shouldReturnErrorWhenExistsErrorOnAuthenticateUser()
    {
        $userData = [
            'email'    => 'johndoe@email.com',
            'password' => '123456'
        ];

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('auth')
            ->willReturn(false);
        
        $validatorMock = $this->createMock(Validator::class);
        $jwtMock       = $this->createMock(JWT::class);

        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->authentication($userData);

        $this->assertArrayHasKey('error', $response);
    }

    /**
     * @test
     */
    public function shouldReturnUser()
    {
        $userData = [
            'id'         => 1, 
            'username'   => 'John Doe',
            'email'      => 'johndoe@email.com',
            'created_at' => '01/01/1970 00:00:00',
            'updated_at' => null
        ];

        $jwtMock = $this->createMock(JWT::class);
        $jwtMock
            ->method('user')
            ->willReturn([
                'id' => 1
            ]);
        
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $validatorMock      = $this->createMock(Validator::class);

        $userRepositoryMock
            ->method('find')
            ->willReturn($userData);


        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->fetchUser();

        $this->assertEquals($userData, $response);
    }

    /**
     * @test
     */
    public function shouldReturnErrorWhenExistsErrorOnFetchUser()
    {
        $jwtMock = $this->createMock(JWT::class);
        $jwtMock
            ->method('user')
            ->willReturn([
                'id' => 1
            ]);
        
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $validatorMock      = $this->createMock(Validator::class);

        $userRepositoryMock
            ->method('find')
            ->willReturn(false);

        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->fetchUser();

        $this->assertArrayHasKey('error', $response);
    }

    /**
     * @test
     */
    public function shouldUpdateUser()
    {
        $userData = [
            'username' => 'Alan Turing',
            'password' => 'admin'
        ];

        $jwtMock = $this->createMock(JWT::class);
        $jwtMock
            ->method('user')
            ->willReturn([
                'id' => 1
            ]);

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $validatorMock      = $this->createMock(Validator::class);

        $userRepositoryMock
            ->method('update')
            ->willReturn(true);
        
        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->updateUser($userData);

        $this->assertArrayHasKey('success', $response);
    }

    /**
     * @test
     */
    public function shouldReturnErrorWhenExistsErrorOnUpdateUser()
    {
        $userData = [
            'username' => 'Alan Turing',
            'password' => 'admin'
        ];

        $jwtMock = $this->createMock(JWT::class);
        $jwtMock
            ->method('user')
            ->willReturn([
                'id' => 1
            ]);

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $validatorMock      = $this->createMock(Validator::class);

        $userRepositoryMock
            ->method('update')
            ->willReturn(false);
        
        $userService = new UserService($userRepositoryMock, $validatorMock, $jwtMock);
        $response    = $userService->updateUser($userData);

        $this->assertArrayHasKey('error', $response);
    }
}