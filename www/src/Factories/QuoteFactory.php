<?php  

namespace App\Factories;

use App\Repositories\QuoteRepository;
use App\Services\QuoteService;
use App\Utils\Validator;
use App\Http\JWT;

use PDO;

class QuoteFactory
{
    public function __construct(private PDO $pdo, private mixed $userAuth = null)
    {
    }

    public function generateInstance()
    {
        $quoteRepository = new QuoteRepository($this->pdo);
        $validator       = new Validator();
        $jwt             = new JWT($this->userAuth);
        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);

        return $quoteService;
    }
}