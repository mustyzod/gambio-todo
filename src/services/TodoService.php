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
        if ($todoId) {
            $this->addParticipant($uuid, $participants);
            return $todo->findOne('id', $todoId);
        }
    }

    // Add Participants
    public function addParticipant($uuid, $participantData = [])
    {
        $todoInstance = new Todo();
        $todo = $todoInstance->findOne('uuid', $uuid);
        if ($todo) {
            $participant = new TodoParticipant();
            foreach ($participantData as $email) {
                $tr = $participant->create(["todoId" => $todo['id'], "participant_email" => $email]);
                //  Send email to collaborators
                $subject = "You have been invited to collaborate!";
                $message  = "You have been invited to collaborate in a Todo Task!<br>";
                $message  .= "Please click <a href=".$_ENV['FRONTEND_URL']."/todo/tid=".$uuid."> participate</a> inorder to collaborate.<br><br>";
                $message  .= "Cheers<br/>";
                $message  .= "<b>Gambio Team</b>";
                $this->sendMail($email, $message, $subject);
            }
        }
    }

    //  Get Todo and corresponding tasks
    public function getTodo($uuid)
    {
        $todos = new Todo();
        $result = $todos->findOne('uuid', $uuid);

        $tasks = new TodoTask();
        $result['tasks'] = $tasks->findByValue('todoId', $result['id']) ?? [];

        $participants = new TodoParticipant();
        $result['participants'] = $participants->findByValue('todoId',$result['id']);
        return $result;
    }
    //  Add Todo Task
    public function createTask($data)
    {
        $task = new TodoTask();
        $taskId = $task->create($data);
        return $task->findOne('id', $taskId);
    }

    //  Update Todo Task
    public function updateTask($taskId, $data)
    {
        $update = new TodoTask();
        $update->update($taskId, $data);
        return $update->findOne('id', $taskId);
    }

    //  Delete Todo Task
    public function deleteTask($taskId)
    {
        $task = new TodoTask();
        $resource = $task->findOne('id', $taskId);
        if ($resource) {
            $todoId = $resource['todoId'];
            $deleteTask = $task->destroy($resource['id']);
            if ($deleteTask) {
                //  Delete Associated Todo
                $todo = new Todo();
                $todo->destroy($todoId);
                //  Delete Associated Participant
                $todoParticipant = new TodoParticipant();
                $allParticipants = $todoParticipant->findByValue('todoId', $todoId);
                foreach ($allParticipants as $participant) {
                    $todoParticipant->destroy($participant['id']);
                    //  Send email to collaborators
                    $subject = "Todo Task Update!";
                    $message  = "A task has been deleted from the todo list in which you are a collaborator.<br>";
                    $message  .= "Find the details of the deleted task below:<br><br>";
                    $message  .= "<b>Task:</b> " . $resource['task'] . "<br>";
                    $message  .= "<b>Date Created:</b> " . date('d F, Y h:i', strtotime($resource['created_at'])) . "<br>";
                    if ($resource['updated_at']) $message  .= "<b>Last Updated:</b> " . date('d F, Y h:i', strtotime($resource['updated_at'])) . "<br>";
                    $message  .= "<b>Date Deleted:</b> " . date('d F, Y h:i') . "<br/><br/>";
                    $message  .= "<b>Gambio Team</b>";
                    // $this->sendMail($participant['participant_email'], $message, $subject);
                }
            }
        }
    }
}
