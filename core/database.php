<?php

namespace Tamm\Core;

class Database
{
    protected static $instance;
    protected $connection;

    private function __construct()
    {
        // Establish database connection (e.g., using PDO)
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        // Execute the SQL query (e.g., using PDO)
    }

    // Additional database methods...
}