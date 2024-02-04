<?php 

use App\Http\Response;

try {
    $pdo = new PDO(
        'pgsql:host='. $_ENV['DATABASE_HOST'] .';port='. $_ENV['DATABASE_PORT'] .';dbname='. $_ENV['DATABASE_NAME'] .'', 
        $_ENV['DATABASE_USER'], 
        $_ENV['DATABASE_PASS']
    );

} catch (PDOException $e) {
    Response::json([
        'error'   => true,
        'success' => false,
        'message' => 'Sorry, database connection error.'
    ]);
    exit;
}