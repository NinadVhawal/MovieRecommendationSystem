<?php

//Require configuration
require_once("inc/config.inc.php");

//Require Entities
require_once("inc/Entities/Movie.class.php");
require_once("inc/Entities/Rating.class.php");

//Require Utilities
require_once("inc/Utility/MovieDAO.class.php");
require_once("inc/Utility/RatingDAO.class.php");
require_once("inc/Utility/PDOAgent.class.php");

MovieDAO::init();
RatingDAO::init();
session_start();

if(isset($_GET['title'])) {
    $movieTitle = urldecode($_GET['title']);
    $movie = MovieDAO::getMovie($movieTitle);
}

//if a review is passed, then add it to database;
if(isset($_POST['sendreview'])){
    if(isset($_POST['rating']) && isset($_POST['review'])) {
        $rating = RatingDAO::insertReview($_SESSION['email'],$movieTitle,$_POST['rating'],$_POST['review']);
        if($rating!="") {
            header('Location: comments.php?title='.urlencode($movieTitle));
        }
    }
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Movie Review</title>
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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        
        body {
            background-image: url("movie1.jpg");
        }
        .topnav {
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
            background-color: #3786bd;
            max-height: 60px;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #3786bd;
            color: black;
        }

        .topnav a.active {
            background-color: #3786bd;
            color: white;
        }

        .logout {
            width: 90px;
            position: relative;
            padding: 10px;
            float: right;
            margin: auto;
            right: 20px;
            font-size: 15px;
            /* background: #F4F4F0; */
            border-radius: 10px;
            background-color: honeydew;
            color: darkblue;
            top:5px;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
            visibility: hidden;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

        .imagebg {
            /*background-image: url("images/mixing-desk-351478_1920.jpg");
            background-repeat: no-repeat;*/
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            -webkit-filter: blur(3px);
            filter: blur(3px);
            opacity: 0.6;
            filter: alpha(opacity=60);
        }
        .form-container
        {
            background-color: #eee;
            box-shadow: 0 16px 24px 2px rgba(0,0,0,0.14), 0 20px 30px 5px rgba(0,0,0,0.12), 0 8px 10px -5px rgba(0,0,0,0.3);
            border-radius: 8px;	
            font-family: 'Montserrat', Arial, Helvetica, sans-serif;
            clear: both;
        }

        .main-movie-info{
            float:left;
            width:90%;
            background-color: #eee;
            color: black;
            margin: 20px;
            margin-left: 70px;
            font-size: 16; 
            font-family: 'Montserrat', Arial, Helvetica, sans-serif;
            box-shadow: 0 16px 24px 2px rgba(0,0,0,0.14), 0 20px 30px 5px rgba(0,0,0,0.12), 0 8px 10px -5px rgba(0,0,0,0.3);
            border-radius: 8px;
            height: auto;
        }

        .main-movie-info .movie-poster{
            float:left;
            margin:0;
            padding:0;
            padding-right: 15px;
            padding-bottom: 10px;
        }

        .main-movie-info .movie-info{
            margin:0;
            padding-left: 15px;
        }

        
    </style>
</head>
<body>
    <?php 
        //get movie id
        $movieid = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=9dae942a73a1952fad380f9152168a83&query=".urlencode($movieTitle));
        $movieid = json_decode($movieid);

        //get movie details
        $moviedetails = file_get_contents("https://api.themoviedb.org/3/movie/".$movieid->results[0]->id."/credits?api_key=9dae942a73a1952fad380f9152168a83");
        $moviedetails = json_decode($moviedetails);
    ?>
    <div class="topnav">
        <a class="active" href="home.php">Welcome, <b><?php echo $_SESSION['email']; ?></b></a>
        <h1 style="text-align: center; margin:0px; padding:0px; color:white; position:absolute; left:45%; top:7px;"> MoviePro </h1>
        <button class="logout" onclick="location.href='login.php'">Logout <i class="fa fa-sign-out"></i></button>
    </div>
    <div class= "main-movie-info"> 
        <div class="movie-poster">
            <?php echo '<img src="http://image.tmdb.org/t/p/w185'.$movieid->results[0]->poster_path.'" alt="LOGO">' ?>
        </div>
        <div class="movie-info">
            <h2> <?php echo $movieTitle; ?> (<?php echo $movie->getReleaseYear(); ?>) </h1>
            <h4> <b>Director</b>: <?php echo $moviedetails->crew[0]->name; ?></h4>
            <h4> <b>Cast</b>: <?php echo $moviedetails->cast[0]->name.", ".$moviedetails->cast[1]->name.", ".$moviedetails->cast[2]->name;?></h4>
            <h4> <b>Producer</b>: <?php echo $moviedetails->crew[2]->name; ?></h4>
            <p> <?php echo $movieid->results[0]->overview; ?> </p>
        </div>
    </div>
    <div class="container">
            <div class="imagebg"></div>
            <div class="row " style="margin-top: 50px">
                <div class="col-md-6 col-md-offset-3 form-container" style="margin:0;width:100%;">
                    <h2>Leave a review..</h2> 

                    <form role="form" action="#" method="post" id="reused_form">
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="email"> Email:</label>
                                <?php echo '<input type="email" value="'.$_SESSION["email"].'" class="form-control" id="email" name="email" readonly>'; ?>
                            </div>                      
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">    
                            <label style="padding-top:15px;"> Ratings:</label>
                                <div class="rate">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                            </div>                  
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <textarea class="form-control" type="textarea" name="review" id="review" placeholder="Please type your review here..." maxlength="6000" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <button type="submit" name="sendreview" class="btn btn-lg btn-warning btn-block" >Submit </button>
                            </div>
                        </div>
                    </form>
                   <!-- <div id="success_message" style="width:100%; height:100%; display:none; "> <h3>Posted your feedback successfully!</h3> </div>
                    <div id="error_message" style="width:100%; height:100%; display:none; "> <h3>Error</h3> Sorry there was an error sending your form. </div> -->
                </div>
            </div>
        </div>          
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script>
		//show trailer logic by Ninad - 21st November 2019

		
	</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>