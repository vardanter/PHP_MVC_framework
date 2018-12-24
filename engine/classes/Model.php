<?php

namespace engine\classes;

use engine\Application;

class Model
{
    protected $validator;
    protected $connection;
    protected $sql;
    protected $params;
    protected $statement;
    protected $table;
    protected $errors;

    public function __construct()
    {
        $dbConfig = (array)Application::instance()->getConfig()->db;
        $this->connection = Connection::instance($dbConfig);
    }

    public function __get($name)
    {
        return property_exists($this, $name) ? $this->{$name} : null;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }

    protected function validate()
    {
        return $this->validator !== null ? $this->validator->validate() : true;
    }

    public function setErrors(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return !empty($this->errors) ? $this->errors : [];
    }

    protected function addError(string $attr, array $error)
    {
        $this->errors[$attr] = $error;
    }

    protected function beforeSave()
    {

    }

    public function find(string $select = '*', string $condition = '', array $params = [])
    {
        $this->sql = 'SELECT ' . $select . ' FROM ' . $this->table;

        if (!empty($condition)) {
            $this->sql .= ' WHERE ' . $condition;
        }

        $this->params = $params;

        return $this;
    }

    public function one()
    {
        $this->sql .= ' LIMIT 1';
        $this->statement = $this->connection->pdo->prepare($this->sql);

        if (!empty($this->params)) {
            foreach ($this->params as $name => $param) {
                $type = isset($param['type']) ? $param['type'] : '';
                !empty($type) ?
                    $this->statement->bindParam($name, $param['value'], $type) :
                    $this->statement->bindParam($name, $param['value']);
            }
        }
        $this->statement->execute();

        $data = $this->statement->fetch(\PDO::FETCH_OBJ);
        if (empty($data)) {
            return null;
        }
        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }
        return $this;
    }

    public function all()
    {
        $this->statement = $this->connection->pdo->prepare($this->sql);

        if (!empty($this->params)) {
            foreach ($this->params as $name => $param) {
                $type = isset($param['type']) ? $param['type'] : '';
                !empty($type) ?
                    $this->statement->bindParam($name, $param['value'], $type) :
                    $this->statement->bindParam($name, $param['value']);
            }
        }
        $this->statement->execute();

        return $this->statement->fetchAll(\PDO::FETCH_OBJ);
    }
}