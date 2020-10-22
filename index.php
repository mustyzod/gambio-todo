<?php

use Gambio\Controllers\TodoController;
use Dotenv\Dotenv as ENV;
use Gambio\Router\Router;
use Gambio\Router\Request;


use Gambio\Services\TodoService;

require_once realpath("vendor/autoload.php");
$dotenv = ENV::createImmutable(__DIR__);
$dotenv->load();

$task = [
    "task" => "eat",
    "todoId" => 1
];
$taskUpdate = [
    "task" => "drink",
    "status" => 1
];
$participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];
$todo = [
    "name" => "Mustapha 2",
    "description" => "this is a todo",
    "partcipants" => $participants
];

// $todoInstance = new TodoController();

// $result = $object->createTodoList($todo,$participants);
// $result = $object->inviteParticipants(17,$participants);
// $results = $object->fetchTodo('fb04a1b2-f9fe-4328-a52b-8008ec1948f4');
// $result = $object->createTodoTask($task);
// $result = $object->updateTodoTask(5,$taskUpdate);
// $result = $object->deleteTodoTask(5);




$router = new Router(new Request);

// Non params example
$router->get('/gambio', function () {
    return <<<HTML
    <h1>GAMBIO TODO CHALLENGE</h1>
HTML;
});

$router->post('/gambio/todo/create', function ($request) {
    $todoInstance = new TodoController();
    $todoInstance->createTodoList($request);
});

//  Add Todo Participant
$router->post('/gambio/todo/addParticipant/{uuid}', function ($request) {
    $todoUuid = $request->params->uuid;
    $todoInstance = new TodoController();
    $todoInstance->inviteParticipants($todoUuid, $request);
});

//  Get Todo
$router->get('/gambio/todo/{uuid}', function ($request) {
    $todoUuid = $request->params->uuid;
    $todoInstance = new TodoController();
    $todoInstance->fetchTodo($todoUuid);
});

//  Create Task
$router->post('/gambio/task/create', function ($request) {
    $todoInstance = new TodoController();
    $todoInstance->createTodoTask($request);
});

//  Create Task
$router->post('/gambio/update-task/{taskId}', function ($request) {
    $taskId = $request->params->taskId;
    $todoInstance = new TodoController();
    $todoInstance->updateTodoTask($taskId, $request);
});

// Add Todo Participant
// $router->post('/gambio/todo/addParticipant', $todoInstance->inviteParticipants(17,$participants));
// // Get Todo
// $router->get('/gambio/todo/{uuid}', $todoInstance->fetchTodo($request->params->uuid));

// Multiple params example [HTML example]
// $router->get('/gambio/{username}/address', function ($request) {
//     $username = $request->params->username;
//     $address = 'here';//$request->params->addressname;

//     return <<<HTML
//     <h1>$username stays at $address</h1>
// HTML;
// });
