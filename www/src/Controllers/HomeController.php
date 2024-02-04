<?php 

namespace App\Controllers;

use App\Factories\HomeFactory;
use App\Http\Request;
use App\Http\Response;

class HomeController
{
    private $homeService; 

    public function __construct(private HomeFactory $homeFactory)
    {
        $this->homeService = $this->homeFactory->generateInstance();
    }

    public function index(Request $request, Response $response)
    {
        $response->json([
            'error'   => false,
            'success' => true,
            'info'    => $this->homeService->getMessage()
        ]);
        return;
    }
}