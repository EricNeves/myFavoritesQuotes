<?php 

error_reporting(0);

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__.'/src/config/bootstrap.php';
require_once __DIR__.'/src/routes/main.php';
require_once __DIR__.'/src/config/database.php';
require_once __DIR__.'/src/config/cors.php';

$factories = require_once __DIR__.'/src/config/factories.php';

date_default_timezone_set('America/Sao_Paulo');

/**
 * CORS - Cross-Origin Resource Sharing
 */
allowCors();

dispatch(App\Http\Route::getRoutes(), $factories, $pdo);