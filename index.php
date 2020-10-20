<?php
// include ('services/Database.php');

use Gambio\Models\Todo;
use Gambio\Models\TodoParticipant;

require_once realpath("vendor/autoload.php");

$test = [
    "name" => "sodruldeen",
    "description" => "this is a description",
    "uuid" => 654321,
    "email"=>"sod@gmail.com"
];
// $test = [
//     "todoId" => 654321,
//     "participant_email" => "mustyzod@gmail.com"
// ];

$object = new Todo();
// $results = $object->findAll();
// foreach($results as $result){
//     echo $result['id']."<br/>";
//     // echo $result['name']."<br/>";
//     // echo $result['created_at']."<br/>";
// }
// $one = $object->findById('todoId',654321);
// $one = $object->findById(12345);
// var_dump($one['participant_email']);

$delete = $object->create($test);
// $delete = $object->destroy(123456);