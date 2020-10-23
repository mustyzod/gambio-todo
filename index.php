<?php

/**
 * GAMBIO TODO CHALLENGE
 *
 * @author  Sodruldeen Mustapha <zodbis@gmail.com>
 */
error_reporting(E_NOTICE);
require_once realpath("vendor/autoload.php");

use Dotenv\Dotenv as ENV;

$dotenv = ENV::createImmutable(__DIR__);
$dotenv->load();

//  Get base directory name for use in local environment
$entry = basename(__DIR__);
$local = !checkdnsrr($_SERVER['SERVER_NAME'], 'NS');
$entry = $local ? '/' . $entry : '/' . $entry;

require_once __DIR__ . '/src/route/api.php';
