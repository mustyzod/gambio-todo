<?php

declare(strict_types=1);
require_once realpath("vendor/autoload.php");

use Dotenv\Dotenv as ENV;

$dotenv = ENV::createImmutable(__DIR__);
// $dotenv = ENV::createImmutable(dirname(__FILE__));
$dotenv->load();

use PHPUnit\Framework\TestCase;
use Gambio\Services\TodoService;

class TodoServiceTest extends TestCase
{
    public $participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];
    public $todo = [
        "name" => "zodman 2",
        "description" => "this is a general",
        // "partcipants" => ["mustyzod@gmail.com","zodbis@gmail.com"]
    ];
    public $todoUuid = "3c8210fd-e544-498c-9f96-bd733a271c88";

    public function testTrueAssetsToTrue()
    {
        $condition = true;
        $this->assertTrue($condition);
    }
    
    public function testCanCreateTodo()
    {

        $todo = new TodoService();
        $created = $todo->createTodo($this->todo, $this->participants);
        $this->todoUuid = $created['uuid'];
        $this->assertIsArray($created);
    }
    public function testCanGetTodo()
    {
        $todo = new TodoService();
        // var_dump($this->todoUuid);
        // exit;
        $this->assertIsArray($todo->getTodo($this->todoUuid));
    }
    public function testCannotGetTodo()
    {
        $this->expectException(\Exception::class);
        $todo = new TodoService();
        $todo->getTodo(2);
    }
}
