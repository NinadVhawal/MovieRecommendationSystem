<?php

class GenreDAO   {

    private static $db;

    public static function init() {
        self::$db= new PDOAgent("Genre");
    }

    static function getGenres()   {
        $query = "SELECT genre FROM `genres` ORDER BY genre";
        //Query
        self::$db->query($query);
        
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

}
?>