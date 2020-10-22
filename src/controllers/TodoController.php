<?php

namespace Gambio\Controllers;

use Gambio\Services\TodoService;
use Gambio\Router\Request;
use Gambio\Router\Response as Response;

class TodoController extends TodoService
{
    /**
     * Create Todo
     */
    public function createTodoList($request)
    {
        $participants = [];
        foreach ($request->getInput() as $key => $todo) {
            if (gettype($todo) === 'array') {
                $participants = $todo;
            } else {
                $todoData[$key] = $todo;
            }
        }
        $result = $this->createTodo($todoData, $participants);
        Response::json($result, 'Todo Creation Successful!');
    }

    /**
     * Add participants
     */
    public function inviteParticipants($uuid, $request)
    {
        $participants = $request->getInput('participants');
        $result = $this->addParticipant($uuid, $participants);
        Response::json($result, 'Participants Successfully Added!');
    }

    /**
     * Get Todo
     */
    public function fetchTodo($uuid)
    {
        $result = $this->getTodo($uuid);
        Response::json($result, 'Participants Successfully fetched!');
    }
    /**
     *  Create Todo Task
     */
    public function createTodoTask($request)
    {
        foreach ($request->getInput() as $key => $task) {
            $todoTask[$key] = $task;
        }
        $result = $this->createTask($todoTask);
        Response::json($result, 'Todo Creation Successful!!');
    }

    /**
     * Update Todo Task
     */
    public function updateTodoTask($taskId, $request)
    {
        foreach ($request->getInput() as $key => $task) {
            $todoTask[$key] = $task;
        }
        $result = $this->updateTask($taskId, $todoTask);
        Response::json($result, 'Task Successfully Updated!');
    }

    /**
     * Delete Todo Task
     */
    public function deleteTodoTask($taskId)
    {
        $result = $this->deleteTask($taskId);
        Response::json($result, 'Task Deleted!');
    }
}
