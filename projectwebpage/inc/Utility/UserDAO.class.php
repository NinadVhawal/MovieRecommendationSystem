<?php

class UserDAO   {

    private static $db;

    public static function init() {
        self::$db= new PDOAgent("User");
    }

    static function getUser(string $userid)   {
        $query = "SELECT * FROM users WHERE userid = :uid";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":uid", $userid);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->singleResult();
    }

    static function getOccupations()   {
        $query = "SELECT DISTINCT occupation FROM `users` ORDER BY occupation";
        //Query
        self::$db->query($query);
        
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

    static function createUser(User $u)    {

        $query = "INSERT INTO users (gender, age, occupation, email, password, phone)
                VALUES(:gender, :age, :occupation, :email, :pass, :phone);";

        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":gender", $u->getGender());
        self::$db->bind(":age", $u->getAge());
        self::$db->bind(":occupation", $u->getOccupation());
        self::$db->bind(":email", $u->getEmail());
        self::$db->bind(":pass", $u->getPassword());
        self::$db->bind(":phone", $u->getPhone());
       
        //Execute!
        self::$db->execute();
       
        //Return the results
        return self::$db->lastInsertId();
    }

    static function existingUser(string $email) {
        $query = "SELECT * FROM users WHERE email = :email";

        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":email", $email);

        //Execute!
        self::$db->execute();

        //Return the results
        if (self::$db->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }

    static function authenticateUser(string $email, string $password) {
        $query = "SELECT * FROM users WHERE email = :email AND password = :pass";
        
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":email", $email);
        self::$db->bind(":pass", $password);

        //Execute!
        self::$db->execute();

        //Return the results
        if (self::$db->rowCount()==1) {
            return true;
        } else {
            return false;
        }
        
    }


}
?>