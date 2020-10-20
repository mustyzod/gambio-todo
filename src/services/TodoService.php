<?php

namespace Gambio\Services;

use Gambio\Models\Todo;
use Gambio\Models\TodoParticipant;

class TodoService
{

    public function createTodo($data)
    {
        $todo = new Todo();
        $todoId = $todo->create($data);
        if ($todoId) {
            $participantData = [
                "todoId" => $todoId,
                "participant_email" => $data['email']
            ];
            $this->createParticipant($participantData);
        }
    }
    public function createParticipant($participantData)
    {
        $participant = new TodoParticipant();
        $participant->create($participant);
    }
}
