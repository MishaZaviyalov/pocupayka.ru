<?php

namespace application\models;

use application\core\Model;
use http\Params;

class Main extends Model{

    public $error;

    /**
     * Проверка данных для регистрации пользователя
     * @param $post
     * @return bool
     */
    public function userRegisterValidate($post){
        $first_name = $post['first_name'];
        $second_name = $post['second_name'];
        $email = $post['email'];
        $password = $post['password'];
        $re_password = $post['repeat-password'];

        if(iconv_strlen($first_name) < 1 or $second_name < 1){
            $this->error = 'Персональные данные должны быть заполнены';
            return false;
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->error = 'Неверный формат электронной почты';
            return false;
        } else if($this->getCountEmail($email) == 1){
            $this->error = 'Подобный электронный адрес уже существует в системе';
            return false;
        } else if(iconv_strlen($password) < 1){
            $this->error = 'Поля пароль и повтор пароля должны быть заполнены!';
            return false;
        } else if($password != $re_password){
            $this->error = 'Поля пароль и повтор пароля должны совпадать';
            return false;
        } else if(!preg_match('^[a-zA-Z0-9\!\"\№\;\%\:\?\*\(\)\_\+]+$', $password) and count($password) < 5){
            $this->error = "Пароль должен состоять из латинский символов и содержать спец. символы, а длина пароля должна  быть больше 5 значений";
            return false;
        }
        return true;
    }

    /**
     * Проверка данных для авторизованный пользователей
     * @param $post
     * @return bool
     */
    public function userAuthorizationValidate($post){
        $email = $post['email'];
        $password = $post['password'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->error = 'Неверный формат электронной почты';
            return false;
        }
        else if($this->getCountEmail($email) < 1){
            $this->error = 'Подобный адрес электронной почты отсутствует в системе';
            return false;
        } else if(iconv_strlen($password) < 1){
            $this->error = 'Все поля должны быть заполнены';
        }
        return true;
    }

    /**
     * Проверка уникальности электронной почты в системе
     * @param $email
     * @return mixed
     */
    public function getCountEmail($email){
        return $this->db->column('SELECT count(*) FROM user where Email = \''.$email.'\'');
    }

    /**
     * Проверка логина и пароля пользователя на действительность
     * @param $post
     * @return mixed
     */
    public function authorizationAccount($post){
        $password = hash('sha256', $post['password']);
        return $this->db->column('select id_user from user where email = \''.$post['email'].'\' and password = \''.$password.'\'');
    }

