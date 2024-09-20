<?php

session_start();
use \Core\{Config, Router};
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
    //var_dump($path);

});

$rootDir = Config::get('root_dir');
// $rootDir = Config::get("root_dir");
define('ROOT', $rootDir);
//var_dump($rootDir);
//var_dump(ROOT);

$url = $_SERVER['REQUEST_URI'];    //super global
$url = str_replace(ROOT, '', $url);
$url = preg_replace('/(\?.+)/', '', $url);
Router::route($url);
//var_dump($url);

// Config::get('db_name');
//var_dump($db_name);
