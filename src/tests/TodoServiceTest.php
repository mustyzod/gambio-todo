<?php

declare(strict_types=1);
// require_once realpath("vendor/autoload.php");

// use Dotenv\Dotenv as ENV;

// $dotenv = ENV::createImmutable(__DIR__);
// // $dotenv = ENV::createImmutable(dirname(__FILE__));
// $dotenv->load();

use PHPUnit\Framework\TestCase;
use Gambio\Services\TodoService;

class TodoServiceTest extends TestCase
{
    public $participants = ["mustyzod@gmail.com", "zodbis@gmail.com"];
    public $todo = [
        "name" => "zodman 2",
        "description" => "this is a general",
    ];
    public $todoUuid = "3c8210fd-e544-498c-9f96-bd733a271c88";

    public $expectedOnTodoCreate=[
        "id"=> "7",
        "name"=> "Sodruldeen",
        "description"=> "this is my todo list",
        "uuid"=> "b88fe85e-5de9-715e-4a04-02b439f0c3af",
        "created_at"=> "2020-10-26 07:39:12",
        "updated_at"=> null,
        "deleted_at"=> null
    ];
    
    public function testTrueAssetsToTrue()
    {
        $condition = true;
        $this->assertTrue($condition);
    }
    //  test for createTodo
    public function testCanCreateTodo()
    {
        // mock EmailServices Methods
        $mock = $this->getMockBuilder('EmailService')
            ->setMethods(array('sendMail'))
            ->getMock();
        $mock->expects($this->once())
            ->method('sendMail')
            ->will($this->returnValue(true));

        // mock EmailServices Methods
        $mock = $this->getMockBuilder('')
            ->setMethods(array('sendMail'))
            ->getMock();
        $mock->expects($this->once())
            ->method('sendMail')
            ->will($this->returnValue(true));

        // mock DatabaseServices Methods
        $mockDb = $this->getMockBuilder('DatabaseService')
            ->setMethods(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->getMock();
        $mockDb->expects($this->once())
            ->method(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->will(array(true,true,[],[],[],[],[],[],[],true));
        
        $todo = new TodoService();
        $created = $todo->createTodo($this->todo, $this->participants);
        $this->assertIsArray($created);
    }

    //  test for Get Todo
    public function testCanGetTodo()
    {
        // mock DatabaseServices Methods
        $mockDb = $this->getMockBuilder('DatabaseService')
            ->setMethods(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->getMock();
        $mockDb->expects($this->once())
            ->method(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->will(array(true,true,[],[],[],[],[],[],[],true));

        $todo = new TodoService();
        $this->assertIsArray($todo->getTodo($this->todoUuid));
    }

    //  Test for Get todo Error
    public function testCannotGetTodo()
    {
        // mock DatabaseServices Methods
        $mockDb = $this->getMockBuilder('DatabaseService')
            ->setMethods(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->getMock();
        $mockDb->expects($this->once())
            ->method(array('__construct','connect','create','upsert','findAll','findOne','findByValue','update','destroy','closeConnection'))
            ->will(array(true,true,[],[],[],[],[],[],[],true));
            
        $this->expectException(\Exception::class);
        $todo = new TodoService();
        $todo->getTodo(2);
    }
}
