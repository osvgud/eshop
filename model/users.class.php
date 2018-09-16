<?php
class users
{
    public static function insertUser($data)
    {
        if($data['password'] != $data['password2'])
        {
            return false;
        }
        $query = "INSERT INTO `users`
      (
        `username`,
        `password`,
        `userlevel`
      ) 
      VALUES (?, ?, 1)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['username'],
            $data['password']
        );
        $_SESSION['username'] = $data['username'];
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function checkUser($data)
    {
        $query = "SELECT * FROM users where username = ? and password = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['username'],
            $data['password']
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        $data = $stmt->fetchAll();
        if (count($data) == 0) {
            return false;
        }
        else
        {
            $_SESSION["username"] = $data[0]['username'];
            $_SESSION["userlevel"] = $data[0]['userlevel'];
        }
        return true;
    }
};