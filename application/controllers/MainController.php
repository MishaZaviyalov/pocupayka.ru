<?php

namespace application\controllers;
use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;
use http\Params;

class MainController extends Controller
{
    /**
     * Конструктор класса MainController. Принимает значение о принятом маршруте.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'other';

        $_SESSION['authorize']['id'] = 3;
    }

    /**
     *  Действие контроллера main на главной странице
     * @return void
     */
    public function indexAction()
    {
        $this->view->layout = 'default';
        $this->view->render('Главная страница');
    }

    /**
     * Действие контроллера main на странице ассортимент
     * @return void
     */
    public function assortmentAction(){
        $main = new Main();
        $pagination = new Pagination($this->route, $main->getCountProduct());

        $vars = [
            'data' => $this->model->getProductList($this->route, 10),
            'pagination' => $pagination->get(),
        ];

        if(!empty($_POST)){
            if(isset($_POST['name'])){ //SEARCH
                if($_POST['name'] != ''){
                    $Information = $this->model->getProductByName($_POST['name']);
                    if(empty($Information)) $this->view->message('Ошибка', "Товары не найдены");
                    else{
                        $this->view->location('product/'.$Information);
                    }
                }
                else $this->view->message('Ошибка', "Поле наименование должно быть заполнено");
            }
            else if(isset($_POST['price-object'])){ //SORT
                if($_POST['price-object'] == 'cheap')
                {
                    $vars['data'] = $this->model->getProductList($this->route, 2);
                   $_SESSION['SORT'] = 1;
                }
                else{
                    $vars['data'] = $this->model->getProductList($this->route, 1);
                    $_SESSION['SORT'] = 2;
                }
            }
        }

        if(isset($_SESSION['SORT']) and $_SESSION['SORT'] == 1) $vars['data'] = $this->model->getProductList($this->route, 2);
        else if (isset($_SESSION['SORT']) and $_SESSION['SORT'] == 2) $vars['data'] = $this->model->getProductList($this->route, 1);


        $this->view->render('Ассортимент', $vars);
    }

    /**
     * Действие контроллера main на странице контакты
     * @return void
     */
    public function contactAction(){
        $vars = [
          'data' => $this->model->getContacts(),
        ];
        $this->view->render('О нас', $vars);
    }

    /**
     * Действие контроллера main на странице регистрация
     * @return void
     */
    public function registrationAction(){
        if(isset($_SESSION['authorize']['id'])){
            $this->view->redirect('');
        }

        if(!empty($_POST)){
            if(!$this->model->userRegisterValidate($_POST)){
                $this->view->message('error', $this->model->error);
            }
            $id = $this->model->registrationPerson($_POST);
            $_SESSION['authorize']['id'] = $id;
            $this->view->location('');
        }
        $this->view->render('Покупайка');
    }

    /**
     * Действие контроллера main на странице авторизация
     * @return void
     */
    public function authorizationAction(){
        if(isset($_SESSION['authorize']['id'])){
            $this->view->redirect('');
        }

        if(!empty($_POST)){
            if(!$this->model->userAuthorizationValidate($_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
           $id = $this->model->authorizationAccount($_POST);
            if($id != false)
            {
                $_SESSION['authorize']['id'] = $id;
                $this->view->location('');
            }
            else $this->view->message('Ошибка', 'Неверный адрес электронной почты или пароль!');
        }
        $this->view->render('Покупайка');
    }

    /**
     * Действие контроллера main на странице выход из учётной записи
     * @return void
     */
    public function logoutAction(){
        unset($_SESSION['authorize']['id']);
        $this->view->redirect('');
    }

    /**
     *  Действие контроллера main на странице просмотра товара
     * @return void
     */
    public function productAction(){
        if(!isset($this->route['id'])) $this->view->redirect('assortment/');
        $id = $this->route['id'];
        $Collection = $this->model->getProductCollectionList($id);
        if(count($Collection) == 0) $this->view->redirect('assortment/');
        $var = [
            'data' => $Collection
        ];
        $this->view->render('Покупайка', $var);
    }

    /**
     * Действие контроллера main на странице добавление товара из корзины
     * @return void
     */
    public function addAction(){
        $id = $this->route['id'];
        $this->model->addToCart($id, 1);
        $this->view->redirect('assortment/card');
    }

    /**
     * Действие контроллера main на странице удаление товара из корзины
     * @return void
     */
    public function removeAction(){
        $id = $this->route['id'];
        $this->model->removeFromCart($id);
        $this->view->redirect('assortment/card');
    }

    /**
     * Действие контроллера main на странице ассортимент
     * @return void
     */
    public function cardAction(){

        if(!isset($_SESSION['authorize']['id'])){
            $this->view->redirect("authorization");
        }

        if(isset($_SESSION['cart']) and count($_SESSION['cart']) != 0){
            $var = [
                "data" => $this->model->getProductCollectionList(array_keys($_SESSION['cart']))
            ];
            $this->view->render('Покупайка', $var);
        }
        else{
            $this->view->render('Покупайка');
        }

    }

    /**
     * Действие контроллера main на странице формирование заказа
     * @return void
     */
    public function formulateAction() {
        if(!isset($_SESSION['authorize']['id']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
            $this->view->redirect("authorization");
        }

        if(!empty($_POST)){
            $address = $this->model->getAddressString($_POST);
            $id = $this->model->formOrder($address);
            $this->model->order_items($id);
            $this->view->redirect("assortment/success/".$id);
        }

        $this->view->render('Покупайка');
    }

    /**
     * Действие контроллера main на странице отчистка корзины
     * @return void
     */
    public function cleanAction(){
        if(!isset($_SESSION['authorize']['id'])){
            $this->view->redirect("authorization");
        }
        unset($_SESSION['cart']);

        $this->view->redirect('assortment/card');
    }

    /**
     * Действие контроллера main на странице окончания заказа
     * @return void
     */
    function successAction(){
        $collection = $this->model->getOrder($this->route['id']);

        $vars = [
            'data' => $this->model->getOrder($this->route['id'])
        ];
        $this->view->render('Покупайка', $vars);
    }

    /**
     * Действие контроллера main на странице просмотра json заказов
     * @return void
     */
    function orderAction(){
        $this->view->layout = 'API';

        $vars = [
          'data' => $this->model->getOrders(),
        ];

        if(isset($this->route['id'])) $vars[] = ['value' => $this->route['id']];

        $this->view->render('Покупайка', $vars);
    }

    /**
     * Действие контроллера main на странице просмотра json заказов
     * @return void
     */
    function orderIdAction(){
        $this->view->layout = 'API';
        $id = $this->route['id'];
        $vars = [
            'data' => $this->model->getOrderInfo($id),
        ];
        $this->view->render('Покупайка', $vars);
    }

    /**
     * Действие контроллера main на странице профиля пользователя
     * @return void
     */
    function profileAction(){
        $m = new Main();
        $user_id = $_SESSION['authorize']['id'];
        $vars = [
            'dataProfile' => $m->getUserData($user_id),
            'dataOrder' => $m->getOrderByUser($user_id),
        ];
        $this->view->render('Покупайка', $vars);
    }

    /**
     * Действие контроллера main на странице восстановление аккаунта
     * @return void
     */
    public function recoveryAction(){
        if(!isset($_SESSION['authorize']['id'])){
            $this->view->redirect("");
        }

        if(!empty($_POST)){
            if(!$this->model->recoveryValidate($_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            $this->model->updatePassword($_POST);
            $this->view->message('Успешно', "Пароль изменён!");
        }
        $this->view->render('Покупайка');
    }
}
