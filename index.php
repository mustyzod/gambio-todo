<?php
/**
 * GAMBIO TODO CHALLENGE
 *
 * @author  Sodruldeen Mustapha <zodbis@gmail.com>
 */
error_reporting(E_ALL & ~E_NOTICE);
require_once realpath("vendor/autoload.php");

use Dotenv\Dotenv as ENV;

$dotenv = ENV::createImmutable(__DIR__);
$dotenv->load();

//  Get base directory name for use in local environment
$entry = basename(__DIR__);
$local = !checkdnsrr($_SERVER['SERVER_NAME'], 'NS');
$entry = $local ? '/' . $entry : '/' . $entry;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("HTTP/1.1 200 OK");
die();
}
require_once __DIR__ . '/src/route/api.php';
