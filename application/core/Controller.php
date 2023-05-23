<?php

namespace application\core;

use application\core\View;

abstract class Controller{

    public $route;
    public $view;
    public $acl;

    /**
     * Конструктор класса Controller принимает контроллер с ключ значением наименования контроллера
     * @param $route
     */
    public function __construct($route) {
        $this->route = $route;
        if(!$this->checkAcl()){
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    /**
     * Поиск модель для контроллера с принимающим значением наименования контроллера без окончания
     * @param $name
     * @return mixed|void
     */
    public function loadModel($name) {
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    /**
     * Проверка пользователя на доступ к странице
     * @return bool
     */
    public function checkAcl(){
        $this->acl = require 'application/acl/'.$this->route['controller'].'.php';
        if($this->isAcl('all')){
            return true;
        }
        elseif (isset($_SESSION['authorize']['id']) and $this->isAcl('authorize')) {
            return true;
        }
        elseif (!isset($_SESSION['authorize']['id']) and $this->isAcl('guest')) {
            return true;
        }
        elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    /**
     *  Проверка массива доступа к страницам на определеннноё действие контроллера
     * @param $key
     * @return bool
     */
    public function isAcl($key){
        return in_array($this->route['action'], $this->acl[$key]);
    }
}