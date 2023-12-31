<?php

namespace Tamm\Framework\Database;


interface IDatabase
{
    public function connect(); //DatabaseConnection $connection
    public function disconnect();
    public function query($sql);
    public function select($table, $args = array());
    public function insert($table, $data);
    public function update($table, $data, $args = array());
    public function delete($table, $args = array());
}