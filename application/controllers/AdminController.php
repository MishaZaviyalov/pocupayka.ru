<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Pagination;
use application\models\Admin;

class AdminController extends Controller
{
    /**
     * Конструктор класса AdminController. Принимает значение о принятом маршруте.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    /**
     * Действие контроллера admin на странице авторизации
     * @return void
     */
    public function loginAction(){

        if (isset($_SESSION['admin'])) {
            $this->view->redirect('admin/add');
        }

        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('Ошибка', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }
        $this->view->render('Панель администратора');
    }

    /**
     * Действие контроллера admin на странице добавления товара
     * @return void
     */
    public function addAction(){
        if (!empty($_POST)) {
            if (!$this->model->productValidate($_POST, 'add')) {
                $this->view->message('Ошибка', $this->model->error);
            }
            $id = $this->model->productAdd($_POST);
            if (!$id) {
                $this->view->message('Ошибка', 'Ошибка в запросе!');
            }
            $this->model->productUploadImage($id);
            $this->view->message('Успешно', 'Продукт добавлен!');
        }
        $this->view->render('Панель администратора');
    }

    /**
     * Действие контроллера admin на странице изменение товара
     * @return void
     */
    public function editAction(){
        if(!$this->model->isProductExists($this->route['id'])){
            View::errorCode(404);
        }
        if(!empty($_POST)){
            if(!$this->model->productValidate($_POST, 'edit')){
                $this->view->message('error', $this->model->error);
            }
            $this->model->productUpdate($_POST, $this->route['id']);
            if($_FILES['img']['tmp_name']){
                $this->model->productUploadImage($this->route['id']);
            }
            $this->view->message("Успешно", "Объект обновлён!");
            $this->view->location('admin/products');
        }
        $vars = [
            'data' => $this->model->productData($this->route['id'])[0],
        ];
        $this->view->render("Панель администратора", $vars);

    }

    /**
     * Действие контроллера admin на странице просмотр продуктов
     * @return void
     */
    public function productsAction(){
        $adminModel = new Admin();
        $pagination = new Pagination($this->route, $adminModel->productCount());
        $vars = [
            'data' => $this->model->productsList($this->route),
            'pagination' => $pagination->get(),
        ];
        $this->view->render('Панель администратора', $vars);
    }

    /**
     * Действие контроллера admin на странице удаление товара
     * @return void
     */
    public function deleteAction(){
        if(!$this->model->isProductExists($this->route['id'])){
            View::errorCode(404);
        }
        $this->model->productDelete($this->route['id']);
        $this->view->redirect('admin/products');
        exit("Удаление");
    }

    /**
     * Действие контроллера admin на странице выход из учетной записи
     * @return void
     */
    public function logoutAction(){
        unset($_SESSION['admin']);
        $this->view->redirect('admin/login');
    }

    public function ordersAction(){
        $vars = ['data' => $this->model->getOrdersWithUsers()];
        $this->view->render('Панель администратора', $vars);
    }

    public function orderAction(){
        $id = $this->route['id'];
        if(!$this->model->getOrderByID($id)){
            $this->view->redirect('admin/orders');
        }

        $vars = [ 'data' => $this->model->getOrder($id),
            'opData' => $this->model->getOrderProduct($id),
            'select' => $this->model->statusFormGenerate($this->model->getOrder($id)[0])];
        if(count($vars['data']) == 0)
            $this->view->redirect('admin/orders');

        if(!empty($_POST)){
            $this->model->updateStatus($_POST, $id);
            $this->view->redirect('admin/orders');
        }
        $this->view->render('Панель администратора', $vars);
    }
}