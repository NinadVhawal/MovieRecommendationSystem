<?php

class MovieDAO   {

    private static $db;

    public static function init() {
        self::$db= new PDOAgent("Movie");
    }

    static function getMovie(string $movieTitle)   {
        $query = "SELECT * FROM `movies` WHERE title=:title";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":title",$movieTitle);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->singleResult();
    }

    static function getMoviesLikeSearch(string $search)   {
        $query = "SELECT * FROM `movies` WHERE title LIKE :search";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":search",'%'.$search.'%');
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

    static function getMoviesByGenre(string $genre)   {
        $query = "SELECT m.title, m.releaseyear, AVG(r.rating) AS avgrating
                FROM movies m LEFT JOIN moviegenre mg ON mg.movieid = m.movieid
                            LEFT JOIN genres g ON g.genreid = mg.genreid
                            LEFT JOIN ratings r ON r.movieid = m.movieid
                WHERE g.genre = :genre
                GROUP BY m.movieid, m.title, m.releaseyear
                ORDER BY avgrating DESC
                LIMIT 12";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":genre",$genre);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

    static function getTop12MoviesForUser(string $email)   {
        $query = "SELECT DISTINCT m.movieid, m.title, m.releaseyear, AVG(r.rating) AS avgrating
                    FROM users u LEFT JOIN usergenre ug ON ug.userid = u.userid 
                        LEFT JOIN genres g ON g.genreid = ug.genreid 
                        LEFT JOIN moviegenre mg ON mg.genreid = g.genreid 
                        LEFT JOIN movies m ON m.movieid = mg.movieid
                        LEFT JOIN ratings r ON r.movieid = m.movieid
                    WHERE u.email = :email
                        AND m.title IS NOT NULL 
                        AND m.movieid NOT IN (SELECT m1.movieid 
                                            FROM movies m1 LEFT JOIN ratings r ON r.movieid = m1.movieid
                                                LEFT JOIN users u1 ON u1.userid = r.userid
                                            WHERE u1.email = :email)
                    GROUP BY m.movieid, m.title, m.releaseyear
                    ORDER BY avgrating DESC
                    LIMIT 12 ";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":email", $email);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

}
?>