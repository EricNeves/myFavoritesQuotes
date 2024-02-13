<?php

namespace App\Services;

use App\Http\JWT;
use App\Repositories\UserRepository;
use App\Utils\Validator;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private Validator $validator,
        private JWT $jwt
    ) {
    }

    public function save(array $data): array
    {
        try {
            $fields = [
                [$data['username'] ?? '', 'required'],
                [$data['email']    ?? '', 'required|email'],
                [$data['password'] ?? '', 'required']
            ];

            $this->validator->validate($fields);

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $createUser = $this->userRepository->create($data);

            if (!$createUser) {
                return ['error' => 'Sorry, we could not create your account.'];
            }

            return [
                'success' => 'Your account has been created.'
            ];

        } catch (\PDOException $error) {
            if ($error->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, this email already exists.'];
            }

            return ['error' => $error->getMessage()];

        } catch (\Exception $error) { return ['error' => $error->getMessage()]; }
    }

    public function authentication(array $data): array
    {
        try {
            $fields = [
                [$data['email']    ?? '', 'required'],
                [$data['password'] ?? '', 'required']
            ];

            $this->validator->validate($fields);

            $user = $this->userRepository->auth($data);

            if (!$user){
                return ['error' => 'Sorry, email or password is incorrect.'];
            }

            return [
                'token' => $this->jwt->generate($user)
            ];

        } 
        catch (\PDOException $error) { return ['error' => 'Sorry, something went wrong.']; } 
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function fetchUser(): array
    {
        try {
            $userAuth = $this->jwt->user();

            $user = $this->userRepository->find($userAuth['id']);

            if (!$user) return ['error' => 'Sorry, user not found.'];

            $user['created_at'] = date('d/m/Y H:i:s', strtotime($user['created_at']));

            if (!is_null($user['updated_at'])) {
                $user['updated_at'] = date('d/m/Y H:i:s', strtotime($user['updated_at']));
            }

            return $user;

        } 
        catch (\PDOException $error) { return ['error' => 'Sorry, something went wrong.']; } 
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function updateUser(array $data): array
    {
        try {
            $userAuth = $this->jwt->user();

            $fields = [
                [$data['username'] ?? '', 'required'],
                [$data['password'] ?? '', 'required']
            ];

            $this->validator->validate($fields);

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $updateUser = $this->userRepository->update($data, $userAuth['id']);

            if (!$updateUser) {
                return ['error' => 'Sorry, we could not update your account.'];
            }

            return [
                'success' => 'Your account has been updated.'
            ];

        } 
        catch (\PDOException $error) { return ['error' => 'Sorry, something went wrong.']; } 
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }
}