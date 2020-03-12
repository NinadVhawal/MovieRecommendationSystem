
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
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
		background-image: url("movie4.jpg");
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
			<h1 style="text-align: center;margin:0px;padding:0px; color:#3786BD;"> Welcome to MoviePro </h1>
				<h2 style="text-align: center;">Log In  </h2>
				<div class="form-row">
					<input placeholder="Your email" type="text" name="email" id="email" class="input-text" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
				</div>
				<div class="form-row">
					<input placeholder="Your password" type="password" name="password" id="password" class="input-text" required>
				</div>
				
				<div class="form-row-last">
					<p id="invalidCredentials" style="color:red; display:none;">Either your email or password are incorrect. Please try again.</p>
					<input type="submit" name="login" class="register" value="Log In">
				</div>
			</form>
		</div>
	</div>

	<?php
	//Require configuration
	require_once("inc/config.inc.php");

	//Require Entities
	require_once("inc/Entities/User.class.php");

	//Require Utilities
	require_once("inc/Utility/UserDAO.class.php");
	require_once("inc/Utility/PDOAgent.class.php");

	UserDAO::init();

	if(session_id() != '' || isset($_SESSION)) {
		// session isn't started
		session_destroy();
	}	

	//if a user data is passed, then add it to database;
	if(isset($_POST['login'])){
		if(isset($_POST['email']) && isset($_POST['password'])) {
			if(UserDAO::authenticateUser($_POST['email'], $_POST['password'])) {
				//user is authenticated
				session_start();
				$_SESSION['email'] = $_POST['email'];
				//echo '<script language="javascript">alert("Welcome '.$_SESSION['email'].'")</script>';
				header('Location: home.php');
			} else {
				//either email or password is wrong
				echo '<script type="text/javascript">document.getElementById("invalidCredentials").style.display="block";</script>';
			}
		}
	}
	?>

	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<!-- <script>
		// avoids form submit
		jQuery.validator.setDefaults({
		  	debug: true,
		  	success:  function(label){
        		label.attr('id', 'valid');
   		 	},
		});
		$( "#myform" ).validate({
		  	rules: {
			    password: "required",
		    	comfirm_password: {
		      		equalTo: "#password"
		    	}
		  	},
		  	messages: {
		  		first_name: {
		  			required: "Please enter a firstname"
		  		},
		  		last_name: {
		  			required: "Please enter a lastname"
		  		},
		  		your_email: {
		  			required: "Please provide an email"
		  		},
		  		password: {
	  				required: "Please enter a password"
		  		},
		  		comfirm_password: {
		  			required: "Please enter a password",
		      		equalTo: "Wrong Password"
		    	}
		  	}
		});
	</script> -->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>