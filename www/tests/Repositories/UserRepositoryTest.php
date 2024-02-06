<?php 

use App\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private PDO $pdo;
    private UserRepository $userRepository;

    public function createDefaultUser(): array
    {
        return [
            'username'   => 'eric',
            'email'      => 'eric@email.com',
            'password'   => '123456',
            'created_at' => '2024-01-01 00:00:00',
        ];
    }

    public function setUp(): void 
    {
        $sqlPathFile = __DIR__ . '/../../tmp/testsdb.db';

        $this->pdo = new PDO('sqlite:'.$sqlPathFile);
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS qt_users (
                id         INTEGER PRIMARY KEY,
                username   VARCHAR(150) NOT NULL,
                email      VARCHAR(255) NOT NULL UNIQUE,
                password   VARCHAR(255) NOT NULL,
                created_at timestamp NOT NULL,
                updated_at timestamp
            )
        ');

        $this->userRepository = new UserRepository($this->pdo);
    }

    /**
     * @test
     */
    public function shouldCreateUser()
    {
        $this->expectException(PDOException::class);
        
        $user = $this->createDefaultUser();

        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $createUser = $this->userRepository->create($user);

        $this->assertTrue($createUser);
    }

    /**
     * @test
     */
    public function shouldAuthUser()
    {
        $user = $this->createDefaultUser();

        $this->userRepository->auth($user);

        $this->assertIsArray($user);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfUserNotAuth()
    {
        $user = $this->createDefaultUser();

        $user['password'] = 'wrongpassword';

        $result = $this->userRepository->auth($user);

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function shouldReturnUserById()
    {
        $user = $this->userRepository->find(1);

        $this->assertIsArray($user);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayIfUserDoesNotExist()
    {
        $user = $this->userRepository->find(0);

        $this->assertFalse($user);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfUserHasBeenUpdated()
    {
        $user = $this->createDefaultUser();

        $user['username'] = 'newusername';
        $user['password'] = password_hash('newpassword', PASSWORD_DEFAULT);

        $result = $this->userRepository->update($user, 1);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfUserDoesNotExist()
    {
        $user = $this->createDefaultUser();

        $user['username'] = 'newusername';
        $user['password'] = password_hash('newpassword', PASSWORD_DEFAULT);

        $result = $this->userRepository->update($user, 0);

        $this->assertFalse($result);
    }
}