<?php
namespace Gambio\Router;

class Route{
    public static $validRoute =[];
    public static function set($route,$function){
        self::$validRoute[]=$route;
        // print_r(self::$validRoute);
        if($_GET['url'] == $route){
            $function->__invoke();
        }
    }
}