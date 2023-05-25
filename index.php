<?php

require 'application\lib\Dev.php';
use application\core\Router;

const IMAGES_COLLECTION = "public/materials/";
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if(file_exists($path)){
        require $path;
    }
});

session_start();

$item = new Router();

$item->run();

