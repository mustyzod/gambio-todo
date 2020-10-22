<?php
namespace Gambio\Controllers;
use Gambio\Services\TodoService;

class TodoController extends TodoService
{
    /**
     * Create Todo
     */
    public function createTodoList($data, $participants)
    {
        $result = $this->createTodo($data, $participants);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $result,
            "message" => "Todo Creation Successful!!"
        ]);
    }

    /**
     * Add participants
     */
    public function inviteParticipants($todoId,$participants)
    {
        $addParticipant = $this->addParticipant($todoId,$participants);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $addParticipant,
            "message" => "Participants Successfully Added!!"
        ]);
    }

    /**
     * Get Todo
     */
    public function fetchTodo($uuid)
    {
        $result = $this->getTodo($uuid);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $result,
            "message" => "Participants Successfully Added!!"
        ]);
    }
    /**
     *  Create Todo Task
     */
    public function createTodoTask($data){
        $result = $this->createTask($data);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "task" => $result,
            "message" => "Todo Creation Successful!!"
        ]);
    }

    /**
     * Update Todo Task
     */
    public function updateTodoTask($taskId,$data)
    {
        $result = $this->updateTask($taskId,$data);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $result,
            "message" => "Task Successfully Updated!!"
        ]);
    }

    /**
     * Delete Todo Task
     */
    public function deleteTodoTask($taskId)
    {
        $result = $this->deleteTask($taskId);
        header('Content-type:application/json;charset=utf-8');
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $result,
            "message" => "Task Deleted!!"
        ]);
    }
}
