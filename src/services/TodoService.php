<?php

namespace Gambio\Services;

use Gambio\Models\Todo;
use Gambio\Models\TodoParticipant;
use Gambio\Models\TodoTask;
use Gambio\Services\EmailService;
use Ramsey\Uuid\Uuid;

class TodoService extends EmailService
{
    // Create Todo
    public function createTodo($data, $participants = [])
    {
        $todo = new Todo();

        //  Generate and add uuid to todo
        $uuid = Uuid::uuid4();
        $data['uuid'] = $uuid;

        $todoId = $todo->create($data);

        //  Add todo participants
        if ($todoId) $this->addParticipant($todoId, $participants);
        return $todoId;
    }

    //  Get Todo Url
    public function getTodoUrl($todoId)
    {
        $todo = new Todo();
        $todoItem = $todo->findByValue('id', $todoId);
        return "https://todo.gambio.com?item=" . $todoItem['uuid'] ?? null;
    }

    // Add Participants
    public function addParticipant($todoId, $participantData)
    {
        $participant = new TodoParticipant();
        foreach ($participantData as $email) {
            $participant->create(["todoId" => $todoId, "participant_email" => $email]);
        }
        //  Send email to collaborators
        $subject = "You have been invited to collaborate!";
        $message  = "You have been invited to collaborate in a Todo Task!<br>";
        $message  .= "Please click on the link below to participate:<br><br>";
        $message  .= "<a href=" . $this->getTodoUrl($todoId) . ">  Gambio Todo </a>";
        $this->sendMail($email, $message, $subject);
    }

    //  Get Todo and corresponding tasks
    public function getTodo($uuid)
    {
        $todos = new Todo();
        $result = $todos->findByValue('uuid', $uuid);

        $tasks = new TodoTask();
        $result['tasks'] = $tasks->findByValue('todoId', $result['id']) ?? [];
        return $result;
    }
    //  Add todo task
    public function createTask($data)
    {
        $task = new TodoTask();
        return $task->create($data);
    }
}
