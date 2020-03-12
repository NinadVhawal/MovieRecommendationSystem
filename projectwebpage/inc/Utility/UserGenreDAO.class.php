<?php

class UserGenreDAO   {

    private static $db;

    public static function init() {
        self::$db= new PDOAgent("UserGenre");
    }

    static function saveUserGenre(string $userid, string $genrename)   {
        $query = "INSERT INTO usergenre(userid,genreid)
                VALUES(:uid, (SELECT genreid FROM genres WHERE genre = :genre))";
        //Query
        self::$db->query($query);
        //bind
        self::$db->bind(":uid",$userid);
        self::$db->bind(":genre",$genrename);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->rowCount();
    }

}
?>