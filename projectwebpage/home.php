<?php

//Require configuration
require_once("inc/config.inc.php");

//Require Entities
require_once("inc/Entities/Movie.class.php");
require_once("inc/Entities/Genre.class.php");

//Require Utilities
require_once("inc/Utility/MovieDAO.class.php");
require_once("inc/Utility/PDOAgent.class.php");
require_once("inc/Utility/GenreDAO.class.php");

MovieDAO::init();
GenreDAO::init();

session_start();
$userEmail = $_SESSION['email'];

$movies = array();

if(isset($_POST['search'])) {
    $movies = MovieDAO::getMoviesLikeSearch($_POST['search']);
} elseif(isset($_POST['searchgenre']) && $_POST['searchgenre'] != "0") {
    $movies = MovieDAO::getMoviesByGenre($_POST['searchgenre']);
} else {
    $movies = MovieDAO::getTop12MoviesForUser($userEmail);
}


?>
<html>
<head>
	<meta charset="utf-8">
	<title>home</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/line-awesome/css/line-awesome.min.css">
	<!-- Jquery -->
	<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        body{
            /*background-image: url("movie1.jpg");*/
            background-color: #111814;
        }

        .topnav {
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
            background-color: #3786bd;
            max-height: 70px;
        }

        .topnav a {
            position: absolute;
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            top: 10px;
        }

        .topnav a:hover {
            background-color: #3786bd;
            color: black;
        }

        .topnav a.active {
            background-color: #3786bd;
            color: white;
        }

        .topnav form {
            padding: 14px 16px;
            text-align: center;
        }

        form.search {
            box-sizing: border-box;
        }

        form.search input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: #f1f1f1;
        }

        form.search button {
            float: left;
            width: 20%;
            padding: 12px;
            background: #2196F3;
            color: white;
            font-size: 17px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
        }

        form.search button:hover {
            background: #0b7dda;
        }

        form.search::after {
            content: "";
            clear: both;
            display: table;
        }

        .logout {
            width: 90px;
            position: relative;
            padding: 10px;
            float: right;
            margin: auto;
            bottom: 60px;
            right: 20px;
            font-size: 15px;
            /* background: #F4F4F0; */
            border-radius: 10px;
            background-color: honeydew;
            color: darkblue;    
        }

        /*the container must be positioned relative:*/
        .custom-select {
            position: relative;
            font-family: Arial;
        }

        .select-selected {
            background-color: #f6f6f6;
            width:250px;
        }

        /*style the arrow inside the select element:*/
        .select-selected:after {
            position: absolute;
            content: "";
            top: 14px;
            right: -60px;
            width: 0;
            height: 0;
            border: 6px solid transparent;
            border-color: black transparent transparent transparent;
        }

        /*point the arrow upwards when the select box is open (active):*/
        .select-selected.select-arrow-active:after {
            border-color: transparent transparent black transparent;
            top: 7px;
            float: right;
        }

        /*style the items (options), including the selected item:*/
        .select-items div,.select-selected {
            color: black;
            padding: 8px 16px;
            border: 1px solid transparent;
            border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
            cursor: pointer;
            user-select: none;
        }

        /*style items (options):*/
        .select-items {
            position: absolute;
            background-color: #f6f6f6;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 99;
            width: 284px;
        }

        /*hide the items when the select box is closed:*/
        .select-hide {
            display: none;
        }

        .select-items div:hover, .same-as-selected {
            background-color: rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <div class="topnav">
        <a class="active" href="home.php">Welcome, <b><?php echo $_SESSION['email']; ?></b></a>
        <form class="search" method="post" style="margin:auto;max-width:500px;">
            <?php if(isset($_POST['search'])) {
                echo '<input type="text" placeholder="Enter a movie name here..." name="search" value="'.$_POST['search'].'">';
            } else {
                echo '<input type="text" placeholder="Enter a movie name here..." name="search">';
            }
            ?>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <h1 style="text-align: center;color:white; position:absolute; top:3px; left:73%;"> MoviePro </h1>
        <button class="logout" onclick="location.href='login.php'">Logout <i class="fa fa-sign-out"></i></button>
    </div>
    
    <div class="top12" style="margin-top:20px;position:absolute;right:70px; ">
        <form method="post" action="#">
            <div class="top12list" style="width:280px; height:30px; float:left;">
                <select name="searchgenre" style="padding: 7px;">
                    <option value="0">View Top 12 Movies From..  &nbsp;&nbsp;</option>
                    <?php 
                        $genres = array();
                        $genres = GenreDAO::getGenres();
                        foreach($genres as $g) {
                            if($g->getGenre() == $_POST['searchgenre']) {
                                echo '<option selected value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
                            } else {
                                echo '<option value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    
    <div id="movies-table" class="clear">
        <?php
            if(isset($_POST['search'])) {
                echo '<h1 style="text-align:left;">Movies related to "'.$_POST['search'].'"</h1>';
            } elseif(isset($_POST['searchgenre'])) {
                echo '<h1 style="text-align:left;color:#DAF7A6;">Movies with genre "'.$_POST['searchgenre'].'"</h1>';
            } else {
                echo '<h1 style="text-align:left;color:#DAF7A6;">Recommended for you</h1>';
            } 
            foreach($movies as $m) {
                //get movie id
                $movieid = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=9dae942a73a1952fad380f9152168a83&query=".urlencode($m->getTitle()));
                $movieid = json_decode($movieid);
    
                //get movie details
                $moviedetails = file_get_contents("https://api.themoviedb.org/3/movie/".$movieid->results[0]->id."/credits?api_key=9dae942a73a1952fad380f9152168a83");
                $moviedetails = json_decode($moviedetails);
                
                //put the data in the list
                echo '<div class="movie">';
                echo '<h3>'.$m->getTitle().'<span><img style="height:160px;width:140px;" src="http://image.tmdb.org/t/p/original'.$movieid->results[0]->poster_path.'" alt="LOGO"></span></h3>';   
                echo '<ul>';
                echo '<li><b>Release year: </b> '.$m->getReleaseYear().'</li>';	
                echo '<li style="height:27px"><b>Cast: </b> '.$moviedetails->cast[0]->name.', '.$moviedetails->cast[1]->name.', '.$moviedetails->cast[2]->name.'</li>';
                echo '<li><b>Director: </b> '.$moviedetails->crew[0]->name.'</li>';
                echo '<li><b>Producer: </b> '.$moviedetails->crew[2]->name.'</li>';
                echo '</ul>';
                echo '<form style="margin:0;">';
                echo '<a href="review.php?title='.urlencode($m->getTitle()).'">Write Review</a><BR>';
                echo '<a href="comments.php?title='.urlencode($m->getTitle()).'">See Details</a><BR>';
                echo '<a href="https://www.youtube.com/results?search_query='.urlencode($m->getTitle()." trailer").'">Watch Trailer</a>';
                echo '</form>';
                echo '</div>';
            }
        ?>
        	
    </div>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script>
		// need to add logic to check whether 'password' and 'confirm password' are ready
        
		
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>