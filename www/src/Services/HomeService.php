<?php 

namespace App\Services;

use App\Repositories\HomeRepository;

class HomeService
{
    public function __construct(private HomeRepository $homeRepository) {}

    public function getMessage(): array
    {
        return $this->homeRepository->message();
    }
}