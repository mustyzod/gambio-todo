<?php

use Gambio\Services\TodoService;

class TodoController
{
    /**
     * Create Todo
     */
    public function createTodo($data, $participants)
    {
        $todo = new TodoService();
        $result = $todo->createTodo($data, $participants);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "todoId" => $result,
            "message" => "Todo Creation Successful!!"
        ]);
    }

    /**
     * Add participants
     */
    public function inviteParticipants()
    {
    }

    /**
     * Get Todo
     */
    public function getTodo()
    {
    }

    /**
     * Update Todo Task
     */
    public function updateTodoTask()
    {
    }

    /**
     * Delete Todo Task
     */
    public function deleteTodoTask()
    {
    }
}
