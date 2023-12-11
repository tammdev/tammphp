<?php

namespace Tamm\Framework\Database;

class Database
{
    private $type;
    private DatabaseConnectionInfo $connectionInfo;
    private IDatabase $database;
    private static $instance = null;

    protected function __construct($type, DatabaseConnectionInfo $connectionInfo)
    {
        $this->type = $type;
        $this->connectionInfo = $connectionInfo;
    }

    public function getType() : string
    {
        return $this->type;
    }
    public function getConnectionInfo() : DatabaseConnectionInfo
    {
        return $this->connectionInfo;
    }
    public static function getInstance($type, DatabaseConnectionInfo $connectionInfo)
    {
        if (self::$instance === null) {
            self::$instance = new self($type, $connectionInfo);
        }
        return self::$instance;
    }

    public function __destruct()
    {
        $this->database->disconnect();
    }

    public function getDatabase()
    {
        $this->database = DatabaseFactory::createDatabase(self::$instance);
        // $this->database->connect();
        return $this->database;
    }
}
