<?php

declare(strict_types=1);

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Exception\ExceptionHandler;
use App\Exception\DatabaseConnectionException;
use App\Helpers\Config;
use App\Database\PDOConnection;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/Exception/exception.php';

$mysql = new MySQLiConnection(
    array_merge(
        Config::get('database', 'mysqli'),
        ['db_name' => 'bug_tracker_testing']
    )
);
$queryBuilder = new MySQLiQueryBuilder($mysql->connect());
$results = $queryBuilder
    ->table('reports')
    ->select('*')
    ->where('id', 2)
    ->get()
    ->first();

// $data = $results->get_result();
// $data_fetched = $data->fetch_assoc();

echo "<pre>";
print_r($results);
echo "</pre>";


// $conn = $mysql->getConnection();
// // $qry = "SELECT * FROM reports";
// // echo "<pre>";
// // print_r($conn->query($qry)->fetch_all(MYSQLI_ASSOC));
// // echo "</pre>";
// // $stmt = $conn->prepare("SELECT * FROM reports where id = ?");
// // $bindings = array("i", 3);
// // var_dump($bindings);
// // $id = 3;
// // $stmt->bind_param("i", $id);
// // $stmt->execute();
// // $result = $stmt->get_result();
// // echo "<pre>";
// // print_r($result->fetch_object());
// // echo "</pre>";
// $id = 3;
// $sql = "SELECT * FROM reports WHERE id=?"; // SQL with parameters
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result(); // get the mysqli result
// $user = $result->fetch_assoc(); // fetch data   

// echo "<pre>";
// print_r($user);
// echo "</pre>";
