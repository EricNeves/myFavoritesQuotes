<?php

namespace App\Services;

use App\Repositories\QuoteRepository;
use App\Utils\Validator;
use App\Http\JWT;

class QuoteService
{
    public function __construct(
        private Validator       $validator,
        private JWT             $jwt,
        private QuoteRepository $quoteRepository
    ) 
    {
    }

    public function create(array $data): array
    {
        try {
            $userAuth = $this->jwt->user();

            $fields = [
                [$data['quote']  ?? '', 'required'],
                [$data['author'] ?? '', 'required']
            ];

            $this->validator->validate($fields);

            $data['user_id'] = $userAuth['id'];

            $quote = $this->quoteRepository->save($data);

            if (!$quote) {
                return ['error' => 'Sorry, failed to save quote.'];
            }

            return [
                'success' => 'Quote created successfully.'
            ];

        } 
        catch (\PDOException $error) { 
            if ($error->errorInfo[0] === '23505') return ['error' => 'Sorry, this quote already exists.'];

            return ['error' => $error->getMessage()];
        }
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function fetchQuote()
    {
        try {
            $quote = $this->quoteRepository->random();

            if (!$quote) return ['error' => "Sorry, we couldn't find any quotes."];

            return [
                'success' => $quote
            ];
            
        } 
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function fetchUserQuotes(int $page, int $limitPerPage)
    {
        try {
            $userAuth = $this->jwt->user();

            $quotes = $this->quoteRepository->fetchAll($userAuth['id'], $page, $limitPerPage);

            $total  = $this->quoteRepository->total($userAuth['id']);

            $hasNext = count($quotes) < $limitPerPage ? false : true;

            foreach ($quotes as $key => $quote) {
                $quotes[$key]['created_at'] = date('d/m/Y H:i:s', strtotime($quote['created_at']));

                if (!is_null($quotes[$key]['updated_at'])) {
                    $quotes[$key]['updated_at'] = date('d/m/Y H:i:s', strtotime($quote['updated_at']));
                }
            }

            return [
                'quotes'  => $quotes,
                'total'   => $total,
                'hasNext' => $hasNext,
            ];
            
        } 
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function findOne(int|string $id)
    {
        try {
            $userAuth = $this->jwt->user();

            $quote = $this->quoteRepository->find($id, $userAuth['id']);

            if (!$quote) return ['error' => "Sorry, we couldn't find this quote."];

            $quote['created_at'] = date('d/m/Y H:i:s', strtotime($quote['created_at']));

            if (!is_null($quote['updated_at'])) {
                $quote['updated_at'] = date('d/m/Y H:i:s', strtotime($quote['updated_at']));
            }

            return [
                'success' => $quote
            ];
            
        } 
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function updateQuote(array $data, int|string $id)
    {
        try {
            $userAuth = $this->jwt->user();

            $fields = [
                [$data['quote']  ?? '', 'required'],
                [$data['author'] ?? '', 'required']
            ];

            $this->validator->validate($fields);

            $quote = $this->quoteRepository->update($data, $id, $userAuth['id']);

            if (!$quote) return ['error' => "Sorry, we couldn't update this quote."];

            return [
                'success' => 'Quote updated successfully.'
            ];
        }
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }

    public function deleteQuote(int|string $id)
    {
        try {
            $userAuth = $this->jwt->user();

            $quote = $this->quoteRepository->remove($id, $userAuth['id']);

            if (!$quote) return ['error' => "Sorry, we couldn't delete this quote."];

            return [
                'success' => 'Quote deleted successfully.'
            ];
        }
        catch (\PDOException $error) { return ['error' => "Sorry, something went wrong."]; }
        catch (\Exception $error)    { return ['error' => $error->getMessage()]; }
    }
}   