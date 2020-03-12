<?php

class RatingDAO   {

    private static $db;

    public static function init() {
        self::$db= new PDOAgent("Rating");
    }

    static function getReviews(string $movieTitle)   {
        $query = "SELECT review,
                        (SELECT u.email FROM users u WHERE u.userid = r.userid) AS email
                    FROM ratings r
                    WHERE movieid=(SELECT movieid FROM movies WHERE title=:title)
                        AND review IS NOT NULL
                        AND review != ''
                    ORDER BY timestamp DESC";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":title",$movieTitle);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->resultSet();
    }

    static function getAverageRating(string $movieTitle)   {
        $query = "SELECT AVG(rating) AS rating
                    FROM ratings
                    WHERE movieid=(SELECT movieid FROM movies WHERE title=:title)
                    GROUP BY movieid;";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":title",$movieTitle);
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->singleResult();
    }

    static function insertReview(string $email, string $title, string $rating, string $review)   {
        $query = "INSERT INTO `ratings`(userid,movieid,rating,review,timestamp) 
                    VALUES((SELECT userid FROM users WHERE email=:email),
                            (SELECT movieid FROM movies WHERE title=:title),
                            :rating,
                            :review,
                            :timestamp)";
        //Query
        self::$db->query($query);
        //Bind
        self::$db->bind(":email", $email);
        self::$db->bind(":title", $title);
        self::$db->bind(":rating", $rating);
        self::$db->bind(":review", $review);
        self::$db->bind(":timestamp", mktime());
        //Execute!
        self::$db->execute();
        //Return the results!
        return self::$db->rowCount();
    }

}
?>