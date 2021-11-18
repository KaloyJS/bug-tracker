<?php

namespace App\Database;

use App\Database\QueryBuilder;
use PDO;

class PDOQueryBuilder extends QueryBuilder
{
    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function count()
    {
        return $this->statement->rowCount();
    }
    public function lastInsertedId()
    {
        return $this->connection->lastInsertId();
    }
    public function prepare($qry)
    {
        return $this->connection->prepare($qry);
    }
    public function execute($statement)
    {
        $statement->execute($this->bindings);
        $this->bindings = [];
        $this->placeholders = [];
        return $statement;
    }
    public function fetchInto($className)
    {
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $className);
    }
}
