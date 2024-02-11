<?php 

namespace App\Controllers;

use App\Factories\QuoteFactory;
use App\Http\Request;
use App\Http\Response;

class QuoteController
{
    private $quoteService;

    public function __construct(private QuoteFactory $quoteFactory)
    {
        $this->quoteService = $quoteFactory->generateInstance();
    }

    public function store(Request $request, Response $response)
    {
        $body = $request::body() ?? [];

        $createQuote = $this->quoteService->create($body);

        if (isset($createQuote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $createQuote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $createQuote['success']
        ], 201);
        return;
    }

    public function fetch(Request $request, Response $response)
    {
        $fetchQuote = $this->quoteService->fetchQuote();

        if (isset($fetchQuote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $fetchQuote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $fetchQuote['success']
        ], 200);
        return;
    }

    public function index(Request $request, Response $response)
    {
        $page = (int) $request::body()['page'] ?? 1;

        $page = $page < 1 ? 1 : $page;

        $limitPerPage = 3;

        $fetchQuote = $this->quoteService->fetchUserQuotes($page, $limitPerPage);

        if (isset($fetchQuote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $fetchQuote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $fetchQuote
        ], 200);
        return;
    }

    public function findOne(Request $request, Response $response, array $id)
    {
        $quote = $this->quoteService->findOne($id[0]);

        if (isset($quote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $quote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $quote['success']
        ], 200);
        return;
    }

    public function update(Request $request, Response $response, array $id)
    {
        $body = $request::body() ?? [];

        $updateQuote = $this->quoteService->updateQuote($body, $id[0]);

        if (isset($updateQuote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $updateQuote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $updateQuote['success']
        ], 200);
        return;
    }

    public function delete(Request $request, Response $response, array $id)
    {
        $deleteQuote = $this->quoteService->deleteQuote($id[0]);

        if (isset($deleteQuote['error'])) {
            $response::json([
                'error'   => true,
                'success' => false,
                'message' => $deleteQuote['error']
            ], 400);
            return;
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $deleteQuote['success']
        ], 200);
        return;
    }
}