    /**
     * Добавление пользователя в систему
     * @param $post
     * @return false|string
     */
    public function registrationPerson($post){
        $params = [
            'first_name' => $post['first_name'],
            'second_name' => $post['second_name'],
            'email' => $post['email'],
            'password' => hash('sha256', $post['password'])
        ];
        $this->db->query('insert into user (first_name, second_name, email, password) values(:first_name, :second_name, :email, :password)', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Получения контактной информации и форматирование контактов
     * @return mixed
     */
    public function getContacts(){
        $contact = require 'application/config/contact.php';
        $contact['telephone'] = preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/", "$1($2)$3-$4-$5", $contact['telephone']);
        return $contact;
    }

    /**
     * Получения списка продуктов по пагинации
     * @param $route
     * @param $mode
     * @return array|false
     */
    public function getProductList($route, $mode){
        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?? 1) - 1) * $max),
        ];
        switch ($mode){
            case 1:
                return $this->db->row('SELECT * FROM product ORDER BY price DESC LIMIT :start, :max', $params); //Expensive
            case 2:
                return $this->db->row('SELECT * FROM product ORDER BY price ASC LIMIT :start, :max', $params); //Cheap
            default:
                return $this->db->row('SELECT * FROM product ORDER BY id DESC LIMIT :start, :max', $params);
        }
    }

    /**
     * Получение количества продуктов
     * @return mixed
     */
    public function getCountProduct(){
        return $this->db->column('select count(*) from product');
    }

    /**
     * Вывод элементов для корзины в соответствии с количеством
     * @param $id
     * @return array|false
     */
    public function getProductCollectionList($id){
        $params = [];
        $Where = "where ";
        if(is_array($id)){
            foreach ($id as $element){
                $Where .= "id=$element or ";
            }
            $Where = rtrim($Where, " or ");
        }
        else{
            $Where .= "id=$id";
        }
        return $this->db->row("select * from product $Where");
    }

    /**
     * Получение продукта по наименованию
     * @param $name
     * @return mixed
     */
    public function getProductByName($name){
        return $this->db->column('select id from product where name = \''.$name.'\'');
    }

    /**
     * Формирование заказа
     * @param $address
     * @return false|string
     */
    public function formOrder($address){
        $params = [
            'status' => 'В рассмотрении',
            'address' => $address,
            'User_ID' => $_SESSION['authorize']['id']
        ];
        $this->db->query('insert into `order` (status, address,  created_at, User_ID) values(:status, :address, now(), :User_ID);', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Формирование корзины по заказу
     * @param $orderID
     * @return void
     */
    public function order_items($orderID){
        $data = $this->getProductCollectionList(array_keys($_SESSION['cart']));

        foreach ($data as $element){
            $params = [
            'Order_ID' => $orderID,
            'Product_ID' => $element['id'],
            'Quantity' => $_SESSION['cart'][$element['id']],
            'Price' => $element['price'],
                        ];
            $this->db->query('insert into `order_items` (Order_ID, Product_ID, Quantity, Price) values(:Order_ID, :Product_ID, :Quantity, :Price);', $params);
        }
    }

    /**
     * Добавление номер элемента в корзину
     * @param $productId
     * @param $quantity
     * @return void
     */
    function addToCart($productId, $quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    /**
     *  Удаление по номеру товара элемента из корзины
     * @param $productId
     * @return void
     */
    function removeFromCart($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    /**
     *  Получение списка заказов
     * @return array|false
     */
    function getOrders(){
        $params=[];
        return $this->db->row("select * from `order`", $params);
    }

    /**
     *  Получения определённого заказа по номеру
     * @param $id
     * @return array|false
     */
    function getOrder($id){
        $params=[
            'id' => $id,
        ];
        return $this->db->row("select `status` as `Status`, DATE_FORMAT(`created_at`, '%H:%i') as `Time`, DATE_FORMAT(`created_at`, '%d.%m.%Y') as `Date`, concat(First_Name, ' ', Second_Name) as `FullName` from `order` inner join `user` on id_user = user_id where id_order = :id", $params);
    }

    /**
     * Формирование строки адреса
     * @param $post
     * @return string
     */
    function getAddressString($post){
        $Street = $post['Street'];
        $NumberHouse = $post['NumberHouse'];
        $Entrance = $post['Entrance'];
        $FlatNumber = $post['FlatNumber'];

        return "Город Москва, улица $Street, дом $NumberHouse, подъезд $Entrance, квартира $FlatNumber";
    }

    /**
     * Проверка значений полей на пустоту
     * @param $post
     * @return bool
     */
    function userValidateAddress($post) {
        $Street = $post['Street'];
        $NumberHouse = $post['NumberHouse'];
        $Entrance = $post['Entrance'];
        $FlatNumber = $post['FlatNumber'];

        if(count($Street) == 0 || count($NumberHouse) == 0 || count($Entrance) == 0 || count($FlatNumber) == 0){
            $this->error = "Все поля должны быть заполнены";
            return false;
        }
        return true;
    }

    /**
     * Получить информацию о заказе доступную пользователю
     * @param $id
     * @return array|false
     */
    function getOrderInfo($id){
        $params = [
          'id' => $id,
        ];
        return $this->db->row('select product.id, product.name, order_items.Quantity, order_items.Price from order_items INNER JOIN `product` on product.id = order_items.Product_ID where order_items.Order_ID = :id', $params);
    }

    function getUserData($id){
        $params = [ 'id' => $id];
        return $this->db->row("select concat(First_Name, ' ', Second_Name) as `fullName`, Email from `user` where `id_user` = :id", $params);
    }

    function getOrderByUser($id){
        $params = [ 'userID' => $id];
        return $this->db->row("select `id_order`, `status`, `address`, date_format(`created_at`, '%H:%i | %d.%m.%Y') as 'date', SUM(`Quantity`) as 'quantity', SUM(`order_items`.`price`) as `price` from `order` inner join `order_items` on `id_order` = `order_id` where `user_id` = :userID GROUP by `id_order`", $params);
    }

    function getUserByInfoFullName($FirstName, $SecondName){
        $params = [ 'first_name' => $FirstName,
            'second_name' => $SecondName];
        return $this->db->column('select count(*) from user where `first_name` = :first_name and `second_name` = :second_name', $params);
    }

    /**
     * Валидация данных для восстановления
     * @param $post
     * @return bool
     */
    function recoveryValidate($post) {
        $countEmail = $this->getCountEmail($post['Email']);
        $countPersonalInfo = $this->getUserByInfoFullName($post['First_name'], $post['Second_name']);

        if($post['password'] != $post['repeat-password']){
            $this->error = "Поля пароль и повтор пароля не совпадают";
            return false;
        } else if($countEmail == 0){
            $this->error = "Подобный адрес электронной почты отсутствует в системе";
            return false;
        } else if($countPersonalInfo == 0){
            $this->error = "Учётной записи с подобными личными данными не существует";
            return false;
        } else if(!preg_match('^[a-zA-Z0-9\!\"\№\;\%\:\?\*\(\)\_\+]+$', $post['password'])){
            $this->error = "Пароль должен состоять из латинский символов и содержать спец. символы";
            return false;
        } else if(count($post['password']) < 6){
            $this->error = "Длина пароля должна быть больше 6 символов";
            return false;
        }
        return true;
    }

    /**
     * Обновить пароль пользователя
     * @param $post
     * @return void
     */
    function updatePassword($post){
        $params = [
            'email' => $post['Email'],
            'password' => hash('sha256', $post['password'])
        ];
        $this->db->query("update `user` set `password` = :password where `email` = :email", $params);
    }
}