<?php

namespace application\core;

use application\lib\Db;

abstract class Model{

    public $db;

    /**
     * Конструктор класс Model возвращает объект подключения к базе данных
     */
    public function __construct()
    {
        $this->db = new Db();
    }
}