<?php

namespace application\lib;
use PDO;

class Db {

    protected $db;

    /**
     * Конструктор класса Db
     */
    public function __construct() {
        $config = require 'application/config/db.php';
        try{
            $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['database'], $config['login'], $config['password']);
        }
        catch (\PDOException $e){

            $this->db = new PDO('mysql:host='.$config['reserve'].';dbname='.$config['database'], $config['login'], $config['password']);
        }
    }

    /**
     * Отправка запроса в базу данных без sql инъекции
     * @param $sql
     * @param $params
     * @return false|\PDOStatement
     */
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (is_int($val)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue(':'.$key, $val, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     *  Получения строки значений из базы данных
     * @param $sql
     * @param $params
     * @return array|false
     */
    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *  Получить столбец значения из базы данных
     * @param $sql
     * @param $params
     * @return mixed
     */
    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    /**
     * Получения последней вставленной записи из базы данных
     * @return false|string
     */
    public function lastInsertId() {
        return $this->db->lastInsertId();
    }
}