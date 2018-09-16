<?php

class cart_items
{
    public static function getItem($id) {
        $query = "SELECT * FROM `" . DB_PREFIX . "cart_items` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getItemsList($limit = null, $offset = null) {
        $query = "SELECT * FROM `" . DB_PREFIX . "cart_items`";
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

    public static function getItemsListCart($uid) {
        $query = "SELECT * FROM `" . DB_PREFIX . "cart_items` WHERE fk_user='".$uid."'";
        $parameters = array();

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getItemsListCount($uid) {
        $query = "SELECT COUNT(`id`) AS `count` FROM `" . DB_PREFIX . "cart_items` WHERE fk_user ='".$uid."'";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count'];
    }

    public static function insertItem($fk_user, $fk_snowboard) {
        $query = "INSERT INTO `" . DB_PREFIX . "cart_items`
      (
        `fk_user`,
        `fk_snowboard`
      ) 
      VALUES (?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $fk_user,
            $fk_snowboard
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function deleteItem($id) {
        $query = "DELETE FROM `cart_items` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}