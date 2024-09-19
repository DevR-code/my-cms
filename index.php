<?php

session_start();
use \Core\Config;
//define constant
define('PROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);  //   "/"
//var_dump(PROOT);
//var_dump(DS);

spl_autoload_register(function ($className) {
    $parts = explode('\\', $className);
    $class = end($parts);
    array_pop($parts);
    $path = strtolower(implode(DS, $parts));
    $path = PROOT . DS . $path . DS . $class . '.php';
    if(file_exists($path)){
        include($path);
    }
    var_dump($path);

});

Config::get('db_name');
