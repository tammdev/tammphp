<?php

namespace Tamm\Framework\Database;

use Exception;

class DatabaseFactory
{
    public static function createDatabase(Database $db)
    {
        switch ($db->getType()) {
            case 'mysql':
                return new MySQLDatabase($db->getConnectionInfo());
            case 'mongodb':
                return new MongoDBDatabase($db->getConnectionInfo());
            case 'sqlserver':
                return new SQLServerDatabase($db->getConnectionInfo());
            default:
                // TODO specify the error number.
                throw new Exception('Invalid database type specified.',0);
        }
    }
}
