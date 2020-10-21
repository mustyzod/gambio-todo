<?php

use Gambio\Services\TodoService;
use Dotenv\Dotenv as ENV;

require_once realpath("vendor/autoload.php");

$dotenv = ENV::createImmutable(__DIR__);
$dotenv->load();

$task = [
    "task" => "eat",
    "todoUuid" => 1234
];
$todo = [
    "name" => "Example 2",
    "description" => "this is a todo"
];
$participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];

$object = new TodoService();

$result = $object->createTodo($todo, $participants);
header('Content-type:application/json;charset=utf-8');
http_response_code(200);
echo json_encode([
    "success" => true,
    "todoId" => $result,
    "message" => "Todo Creation Successful!!"
]);
// return json_encode([$result,"message"=>"Todo Creation Successful!!"]);
// $result = $object->getTodo('04c9b00c-bbea-4cd9-99fe-18ddb532f147');
// var_dump($result);
// $result = $object->destroy(123456);