<?php

return [
    'pdo' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'db_name' => 'bug_tracker',
        'db_username' => 'kaloy',
        'db_user_password' => 'Kikyam123',
        'default_fetch' => PDO::FETCH_OBJ,
    ],
    'mysqli' => [
        'host' => 'localhost',
        'db_name' => 'bug_tracker',
        'db_username' => 'kaloy',
        'db_user_password' => 'Kikyam123',
        'default_fetch' => MYSQLI_ASSOC,
    ]
];
