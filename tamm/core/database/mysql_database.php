<?php

namespace Tamm\Core\Database;

use Exception;
use mysqli;

class MysqlDatabase implements DatabaseInterface
{
    private DatabaseConnectionInfo $connectionInfo;
    private $connection;

    public function __construct(DatabaseConnectionInfo $connectionInfo)
    {
        $this->connectionInfo = $connectionInfo;
    }

    public function connect()
    {
        $this->connection = new mysqli($this->connectionInfo->getHost(), $this->connectionInfo->getUsername(), $this->connectionInfo->getPassword(), $this->connectionInfo->getDatabase(), intval($this->connectionInfo->getPort()));
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function disconnect()
    {
        $this->connection->close();
        if ($this->connection->connect_error) {
        }
    }

    public function query($sql)
    {
        try {
            $result = mysqli_query($this->connection, $sql);
            if (!$result) {
                throw new Exception(mysqli_error($this->connection));
            }
        } catch (Exception $e) {
            return array("status" => false, "code" => 403, "message" => $e->getMessage());
        }

        // return $result;
        return array("status" => true, "code" => 201, "result" => $result);
    }

    public function select($table, $args = array())
    {

        $columns = "*";
        if (isset($args['columns'])) {
            $columns = $args['columns'];
            if (is_array($columns)) {
                $columns = implode(", ", $columns);
            }
        }

        $sql = "SELECT $columns FROM $table";

        if (isset($args['where'])) {
            $where = $args['where'];
            if (is_array($where) && !empty($where)) {
                $whereClause = $this->buildWhereClause($where);
                $sql .= " WHERE $whereClause";
            } else if (!empty($where)) {
                $sql .= " WHERE $where";
            }
        }
        if (isset($args['orderby'])) {
            $orderBy = $args['orderby'];
            $orderByColumn = $orderBy['column'];
            $orderByType = $orderBy['value'] ?? "ASC";
            if (!empty($orderByColumn)) {
                $orderByTypes = array('ASC', 'DESC');
                if (in_array($orderByType, $orderByTypes)) {
                    $sql .= " ORDER BY $orderByColumn $orderByType";
                }
            }
        }

        if (isset($args['limit'])) {
            $count = $args['limit']['value'];
            $offset = isset($args['limit']['offset']) ? $args['limit']['offset'] . "," : "";
            $sql .= " LIMIT $offset $count";
        }
        $exeute = $this->query($sql);
        if ($exeute["status"]) {
            $result = $exeute["result"];
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return array("status" => false, "code" => 404, "message" => $exeute["message"]);
        }
    }

    public function insert($table, $data)
    {

        // $columns = implode(", ", array_keys($data));
        // $values = "'" . implode("', '", array_values($data)) . "'";

        $columns = implode(", ", array_keys($data));
        $values = '';

        foreach ($data as $value) {
            if (is_int($value) || is_float($value)) {
                $values .= $value . ', ';
            } elseif (is_bool($value)) {
                $values .= ($value ? 'TRUE' : 'FALSE') . ', ';
            } else {
                $values .= "'" . $this->escapeValue($value) . "', ";
            }
        }

        $values = rtrim($values, ', ');

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        $this->query($sql);

        $result = mysqli_insert_id($this->connection);
        if (!$result) {
            return array("status" => false, "code" => 405, "message" => mysqli_error($this->connection));
        }
        return array("status" => true, "code" => 200, "value" => $result);
    }

    public function update($table, $data, $args = array())
    {

        $set = "";

        foreach ($data as $column => $value) {
            $set .= "$column = '$value', ";
        }

        $set = rtrim($set, ", ");

        $sql = "UPDATE $table SET $set";

        if (isset($args['where'])) {
            $where = $args['where'];
            if (is_array($where) && !empty($where)) {
                $whereClause = $this->buildWhereClause($where);
                $sql .= " WHERE $whereClause";
            } else if (!empty($where)) {
                $sql .= " WHERE $where";
            }
        }
        return $this->query($sql);
    }

    public function delete($table, $args = array())
    {

        $sql = "DELETE FROM $table";

        if (isset($args['where'])) {
            $where = $args['where'];
            if (is_array($where) && !empty($where)) {
                $whereClause = $this->buildWhereClause($where);
                $sql .= " WHERE $whereClause";
            } else if (!empty($where)) {
                $sql .= " WHERE $where";
            }
        }

        $result = $this->query($sql);

        return $result;
    }

    private function escapeValue($value)
    {
        return mysqli_real_escape_string($this->connection, $value);
    }

    private function buildWhereClause($where)
    {
        $conditions = [];

        foreach ($where as $condition) {
            $column = $this->escapeValue($condition['column']);
            $operator = $this->escapeValue($condition['operator']);
            $value = $this->escapeValue($condition['value']);

            // Handle different operators
            switch ($operator) {
                case '=':
                case '!=':
                case '<>':
                case '<':
                case '>':
                case '<=':
                case '>=':
                    $conditions[] = "$column $operator '$value'";
                    break;
                case 'IN':
                    if (is_array($value)) {
                        $escapedValues = array_map([$this, 'escapeValue'], $value);
                        $conditions[] = "$column IN ('" . implode("', '", $escapedValues) . "')";
                    }
                    break;
                case 'NOT IN':
                    if (is_array($value)) {
                        $escapedValues = array_map([$this, 'escapeValue'], $value);
                        $conditions[] = "$column NOT IN ('" . implode("', '", $escapedValues) . "')";
                    }
                    break;
                case 'LIKE':
                    $conditions[] = "$column LIKE '$value'";
                    break;
                case 'NOT LIKE':
                    $conditions[] = "$column NOT LIKE '$value'";
                    break;
                case 'IS NULL':
                    $conditions[] = "$column IS NULL";
                    break;
                case 'IS NOT NULL':
                    $conditions[] = "$column IS NOT NULL";
                    break;
                default:
                    // Handle custom operators or unrecognized operators
                    $conditions[] = "$column $operator '$value'";
                    break;
            }
        }

        $out = implode(" AND ", $conditions);
        return $out;
    }
}
