<?php

use Gambio\Controllers\TodoController;
use Gambio\Controllers\Controller;
use Gambio\Router\Route;
use Dotenv\Dotenv as ENV;

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
$todo = [
    "name" => "Mustapha 2",
    "description" => "this is a todo"
];
$participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];

// $object = new TodoController();

// $result = $object->createTodoList($todo,$participants);
// $result = $object->inviteParticipants(17,$participants);
// $results = $object->fetchTodo('fb04a1b2-f9fe-4328-a52b-8008ec1948f4');
// $result = $object->createTodoTask($task);
// $result = $object->updateTodoTask(5,$taskUpdate);
// $result = $object->deleteTodoTask(5);

// echo $_GET['url'];

Route::set('to',function(){
    // echo "home";
    $todo = [
    "name" => "Mustapha 2",
    "description" => "this is a todo"
];
$participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];
    $todo=new TodoController();
    $todo->fetchTodo('fb04a1b2-f9fe-4328-a52b-8008ec1948f4');
});

Route::set('todo',function(){
    echo "todo";
});