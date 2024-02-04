<?php 

use PHPUnit\Framework\TestCase;

use App\Repositories\HomeRepository;
use App\Services\HomeService;

class HomeServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnMessage()
    {
        $homeRepository = $this->createMock(HomeRepository::class);

        $homeRepository->method('message')->willReturn([
            'message' => 'Hello World'
        ]);

        $homeService = new HomeService($homeRepository);
        
        $this->assertIsArray($homeService->getMessage());;
    }
}