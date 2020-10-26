<?php

namespace Gambio\Services;

class Connection
{
    protected $instance;
    private $dbName;
    private $host;
    private $username;
    private $password;
    private $table;

    public function __construct($table)
    {
        $this->dbName = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->table = $table;
    }

    /**
     * Connect database
     */
    public function connect()
    {
        $connection = new \mysqli($this->host, $this->username, $this->password, $this->dbName);
        // Check connection
        if ($connection->connect_errno) die('Could not connect to database!');

        $this->instance = $connection;
        return $this->instance;
    }
    /**
     * Create data
     */
    public function create($dataArray)
    {
        $getColumnsKeys = array_keys($dataArray);
        $implodeColumnKeys = implode(",", $getColumnsKeys);

        $getValues = array_values($dataArray);
        // var_dump($getValues);
        // exit;
        $implodeValues = "'" . implode("','", $getValues) . "'";

        $qry = "insert into $this->table (" . $implodeColumnKeys . ") values (" . $implodeValues . ")";
        $result = $this->instance->query($qry);
        if (!$result) return false;

        return $this->instance->insert_id;
    }
    /**
     * Update or Create if not exist
     */
    public function upsert($dataArr)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE ";
        foreach ($dataArr as $key => $data) {
            $query .= $key . "='" . $data . "' AND ";
        }
        $query .= " deleted_at IS NULL";
        $result = $this->instance->query($query);
        $result = mysqli_fetch_assoc($result);
        //  return if data already exist
        if ($result) return;
        //  Create data
        return $this->create($dataArr);
    }
    /**
     * Fetch all
     */
    public function findAll()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE deleted_at IS NULL";
        $results = $this->instance->query($query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($results)) {
            $rows[] = $row;
        }
        return $rows ?? [];
    }
    /**
     * Search
     */
    public function findOne($searchParam, $searchValue)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $searchParam . "='" . $searchValue . "' AND deleted_at IS NULL";
        $result = $this->instance->query($query);
        $result = mysqli_fetch_assoc($result);
        return $result ?? Null;
    }
    /**
     * Fetch single Todo with parameter
     */
    public function findByValue($searchParam, $searchValue)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $searchParam . "='" . $searchValue . "' AND deleted_at IS NULL";
        $result = $this->instance->query($query);
        // $result = $result->fetch_assoc();
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows ?? [];
        // return $result ?? Null;
    }
    /**
     * Update Todo
     */
    public function update($id, $data)
    {
        $cols = array();
        foreach($data as $key=>$val) {
            if($val != NULL) // check if value is not null then only add that colunm to array
            {
            $cols[] = "$key = '$val'"; 
            }
        }
        $sql = "UPDATE $this->table SET " . implode(', ', $cols) . " WHERE id=$id AND deleted_at IS NULL";

        $result = $this->instance->query($sql);
        return($result);
    }
    /**
     * Delete data
     */
    public function destroy($id)
    {
        $query = "UPDATE " . $this->table . " SET deleted_at='" . date('Y-m-d H:i:s') . "' WHERE id=" . $id;
        $result = $this->instance->query($query);
        return $result;
    }
    /**
     * 
     */
    public function closeConnection()
    {
        mysqli_close($this->instance);
    }
}
