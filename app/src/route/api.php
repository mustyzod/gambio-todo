<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where we register all the api endpoint for the application.
|
*/
use Gambio\Controllers\TodoController;
use Gambio\Router\Router;
use Gambio\Router\Request;


// API endpoint
$router = new Router(new Request);
/**
 * @description API entry point
 * 
 * @method GET
 * 
 * @endpoint /
 */
$router->get($entry, function () {
    return json_encode("GAMBIO TODO CHALLENGE");
});

/**
 * @description Create Todo List
 * 
 * @method POST
 * 
 * @endpoint /todo/create
 */
$router->post($entry . '/todo/create', function ($request) {
    $todoInstance = new TodoController();
    $todoInstance->createTodoList($request);
});

/**
 * @description Add Todo Participant
 * 
 * @method POST
 * 
 * @endpoint /todo/addParticipant/{uuid}
 */
$router->post($entry . '/todo/addParticipant/{uuid}', function ($request) {
    $todoUuid = $request->params->uuid;
    $todoInstance = new TodoController();
    $todoInstance->inviteParticipants($todoUuid, $request);
});

/**
 * @description Get Todo
 * 
 * @method GET
 * 
 * @endpoint /todo/{uuid}
 */
$router->get($entry . '/todo/{uuid}', function ($request) {
    $todoUuid = $request->params->uuid;
    $todoInstance = new TodoController();
    $todoInstance->fetchTodo($todoUuid);
});


/**
 * @description Create Task
 * 
 * @method POST
 * 
 * @endpoint /todo/task/create
 */
$router->post($entry . '/todo/task/create', function ($request) {
    $todoInstance = new TodoController();
    $todoInstance->createTodoTask($request);
});

/**
 * @description Update Task
 * 
 * @method POST
 * 
 * @endpoint /todo/task/{taskId}/update
 */
$router->post($entry . '/todo/task/{taskId}/update', function ($request) {
    $taskId = $request->params->taskId;
    $todoInstance = new TodoController();
    $todoInstance->updateTodoTask($taskId, $request);
});

/**
 * @description Delete Task
 * 
 * @method GET
 * 
 * @endpoint /todo/task/{taskId}/delete
 */
$router->get($entry . '/todo/task/{taskId}/delete', function ($request) {
    $taskId = $request->params->taskId;
    $todoInstance = new TodoController();
    $todoInstance->deleteTodoTask($taskId, $request);
});


/**
 * @description Handles Invalid URI
 * 
 * @method GET
 * 
 * @endpoint /*
 */
$router->get($entry . '/{*}', function () {
    return json_encode(["message" => "Invalid API endpoint"]);
});