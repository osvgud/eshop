<?php
require_once 'model/cart_items.class.php';

class orders
{
    public static function getOrder($id)
    {
        $query = "SELECT * FROM `" . DB_PREFIX . "orders` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getOrderByUser($username)
    {
        $query = "SELECT * FROM `" . DB_PREFIX . "orders` WHERE `fk_user` = ? and `state` = 'inprogress'";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($username));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0]['id'];
    }

    public static function updateOrder($data)
    {
        $query = "UPDATE `" . DB_PREFIX . "orders` SET
        `first_name` = ?,
        `last_name` = ?,
        `email` = ?,
        `date` = NOW(),
        `state` = ?
      WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            'ordered',
            $data['id']
        ));
    }

    public static function updatePrice($price, $id)
    {
        $query = "UPDATE `" . DB_PREFIX . "orders` SET
        `price` = ?
      WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array(
            $price,
            $id
        ));
    }

    public static function getOrderInprogress($id)
    {
        $query = "SELECT * FROM `" . DB_PREFIX . "orders` WHERE `fk_user` = ? and `state` = 'inprogress'";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();
        if (count($data) == 0) {
            return true;
        }

        return false;
    }

    public static function createOrderForUser()
    {
        $query = "INSERT INTO `" . DB_PREFIX . "orders`
      (
        `state`,
        `fk_user`
      ) 
      VALUES (?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            'inprogress',
            $_SESSION['username']
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getOrdersList($limit = null, $offset = null)
    {
        $query = "select orders.id as order_id, cart_items.fk_user as username, first_name, last_name,"
        ."orders.price as sum_price, snowboards.name as snowboard_name, snowboards.price as snowboard_price, "
        ."image from cart_items INNER JOIN orders ON cart_items.fk_order = orders.id INNER JOIN snowboards on snowboards.id"
            ."= cart_items.fk_snowboard WHERE state = 'ordered'";
        $parameters = array();

        if (isset($limit)) {
            $query .= " LIMIT ?";
            $parameters[] = $limit;
        }
        if (isset($offset)) {
            $query .= " OFFSET ?";
            $parameters[] = $offset;
        }

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getOrdersListCount()
    {
        $query = "SELECT COUNT(`id`) AS `count` FROM `" . DB_PREFIX . "orders`";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count'];
    }

    public static function insertOrder($data)
    {
        $query = "INSERT INTO `" . DB_PREFIX . "orders`
      (
        `first_name`,
        `last_name`,
        `email`,
        `date`,
      ) 
      VALUES (?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['date'],
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}