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
        try {
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
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }

    /**
     * Add participants
     */
    public function inviteParticipants($uuid, $request)
    {
        try {
            $participants = $request->getInput('participants');
            $result = $this->addParticipant($uuid, $participants);
            Response::json($result, 'Participants Successfully Added!');
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }

    /**
     * Get Todo
     */
    public function fetchTodo($uuid)
    {
        try {
            $result = $this->getTodo($uuid);
            Response::json($result, 'Data Successfully fetched!');
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }
    /**
     *  Create Todo Task
     */
    public function createTodoTask($request)
    {
        try {
            foreach ($request->getInput() as $key => $task) {
                $todoTask[$key] = $task;
            }
            $result = $this->createTask($todoTask);
            Response::json($result, 'Todo Creation Successful!!');
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }

    /**
     * Update Todo Task
     */
    public function updateTodoTask($taskId, $request)
    {
        try {
            foreach ($request->getInput() as $key => $task) {
                $todoTask[$key] = $task;
            }
            $result = $this->updateTask($taskId, $todoTask);
            Response::json($result, 'Task Successfully Updated!');
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }

    /**
     * Delete Todo Task
     */
    public function deleteTodoTask($taskId)
    {
        try {
            $result = $this->deleteTask($taskId);
            Response::json($result, 'Task Deleted!');
        } catch (\Exception $e) {
            Response::json([], $e->getMessage(), 400);
        }
    }
}
