<?php

namespace Tamm\Framework\Database;


class SqlserverDatabase implements IDatabase
{
    private DatabaseConnectionInfo $connectionInfo;
    private $connection;

    public function __construct(DatabaseConnectionInfo $connectionInfo)
    {
        $this->connectionInfo = $connectionInfo;
    }

    public function connect()
    {
        // Connect to SQL Server database
    }
    public function disconnect()
    {
        // Connect to MySQL database
    }
    public function query($sql)
    {
        // Execute SQL Server query
    }

    // Implement other SQL Server-specific methods
    public function select($table, $args = array())
    {
    }
    public function insert($table, $data)
    {
    }
    public function update($table, $data, $args = array())
    {
    }
    public function delete($table, $args = array())
    {
    }
}