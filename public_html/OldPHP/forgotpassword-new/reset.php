<?php
	session_start();
	
	//Get the token from the token table
	$token=$_GET['token'];
	
	//Database connection
	include("settings.php");
	
	connect();
	
	if(!isset($_POST['password'])){
		
		//Query to check whether the token has been used or not
		$q="SELECT email FROM tokens WHERE token='".$token."' AND used=0";
		$r=mysql_query($q);
		
		while($row=mysql_fetch_array($r)){
			$email=$row['email'];
			}
			If ($email!=''){
				$_SESSION['email']=$email;
			}
	//If token has already been used then display the following message		
	else die("Invalid link or Password already changed");}
	
	//Assign variables
	$pass=$_POST['password'];
	$email=$_SESSION['email'];
	
	if(!isset($pass)){ 
	
		// echo 
		// '<form method="post">
		// 	enter your new password:<input type="password" name="password" />
		// 	re-enter your new password:<input type="password" name="confirmPassword" />
		// 	<input type="submit" value="Change Password">
		// </form>';
	?>
	
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta charset="UTF-8">
	<title>Zeus - Login</title>
	<meta name="Description" content="Zeus Agile Project Management Dashboard - Login Page">
	<meta name="keywords" content="Zeus agile project management Login">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
	<link rel="shortcut icon" href="../images/ico/favicon.ico">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>	
	<link rel="stylesheet" href="../css/popupstyle.css">
	<link rel="stylesheet" href="../css/login.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="../js/resetPassword.js"></script>
	<script src="../js/velocity.js"></script>
	<script src="../js/velocity.ui.js"></script>
	
	<!-- Google Analytics code, need to add this to all pages!-->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-60923636-1', 'auto');
		ga('send', 'pageview');
	</script>
	
	</head>
	
	<body>
	
	<div id="hero">
			<div class="container clearfix">
				<div class="copy">
					<div class="login-card">
						<h1>Log-in</h1><br>
						
						<!--Forgot password form-->
						<form id="loginForm" name="loginForm" method="post">
							<label for="password">Enter your new password:</label>
							<input type="password" id="password" name="password" />
							
							<label for="confirmPassword">re-enter your new password:</label>
							<input type="password" id="confirmPassword" name="confirmPassword" />
							<!--<input type="button" id="resetPasswordButton" class="login login-submit" value ="testbutton">-->
							<input type="submit" class="login login-submit" id="resetPasswordButton" value="Change Password">
						</form>
						
						<div class="login-help">
							<!--<a href="register-form.php">Register</a> • <a href="forgot.html">Forgot Password</a>-->
						</div>
					</div>  	
				</div>	
			</div>
			
			<div id="greyOut">
   			</div>

			<!-- Popup Div Starts Here -->
			<div id="popupContact">
			</div>	
					
		</div>
	</body>
	</html>
		
	<?php
		}
	//Make sure that all variables have been set
	if(isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_SESSION['email']) )
	{
		//Validate whether the password and confirm password match one another
		if(($_POST['password']) === ($_POST['confirmPassword'])){
			
			//Query to update the user table and replace the old password with the new one entered
			$q="UPDATE test_user SET user_password='".md5($pass)."' WHERE user_email='".$email."'";
			$r=mysql_query($q);
			
			//Query to update the tokens table and set a token as used so that it cannot be used again
			if($r)mysql_query("UPDATE tokens SET used=1 WHERE token='".$token."'");
			echo "Your password is changed successfully";
			if(!$r)echo "An error occurred";
		}
		
		//If passwords do not match then display the reset password form again
			else echo('
			<form method="post">
				enter your new password:<input type="password" name="password" />
				re-enter your new password:<input type="password" name="confirmPassword" />
				<input type="submit" value="Change Password">
				</form>
			<h1>Passwords do not match<h1>');
	}
	else echo('Please enter a password into both fields');
	
?>