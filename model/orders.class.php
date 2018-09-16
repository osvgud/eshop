<?php

class orders
{
    public static function getOrder($id) {
        $query = "SELECT * FROM `" . DB_PREFIX . "orders` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getOrdersList($limit = null, $offset = null) {
        $query = "SELECT * FROM `" . DB_PREFIX . "orders`";
        $parameters = array();

        if(isset($limit)) {
            $query .= " LIMIT ?";
            $parameters[] = $limit;
        }
        if(isset($offset)) {
            $query .= " OFFSET ?";
            $parameters[] = $offset;
        }

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getOrdersListCount() {
        $query = "SELECT COUNT(`id`) AS `count` FROM `" . DB_PREFIX . "orders`";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count'];
    }

    public static function insertOrder($data) {
        $query = "INSERT INTO `" . DB_PREFIX . "orders`
      (
        `first_name`,
        `last_name`,
        `email`,
        `date`,
        `price`
      ) 
      VALUES (?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['date'],
            $data['price']
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}