<?php

namespace Tamm\Framework\Database;

// You can instancitate an object from this class only using builder method.
class DatabaseConnectionInfo
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $database;

    private function __construct()
    {
        // Private constructor to enforce the use of the builder
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public static function Builder()
    {
        return new DatabaseConnectionInfoBuilder(new self());
    }
}

// You can not instancitate an object from this class directely.
class DatabaseConnectionInfoBuilder
{
    private DatabaseConnectionInfo $connectionInfo;

    public function __construct(DatabaseConnectionInfo $connectionInfo)
    {
        $this->connectionInfo = $connectionInfo;
    }

    public function withHost($host)
    {
        $this->connectionInfo->setHost($host);
        return $this;
    }

    public function withPort($port)
    {
        $this->connectionInfo->setPort($port);
        return $this;
    }

    public function withUsername($username)
    {
        $this->connectionInfo->setUsername($username);
        return $this;
    }

    public function withPassword($password)
    {
        $this->connectionInfo->setPassword($password);
        return $this;
    }

    public function withDatabase($database)
    {
        $this->connectionInfo->setDatabase($database);
        return $this;
    }

    public function build()
    {
        if (($this->connectionInfo->getHost() !== "")
            && ($this->connectionInfo->getPort() !== "")
            && ($this->connectionInfo->getUsername() !== "")
            // && ($this->connectionInfo->getPassword() !== "")
            && ($this->connectionInfo->getDatabase() !== "")
        ) {
            return $this->connectionInfo;
        }
        return null;
    }
}