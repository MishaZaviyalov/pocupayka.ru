<?php

namespace application\core;

class View{

    public $path;
    public $route;
    public $layout = 'default';

    /**
     * Конструктор класса View
     * @param $route
     */
    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    /**
     * Поиск по маршруту представления
     * @param $title
     * @param $vars
     * @return void
     */
    public function render($title, $vars = []){
        extract($vars);
        $path = 'application/views/'.$this->path.'.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/'.$this->layout.'.php';
        }
    }

    /**
     * Вывод сообщения об ошибке
     * @param $code
     * @return void
     */
    public static function errorCode($code){
        http_response_code($code);
        $path = 'application/views/errors/'.$code.'.php';
        if(file_exists($path)){
            require $path;
        }
        exit;
    }

    /**
     * Перенаправления пользователя на другую страницу
     * @param $url
     * @return void
     */
    public function redirect($url){
        header('location: /'.$url);
        exit;
    }

    /**
     * Вывод json сообщения из принимающего значения
     * @param $status
     * @param $message
     * @return void
     */
    public function message($status, $message){
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    /**
     *  Вывод json адреса из принимающего значения
     * @param $url
     * @return void
     */
    public function location($url){
        exit(json_encode(['url' => $url]));
    }
}