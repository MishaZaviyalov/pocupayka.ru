<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

/**
 * Вывод конкретной переменной без макета и представления
 * @param $str
 * @return void
 */
function debug($str){
    echo "<pre>";
    var_dump($str);
    echo "</pre>";
    exit;
}