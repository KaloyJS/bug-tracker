<?php

declare(strict_types=1);

use App\Exception\ExceptionHandler;
use App\Exception\DatabaseConnectionException;
use App\Helpers\Config;
use App\Database\PDOConnection;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/Exception/exception.php';


// $credentials = Config::get('database', 'pdo');
// $conn = new PDOConnection($credentials);
// $connection = $conn->getConnection();




try {
    $conn = new PDO("mysql:host=localhost;dbname=bug_tracker", "kaloy", "Kikyam123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->credentials['default_fetch']);
} catch (PDOException $exception) {
    throw new DatabaseConnectionException($exception->getMessage(), [], 500);
}


$qry = "SELECT * FROM `test`";
$res = $conn->query($qry)->fetchAll();
var_dump($res);
