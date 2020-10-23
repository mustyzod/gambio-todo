<?php

namespace Gambio\Models;

use Gambio\Connections\Connection as Database;

class TodoTask extends Database
{
    private $table = 'todo_tasks';

    public function __construct()
    {
        parent::__construct($this->table);
        $this->createIfNotExist();
    }

    /**
     * Create table if not exist
     * 
     * @return void
     */
    public function createIfNotExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            task VARCHAR(30) NOT NULL,
            todoId int(11),
            status BOOLEAN DEFAULT 0,
            deadline TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL
            )";
        $this->connect();
        mysqli_query($this->instance, $sql);
    }
}
