<?php

namespace App\Database;

use App\Exception\InvalidArgumentException;
use ReflectionClass;

class MySQLiQueryBuilder extends QueryBuilder
{
    private $resultSet;
    private $results;

    const PARAM_TYPE_INT = 'i';
    const PARAM_TYPE_STRING = 's';
    const PARAM_TYPE_DOUBLE = 'd';

    public function get()
    {
        if (!$this->resultSet) {
            $this->resultSet = $this->statement->get_result();
            $this->results = $this->resultSet->fetch_all(MYSQLI_ASSOC);
        }
        return $this->results;
    }

    public function count()
    {
        if (!$this->resultSet) {
            $this->get();
        }
        return $this->resultSet ? $this->resultSet->num_rows : false;
    }

    public function lastInsertedId()
    {
        return $this->connection->insert_id;
    }

    public function prepare($qry)
    {
        return $this->connection->prepare($qry);
    }

    public function execute($statement)
    {
        if (!$statement) {
            throw new InvalidArgumentException('MySQLi statement is false');
        }

        if ($this->bindings) {
            $bindings = $this->parseBindings($this->bindings);
            $reflectionObj = new ReflectionClass('mysqli_stmt');
            $method = $reflectionObj->getMethod('bind_param');
            $method->invokeArgs($statement, $bindings);
        }

        $statement->execute();
        $this->bindings = [];
        $this->placeholders = [];

        return $statement;
    }

    public function parseBindings(array $params)
    {
        $bindings = [];
        // dynamic binding
        $count = count($params);
        if ($count === 0) {
            return $this->bindings;
        }

        $bindingTypes = $this->parseBindingTypes();
        $bindings[] = &$bindingTypes;
        for ($i = 0; $i < $count; $i++) {
            $bindings[] = &$params[$i];
        }
        return $bindings;
    }

    public function parseBindingTypes()
    {
        $bindingTypes = [];
        foreach ($this->bindings as $binding) {
            if (is_int($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_INT;
            }

            if (is_string($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_STRING;
            }

            if (is_float($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_DOUBLE;
            }
        }
        return implode('', $bindingTypes);
    }

    public function fetchInto($className)
    {
        $results = [];
        $this->resultSet = $this->statement->get_result();

        return $this->results = $results;
    }
}
