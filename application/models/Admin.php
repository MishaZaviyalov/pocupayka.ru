<?php

namespace application\models;

use application\core\Model;
use Imagick;

class Admin extends Model {

    public $error;

    /**
     * Проверка корректности информации при авторизации пользователя
     * @param $post
     * @return bool
     */
    public function loginValidate($post){
        $config = require 'application/config/admin.php';
        $login = $_POST['login_admin'];
        $password = $_POST['password_admin'];

        if($config['isHash']){
            $login = hash($config['hash'], $login);
            $password = hash($config['hash'], $password);
        }
        if($login != $config['login'] or $password != $config['password']){
            $this->error = "Неверный логин или пароль";
            return false;
        }
        return true;
    }

    /**
     * Проверка корректности информации при добавлении и изменение товара
     * @param $post
     * @param $type
     * @return bool
     */
    public function productValidate($post, $type){
        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $price = (float)(isset($post['price']) ? $post['price'] : 0);
        if ($nameLen < 3 or $nameLen > 100) {
            $this->error = 'Наименование должно содержать от 3 до 100 символов';
            return false;
        } elseif ($descriptionLen < 10 or $descriptionLen > 500) {
            $this->error = 'Описание должно содержать от 10 до 100 символов';
            return false;
        } elseif ($price < 0 or $price > 1000000) {
            $this->error = 'Цена должна быть больше 0 и не больше 1000000';
            return false;
        }

        if(empty($_FILES['img']['tmp_name']) and $type == 'add') {
            $this->error = "Изображение не выбрано";
            return false;
        }
        return true;
    }

    /**
     * Функция добавление товара в базу данных
     * @param $post
     * @return false|string
     */
    public function productAdd($post){
        $params = [
            'id' =>null,
            'name' => $post['name'],
            'description' => $post['description'],
            'price' => $post['price'],
        ];
        $this->db->query('INSERT INTO product VALUES (:id, :name, :description, :price)', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Функция изменение товара в базе данных
     * @param $id
     * @return void
     */
    public function productUploadImage($id) {
        $file = IMAGES_COLLECTION.$id.'.png';
        move_uploaded_file($_FILES['img']['tmp_name'], $file);
    }

    /**
     *  Проверка существование товара в базе данных
     * @param $id
     * @return mixed
     */
    public function isProductExists($id) {
        $params = [
            'id' => $id,
        ];
        return $this->db->column('SELECT id FROM product WHERE id = :id', $params);
    }

    /**
     * Удаление товара из базы данные
     * @param $id
     * @return void
     */
    public function productDelete($id){
        $file = IMAGES_COLLECTION.$id.'.png';
        $params = [
            'id' => $id,
        ];
        $this->db->query('delete from product where id = :id', $params);
        if(file_exists($file)) unlink($file);
    }

    /**
     * Изменение товара в базе данных
     * @param $post
     * @param $id
     * @return void
     */
    public function productUpdate($post, $id){
        $params = [
            'id' =>$id,
            'name' => $post['name'],
            'description' => $post['description'],
            'price' => $post['price'],
        ];
        $this->db->query('update product set name = :name, description = :description, price = :price where id = :id;', $params);
    }

    /**
     *  Получения о конкретном товаре
     * @param $id
     * @return array|false
     */
    public function productData($id){
        $params = [
            'id' => $id,
        ];
        return $this->db->row("select * from product where id = :id", $params);
    }

    /**
     * Получения количества товаров
     * @return mixed
     */
    public function productCount() {
        return $this->db->column('SELECT COUNT(id) FROM product');
    }

    /**
     * Получения набора товаров для пагинации
     * @param $route
     * @return array|false
     */
    public function productsList($route) {
        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?? 1) - 1) * $max),
        ];
        return $this->db->row('SELECT * FROM product ORDER BY id DESC LIMIT :start, :max', $params);
    }

    function getOrdersWithUsers(){
        $params=[];
        return $this->db->row("select `id_order` as `id_order`, `Address` as `Address`, `status` as `status`, date_Format(`created_at`, '%H:%i | %d.%m.%Y') as `created_at`, concat(`first_name`,' ', left(`second_name`, 1), '.') as `Person_name` from `order` inner join `user` on `id_user` = `user_id` order by `created_at`", $params);
    }

    function getOrder($id){
        $params=['id' => $id];
        return $this->db->row("select `id_order` as `id_order`, `Address` as `Address`, `status` as `status`, date_Format(`created_at`, '%H:%i | %d.%m.%Y') as `created_at`, concat(`first_name`,' ', left(`second_name`, 1), '.') as `Person_name` from `order` inner join `user` on `id_user` = `user_id` where `id_order` = :id order by `created_at` limit 1", $params);
    }

    function getOrderProduct($id){
        $params=['id' => $id];
        return $this->db->row("select product.id, product.name, order_items.Quantity, order_items.Price from order_items INNER JOIN `product` on product.id = order_items.Product_ID where order_items.Order_ID = :id", $params);
    }

    function statusFormGenerate($info){
        $statuses = require 'application/config/status.php';
        $formSelect = '<select name="status">';
        foreach ($statuses as $key => $element){
            if($info['status'] != $element){
                $formSelect .= "<option value='$key'>$element</option>";
            }
            else{
                $formSelect .= "<option value='$key' selected>$element</option>";
            }
        }
        $formSelect .= '</select>';
        return $formSelect;
    }

    function getOrderByID($id){
        $params=['id' => $id];
        $mas = $this->db->column('select count(*) from `order` where `id_order` = :id', $params);
        return $mas == 1;
    }

    function updateStatus($post, $id){
        $statuses = require 'application/config/status.php';
        $params = [
            'id' => $id,
          'status' => $statuses[$post['status']]
        ];
        $this->db->query("update `order` set `status` = :status where `id_order` = :id", $params);
    }
}