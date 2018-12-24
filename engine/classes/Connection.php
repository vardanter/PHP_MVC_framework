<?php

namespace engine\classes;

use engine\Debug;

class Connection
{
    private static $_connection;
    public $pdo;

    private function __construct(array $config)
    {
        try {
            $this->pdo = new \PDO($config['dsn'], $config['user'], $config['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            Debug::logToFile($e->getTraceAsString());
        }
    }

    private function __clone()
    {}

    public static function instance(array $config = [])
    {
        if (self::$_connection === null) {
            self::$_connection = new self($config);
        }
        return self::$_connection;
    }
}