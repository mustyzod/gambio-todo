<?php
// Strict mode
declare(strict_types=1);

namespace Gambio\Services;

use Gambio\Models\Todo;
use Gambio\Models\TodoParticipant;
use Gambio\Models\TodoTask;
use Gambio\Services\EmailService;

class TodoService
{
    /**
     * Create Todo
     * 
     * @param   array  $data,
     * @param   array  $participants
     * 
     * @return array
     */
    public function createTodo($data, $participants = []): array
    {
        $todo = new Todo();

        //  Generate and add uuid to todo
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $data['uuid'] = $uuid;

        $todoId = $todo->create($data);
        if (!$todoId) throw new \Exception("An error occurred while creating todo!");

        //  Add todo participants
        $this->addParticipant($uuid, $participants);
        return $todo->findOne('id', $todoId);
    }

    /**
     * Add Participants
     * 
     * @param   string  $uuid,
     * @param   array  $participantData
     * 
     * @return void
     */
    public function addParticipant($uuid, $participantData = []): void
    {
        $todoInstance = new Todo();
        $todo = $todoInstance->findOne('uuid', $uuid);
        if ($todo) {
            $participant = new TodoParticipant();
            foreach ($participantData as $email) {
                $participant->upsert(["todoId" => $todo['id'], "participant_email" => $email]);
                //  Send email to collaborators
                $subject = "You have been invited to collaborate!";
                $message  = "You have been invited to collaborate in a Todo Task!<br>";
                $message  .= "Please click <a href=" . $_ENV['FRONTEND_URL'] . "/todo/$uuid> participate</a> inorder to collaborate.<br><br>";
                $message  .= "Cheers<br/>";
                $message  .= "<b>Gambio Team</b>";
                $mailer = new EmailService();
                $mailer->sendMail($email, $message, $subject);
            }
        }
    }

    /**
     * Get Todo and corresponding tasks
     * 
     * @param   string  $uuid
     * 
     * @return array
     */
    public function getTodo($uuid): array
    {
        $todos = new Todo();
        $result = $todos->findOne('uuid', $uuid);
        if (!$result) throw new \Exception("Invalid todo id: " . $uuid);

        $tasks = new TodoTask();
        $result['tasks'] = $tasks->findByValue('todoId', $result['id']);

        $participants = new TodoParticipant();
        $result['participants'] = $participants->findByValue('todoId', $result['id']);
        return $result;
    }

    /**
     * Add Todo Task
     * 
     * @param   array  $data
     * 
     * @return array 
     */
    public function createTask($data): array
    {
        $task = new TodoTask();
        $taskId = $task->create($data);
        if (!$taskId) throw new \Exception("An error occurred while creating todo task!");
        return $task->findOne('id', $taskId);
    }

    /**
     * Update Todo Task
     * 
     * @param   integer  $taskId
     * @param   array  $data
     * 
     * @return array 
     */
    public function updateTask($taskId, $data): array
    {
        $update = new TodoTask();
        $update->update($taskId, $data);
        return $update->findOne('id', $taskId);
    }

    /**
     * Delete Todo Task
     * 
     * @param   integer  $taskId
     * 
     * @return boolean
     */
    public function deleteTask($taskId): bool
    {
        $task = new TodoTask();
        $resource = $task->findOne('id', $taskId);
        if (!$resource) throw new \Exception("Non-existing todo task id: " . $taskId);

        $todoId = $resource['todoId'];
        $deleteTask = $task->destroy($resource['id']);
        if ($deleteTask) {
            $todoList = new Todo();
            $todoItem = $todoList->findOne('id', $todoId);
            //  Notify Associated Participant
            $todoParticipant = new TodoParticipant();
            $allParticipants = $todoParticipant->findByValue('todoId', $todoId);
            foreach ($allParticipants as $participant) {
                //  Send email to collaborators
                $subject = "Todo Task Update!";
                $message  = "A task has been deleted from the todo list in which you are a collaborator.<br>";
                $message  .= "Find the details of the deleted task below:<br><br>";
                $message  .= "<h1><b>Todo List:</b> " . $todoItem['name'] . "</h1>";
                $message  .= "<b>Task:</b> " . $resource['task'] . "<br>";
                $message  .= "<b>Date Created:</b> " . date('d F, Y h:i', strtotime($resource['created_at'])) . "<br>";
                if ($resource['updated_at']) $message  .= "<b>Last Updated:</b> " . date('d F, Y h:i', strtotime($resource['updated_at'])) . "<br>";
                $message  .= "<b>Date Deleted:</b> " . date('d F, Y h:i') . "<br/><br/>";
                $message  .= "<b>Gambio Team</b>";

                $mailer = new EmailService();
                $mailer->sendMail($participant['participant_email'], $message, $subject);
            }
            return true;
        }
    }
}
