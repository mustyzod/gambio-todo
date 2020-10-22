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
            $this->addParticipant($todoId, $participants);
            return $todo->findOne('id',$todoId);
        }
    }

    //  Get Todo Url
    public function getTodoUrl($todoId)
    {
        $todo = new Todo();
        $todoItem = $todo->findOne('id',$todoId);
        return "https://todo.gambio.com?tid=" . $todoItem['uuid'] ?? null;
    }

    // Add Participants
    public function addParticipant($todoId, $participantData=[])
    {
        $participant = new TodoParticipant();
        foreach ($participantData as $email) {
            $participant->create(["todoId" => $todoId, "participant_email" => $email]);
            //  Send email to collaborators
            $subject = "You have been invited to collaborate!";
            $message  = "You have been invited to collaborate in a Todo Task!<br>";
            $message  .= "Please click on the link below to participate:<br><br>";
            $message  .= "<a href=" . $this->getTodoUrl($todoId) . ">  Gambio Todo </a>";
            // $this->sendMail($email, $message, $subject);
        }
    }

    //  Get Todo and corresponding tasks
    public function getTodo($uuid)
    {
        $todos = new Todo();
        $result = $todos->findOne('uuid', $uuid);

        $tasks = new TodoTask();
        $result['tasks'] = $tasks->findByValue('todoId', $result['id']) ?? [];
        return $result;
    }
    //  Add Todo Task
    public function createTask($data)
    {
        $task = new TodoTask();
        $taskId = $task->create($data);
        return $task->findOne('id',$taskId);
    }

    //  Update Todo Task
    public function updateTask($taskId,$data){
        $update = new TodoTask();
        return $update->update($taskId,$data);
    }

    //  Delete Todo Task
    public function deleteTask($taskId){
        $task = new TodoTask();
        $resource = $task->findOne('id',$taskId);
        if($resource){
            $todoId = $resource['todoId'];
            $deleteTask = $task->destroy($resource['id']);
            if($deleteTask){
                //  Delete Associated Todo
                $todo = new Todo();
                $todo->destroy($todoId);
                //  Delete Associated Participant
                $todoParticipant = new TodoParticipant();
                $allParticipants = $todoParticipant->findByValue('todoId',$todoId);
                foreach($allParticipants as $participant){
                    $todoParticipant->destroy($participant['id']);
                    //  Send email to collaborators
                    $subject = "Todo Task Update!";
                    $message  = "A task has been deleted from the todo list in which you are a collaborator.<br>";
                    $message  .= "Find the details of the deleted task below:<br><br>";
                    $message  .= "<b>Task:</b> ".$resource['task']."<br>";
                    $message  .= "<b>Date Created:</b> ".date('d F, Y h:i',strtotime($resource['created_at']))."<br>";
                    if($resource['updated_at']) $message  .= "<b>Last Updated:</b> ".date('d F, Y h:i',strtotime($resource['updated_at']))."<br>";
                    $message  .= "<b>Date Deleted:</b> ".date('d F, Y h:i')."<br/><br/>";
                    $message  .= "<b>Gambio Team</b>";
                    $this->sendMail($participant['participant_email'], $message, $subject);
                }
            }
        }
    }
}
