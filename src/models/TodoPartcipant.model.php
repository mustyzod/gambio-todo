<?php

namespace Gambio\Models;

<<<<<<< HEAD:src/Models/TodoParticipant.php
use Gambio\Services\Database;
=======
use Gambio\Services\Connection as Database;
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c:src/models/TodoPartcipant.model.php

class TodoParticipant extends Database
{
    private $table = 'todo_participants';

    public function __construct()
    {
        parent::__construct($this->table);
        $this->createIfNotExist();
    }

    /**
     * Create table if not exist
     */
    public function createIfNotExist()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            todoId INT(11) NOT NULL,
            participant_email VARCHAR(50) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL
            )";
        $this->connect();
        mysqli_query($this->instance, $sql);
    }
}
