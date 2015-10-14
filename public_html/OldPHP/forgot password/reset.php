<?php
	ob_start();
	
	session_start();
	
	$token=$_GET['token'];
	
	include("settings.php");
	
	connect();
	
	if(!isset($_POST['password'])){
		$q="SELECT email FROM tokens WHERE token='".$token."' AND used=0";
		$r=mysql_query($q);
		
		while($row=mysql_fetch_array($r)){
			$email=$row['email'];
			}
			If ($email!=''){
				$_SESSION['email']=$email;
			}
	else die("Invalid link or Password already changed");}
	
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
	<link rel="stylesheet" href="../css/signup.css">
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
						<h1>Reset Password</h1>
						
						<form id="loginForm" name="loginForm" method="post">
							<label for="password">Enter your new password:</label>
							<input type="password" id="password" name="password" />
							
							<label for="confirmPassword">re-enter your new password:</label>
							<input type="password" id="confirmPassword" name="confirmPassword" />
							<!--<input type="button" id="resetPasswordButton" class="login login-submit" value ="testbutton">-->
							<input type="submit" class="login login-submit" id="resetPasswordButton" value="Change Password">
						</form>
						
						<div id="success" class="status clearfix" style="opacity:1; transition: opacity 1s;">
						</div>
						
						<div class="login-help">
							<!--<a href="register-form.php">Register</a> • <a href="forgot.html">Forgot Password</a>-->
						</div>
					</div>  	
				</div>	
			</div>	
		</div>
	</body>
	</html>
		
	<?php
		}
	
	if(isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_SESSION['email']) )
	{
			if(($_POST['password']) != ($_POST['confirmPassword'])){
			echo("passwords do not match");	
		}
			elseif((strlen($_POST["password"]) < '8')){
			echo("Your Password Must Contain At Least 8 Characters");
		}
			elseif(!preg_match("#[0-9]+#",$pass)){
        	echo("Your Password Must Contain At Least 1 Number");
    	}
			elseif(!preg_match("#[A-Z]+#",$pass)){
       		echo("Your Password Must Contain At Least 1 Capital Letter");
   		}
    		elseif(!preg_match("#[a-z]+#",$pass)){
       		echo("Your Password Must Contain At Least 1 Lowercase Letter");
    	}
		
		else
		
		{
			$q="UPDATE test_user SET user_password='".md5($pass)."' WHERE user_email='".$email."'";
			$r=mysql_query($q);
		
			if($r)mysql_query("UPDATE tokens SET used=1 WHERE token='".$token."'"); 
			header('Location: ../login_system/password-reset-success.php');
			if(!$r)echo "An error occurred";
		}
		// else echo('
		// 	<form method="post">
		// 		enter your new password:<input type="password" name="password" />
		// 		re-enter your new password:<input type="password" name="confirmPassword" />
		// 		<input type="submit" value="Change Password">
		// 		</form>
		// 	<h1>Passwords do not match<h1>');
	}
	
	
?>