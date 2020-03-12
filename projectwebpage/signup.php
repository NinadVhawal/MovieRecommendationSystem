<?php

//Require configuration
require_once("inc/config.inc.php");

//Require Entities
require_once("inc/Entities/User.class.php");
require_once("inc/Entities/Genre.class.php");
require_once("inc/Entities/UserGenre.class.php");

//Require Utilities
require_once("inc/Utility/UserDAO.class.php");
require_once("inc/Utility/GenreDAO.class.php");
require_once("inc/Utility/UserGenreDAO.class.php");
require_once("inc/Utility/PDOAgent.class.php");

UserDAO::init();
GenreDAO::init();
UserGenreDAO::init();

//if a user data is passed, then add it to database;
if(isset($_POST['register'])){
    if(isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['age']) && isset($_POST['gender']) && isset($_POST['occupation']) && isset($_POST['password'])) {
		$user = new User();
		$user->setEmail($_POST['email']);
		$user->setPhone($_POST['phone']);
		$user->setAge($_POST['age']);
		$user->setGender($_POST['gender']);
		$user->setOccupation($_POST['occupation']);
		$user->setPassword($_POST['password']);
		if(!UserDAO::existingUser($_POST['email'])) {
			$uid = UserDAO::createUser($user);
			if($uid!="") {
				echo '<script language="javascript">alert("Your account has been created. Please click ok to login.")</script>';
				for($i=1;$i<=4;$i++){
					UserGenreDAO::saveUserGenre($uid, $_POST['genre'.$i]);
				}
				header('Location: login.php');
			}
		} else {
			echo '<script language="javascript">alert("Email id already exists.")</script>';
		}
    }
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>signup</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/line-awesome/css/line-awesome.min.css">
	<!-- Jquery -->
	<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
	<style>
		.page-content {
			background-image: url("movie3.jpg");
		}

		#mainlogo {
			display: block;
			margin-left: auto;
			margin-right: auto;
			padding: 0;
			width: 150px;
			height: 150;
		}

		.form-v4-content h2 {
    		margin-top: 20px;;
		}
	</style>
</head>
<body class="form-v4">
	
	<div class="page-content">
		<div class="form-v4-content">
			<form class="form-detail" action="#" method="post" id="myform">
			<img id="mainlogo" src="logo1.png" alt="MoviePro" >
				<h1 style="text-align: center;margin:0;padding:0; color:#3786BD;"> Welcome to MoviePro </h1>
				<h2 style="text-align: center;">Create an Account</h2>
				<div class="form-row">
					<input type="email" name="email" placeholder="*Your email address" id="email" class="input-text" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
				</div>
				<div class="form-group">
					<div class="form-row form-row-1">
						<input type="tel" name="phone" placeholder="*Your phone number like 123-456-7890" id="phone" class="input-text" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
					</div>
					<div class="form-row form-row-1">
						<input type="number" name="age" placeholder="*Your age" id="age" class="input-text" required pattern="^[1-9]$|^[1-9][0-9]$">
					</div>
				</div>
				<div class="form-group">
					<div class="form-row form-row-1 ">
						<select name="gender" id="gender" class="input-text">
							<option value="0" default>*--Your gender--</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
							<option value="O">Other</option>
						</select>
					</div>
					<div class="form-row form-row-1">
						<select name="occupation" id="occupation" class="input-text">
							<option value="0" default>*--Your occupation--</option>
							<?php 
								$occupations = array();
								$occupations = UserDAO::getOccupations();
								foreach($occupations as $o) {
									echo '<option value="'.$o->getOccupation().'">'.$o->getOccupation().'</option>';
								}
							?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="form-row form-row-1">
						<input type="password" name="password" placeholder="*Your password" id="password" class="input-text" required>
					</div>
					<div class="form-row form-row-1">
						<input type="password" name="cpassword" placeholder="*Confirm your password" id="cpassword" class="input-text" required>
					</div>
				</div>
				<div>
					<span id='passwordMatchMsg'></span>
				</div>
				<div class="form-group">
					<div class="form-row form-row-1">
						<select name="genre1" class="input-text">
							<option value="0" default>--First Genre--</option>
							<?php 
								$genres = array();
								$genres = GenreDAO::getGenres();
								foreach($genres as $g) {
									echo '<option value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
								}
							?>
						</select>					
					</div>
					<div class="form-row form-row-1">
						<select name="genre2" class="input-text">
							<option value="0" default>--Second Genre--</option>
							<?php 
								$genres = array();
								$genres = GenreDAO::getGenres();
								foreach($genres as $g) {
									echo '<option value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
								}
							?>
						</select>					
					</div>
					<div class="form-row form-row-1">
						<select name="genre3" class="input-text">
							<option value="0" default>--Third Genre--</option>
							<?php 
								$genres = array();
								$genres = GenreDAO::getGenres();
								foreach($genres as $g) {
									echo '<option value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
								}
							?>
						</select>					
					</div>
					<div class="form-row form-row-1">
						<select name="genre4" class="input-text">
							<option value="0" default>--Fourth Genre--</option>
							<?php 
								$genres = array();
								$genres = GenreDAO::getGenres();
								foreach($genres as $g) {
									echo '<option value="'.$g->getGenre().'">'.$g->getGenre().'</option>';
								}
							?>
						</select>					
					</div>
				</div>
				
				<div class="form-row-last">
					<input type="submit" name="register" class="register" value="register">
				</div>
				<div class="form-row-last">
					<input type="submit" name="account" class="account" value="Have An Account" onclick="location.href='login.php'">
				</div>
			</form>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script>
		//check whether 'password' and 'confirm password' are ready
		$('#password, #cpassword').on('keyup', function(){
			if($('#password').val().length  < 8){ // checks the password value length
				$('#passwordMatchMsg').html('Password should be more than 8 characters').css('color', 'red');
			}else{
				if ($('#password').val() == $('#cpassword').val()) {
					$('#passwordMatchMsg').html('Password and Confirm password are matching').css('color', 'green');
				}else{ 
					$('#passwordMatchMsg').html('Password and Confirm password are NOT matching').css('color', 'red');
				}	
			} 
		});

		// Validation for age
		$('#age').on('keyup', function(){
			if ($(this.value > 100 || this.value < 8)) {
				$('#age').css('border-color', 'red');
			} else {
				$('#age').css('border-color', 'green');
			}
		});
		//update end
	</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>