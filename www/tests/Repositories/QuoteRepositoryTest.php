<?php

use PHPUnit\Framework\TestCase;

use App\Repositories\QuoteRepository;

class QuoteRepositoryTest extends TestCase
{
    private PDO $pdo;
    private QuoteRepository $quoteRepository;

    public function createDefaultQuote(): array
    {
        return [
            'quote' => 'Man is least himself when he talks in his own person. Give him a mask, and he will tell the truth.',
            'author' => 'Oscar Wilde',
            'created_at' => '2024-01-01 00:00:00',
            'user_id' => '1'
        ];
    }

    public function setUp(): void
    {
        $sqlPathFile = __DIR__ . '/../../tmp/testsdb.db';

        $this->pdo = new PDO('sqlite:' . $sqlPathFile);
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS qt_quotes (
                id         INTEGER PRIMARY KEY,
                quote      TEXT NOT NULL UNIQUE,
                author     VARCHAR(150) NOT NULL,
                created_at timestamp NOT NULL,
                updated_at timestamp,
                user_id    INT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES qt_users (id)
            )
        ');

        $this->quoteRepository = new QuoteRepository($this->pdo);
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenSaveQuote()
    {
        $this->expectException(PDOException::class);

        $quote = $this->createDefaultQuote();

        $result = $this->quoteRepository->save($quote);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function shouldReturnOneQuote()
    {
        $result = $this->quoteRepository->random();

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function shouldReturnAllQuotesByUserId()
    {
        $quotes = $this->quoteRepository->fetchAll(1, 1, 4);

        $this->assertIsArray($quotes);
    }

    /**
     * @test
     */
    public function shouldReturnTotalQuotesByUserId()
    {
        $total = $this->quoteRepository->total(1);

        $this->assertIsInt($total);
    }

    /**
     * @test
     */
    public function shouldReturnQuoteById()
    {
        $quote = $this->quoteRepository->find(1, 1);

        $this->assertIsArray($quote);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenQuoteNotFound()
    {
        $quote = $this->quoteRepository->find(100, 1);

        $this->assertEmpty($quote);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenUserIdNotFound()
    {
        $quote = $this->quoteRepository->find(1, 100);

        $this->assertEmpty($quote);
    }
}