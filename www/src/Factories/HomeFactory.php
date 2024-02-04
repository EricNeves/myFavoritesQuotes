<?php 

namespace App\Factories;

use App\Services\HomeService;
use App\Repositories\HomeRepository;

class HomeFactory 
{
    public function generateInstance()
    {
        $homeRepositroy = new HomeRepository();
        $homeService    = new HomeService($homeRepositroy);

        return $homeService;
    }
}