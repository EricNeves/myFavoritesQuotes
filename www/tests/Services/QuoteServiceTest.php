<?php

use App\Http\JWT;
use App\Repositories\QuoteRepository;
use App\Services\QuoteService;
use App\Utils\Validator;
use PHPUnit\Framework\TestCase;

class QuoteServiceTest extends TestCase 
{
    /**
     * @test
     */
    public function shouldSaveQuote()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('save')
            ->willReturn(true);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->create([
            'quote'  => 'This is a quote',
            'author' => 'John Doe'
        ]);

        $this->assertArrayHasKey('success', $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorIfQuoteNotSaved()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('save')
            ->willReturn(false);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->create([
            'quote'  => 'This is a quote',
            'author' => 'John Doe'
        ]);

        $this->assertArrayHasKey('error', $result);
    }

    /**
     * @test
     */
    public function shouldReturnRandomQuote()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('random')
            ->willReturn([
                'quote'       => 'This is a quote',
                'author'      => 'John Doe',
                'created_at'  => '2021-10-10 10:10:10',
                'username'    => 'johndoe'
            ]);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->fetchQuote();

        $this->assertArrayHasKey('success', $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorIfRandomQuoteDoesNotExist()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('random')
            ->willReturn([]);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->fetchQuote();

        $this->assertArrayHasKey('error', $result);
    }

    /**
     * @test
     */
    public function shouldReturnAllQuoteOfUser()
    {
        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('fetchAll')
            ->willReturn([
                [
                    'quote'       => 'This is a quote',
                    'author'      => 'John Doe',
                    'created_at'  => '2021-10-10 10:10:10',
                    'updated_at'  => '2021-10-10 10:10:10',
                    'username'    => 'johndoe',
                    'user_id'     => 1
                ]
                ]);
            
        $quoteRepository
            ->method('total')
            ->willReturn(1);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->fetchUserQuotes(1, 3);

        $this->assertArrayHasKey('quotes', $result);
    }

    /**
     * @test
     */
    public function shouldReturnQuoteById()
    {
        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('find')
            ->willReturn([
                'quote'       => 'This is a quote',
                'author'      => 'John Doe',
                'created_at'  => '2021-10-10 10:10:10',
                'updated_at'  => '2021-10-10 10:10:10',
                'username'    => 'johndoe',
                'user_id'     => 1
            ]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->findOne(1);

        $this->assertArrayHasKey('success', $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorIfQuoteDoesNotExist()
    {
        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('find')
            ->willReturn([]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->findOne(1);

        $this->assertArrayHasKey('error', $result);
    }

    /**
     * @test
     */
    public function shouldUpdateQuote()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('update')
            ->willReturn(true);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->updateQuote([
            'quote'  => 'This is a quote',
            'author' => 'John Doe'
        ], 1);

        $this->assertArrayHasKey('success', $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorIfQuoteNotUpdated()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('update')
            ->willReturn(false);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->updateQuote([
            'quote'  => 'This is a quote',
            'author' => 'John Doe'
        ], 1);

        $this->assertArrayHasKey('error', $result);
    }

    /**
     * @test
     */
    public function shouldRemoveQuote() 
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('remove')
            ->willReturn(true);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->deleteQuote(1);

        $this->assertArrayHasKey('success', $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorIfQuoteNotRemoved()
    {
        $quoteRepository = $this->createMock(QuoteRepository::class);
        $quoteRepository
            ->method('remove')
            ->willReturn(false);

        $validator       = $this->createMock(Validator::class);
        $jwt             = $this->createMock(JWT::class);
        $jwt
            ->method('user')
            ->willReturn(['id' => 1]);

        $quoteService    = new QuoteService($validator, $jwt, $quoteRepository);
        $result          = $quoteService->deleteQuote(1);

        $this->assertArrayHasKey('error', $result);
    }
}