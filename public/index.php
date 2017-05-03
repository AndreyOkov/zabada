<?php

use vendor\Router;

define('ROOT', dirname(__DIR__));
define('APP', ROOT. '/app');
define('LAYOUT', 'default');
require ROOT . '/vendor/functions.php';

spl_autoload_register(function($class){
    $file = ROOT . '/' . str_replace('\\', '/', $class).'.php';
    if(is_file($file)){
        require_once $file;
    } 
});

$url = $_SERVER["QUERY_STRING"];

Router::add('^$',['controller' => 'Employee', 'action' => 'index']);
Router::add('(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');

Router::dispatch($url);