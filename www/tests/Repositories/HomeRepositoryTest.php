<?php 

use App\Repositories\HomeRepository;
use PHPUnit\Framework\TestCase;

class HomeRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDefaultMessage()
    {
        $homeRepository = new HomeRepository();

        $this->assertIsArray($homeRepository->message());
    }
}