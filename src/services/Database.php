<?php
// Autoload required classes
namespace Gambio\Connections;

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
     * 
     */
    public function connect()
    {
        $connection = new \mysqli($this->host, $this->username, $this->password, $this->dbName);
        if (!$connection) die('Could not connect to database!');
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
        $implodeValues = "'" . implode("','", $getValues) . "'";

        $qry = "insert into $this->table (" . $implodeColumnKeys . ") values (" . $implodeValues . ")";
        $this->instance->query($qry);
        return $this->instance->insert_id;
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
    public function findById($searchValue)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id='" . $searchValue . "' AND deleted_at IS NULL";
        $results = $this->instance->query($query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($results)) {
            $rows[] = $row;
        }
        return $rows ?? [];
    }
    /**
     * Fetch single Todo with parameter
     */
    public function findByValue($searchParam, $searchValue)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $searchParam . "='" . $searchValue . "' AND deleted_at IS NULL";
        $result = $this->instance->query($query);
        $result = $result->fetch_assoc();
        return $result ?? Null;
    }
    /**
     * Update Todo
     */
    public function update($id, $data)
    {
        $update = 'UPDATE ' . $this->table . ' SET ';
        $keys = array_keys($data);
        for ($i = 0; $i < count($data); $i++) {
            if (is_string($data[$keys[$i]])) {
                $update .= $keys[$i] . '="' . $data[$keys[$i]] . '"';
            } else {
                $update .= $keys[$i] . '=' . $data[$keys[$i]];
            }

            // Parse to add commas
            if ($i != count($data) - 1) {
                $update .= ',';
            }
        }
        $update .= 'WHERE id=' . $id . " AND deleted_at IS NULL";

        $result = $this->instance->query($update);
        if ($result) true ?? false;
    }
    /**
     * Delete data
     */
    public function destroy($uuid)
    {
        $query = "UPDATE " . $this->table . " SET deleted_at='" . date('Y-m-d H:i:s') . "' WHERE uuid=" . $uuid;
        $result = $this->instance->query($query);
    }
    /**
     * 
     */
    public function closeConnection()
    {
        mysqli_close($this->instance);
    }
}
