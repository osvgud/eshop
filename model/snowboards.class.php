<?php
/**
 * Created by IntelliJ IDEA.
 * User: osvgud
 * Date: 2018-09-12
 * Time: 17:53
 */

class snowboards {

    public static function getSnowboard($id) {
        $query = "SELECT * FROM `" . DB_PREFIX . "snowboards` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getSnowboardsList($limit = null, $offset = null) {
        $query = "SELECT * FROM `" . DB_PREFIX . "snowboards`";
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

    public static function getSnowboardsListOrder($limit = null, $offset = null, $orderby) {
        $query = "SELECT * FROM `" . DB_PREFIX . "snowboards` ORDER BY ".$orderby." ".$_SESSION['fromto'];

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

    public static function getSnowboardsListCount() {
        $query = "SELECT COUNT(`id`) AS `count` FROM `" . DB_PREFIX . "snowboards`";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count'];
    }

    public static function insertSnowboard($data) {
        $query = "INSERT INTO `" . DB_PREFIX . "snowboards`
      (
        `name`,
        `price`,
        `description`,
        `image`,
        `warranty`
      ) 
      VALUES (?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['name'],
            $data['price'],
            $data['description'],
            $data['image'],
            $data['warranty']
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function updateSnowboard($data) {
        $query = "UPDATE `" . DB_PREFIX . "snowboards` SET
        `name` = ?,
        `price` = ?,
        `description` = ?,
        `image` = ?,
        `warranty` = ?
      WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array(
            $data['name'],
            $data['price'],
            $data['description'],
            $data['image'],
            $data['warranty'],
            $data['id']
        ));
    }

    public static function deleteSnowboard($id) {
        $query = "DELETE FROM `snowboards` WHERE `id` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }


}