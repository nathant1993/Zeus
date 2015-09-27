<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <title>Zeus - Login</title>
  <meta name="Description" content="Zeus Agile Project Management Dashboard - Zeus is a cloud based project management tool. Zeus is primarily focussed on agile project management but no matter how you work Zeus can help.">
  <meta name="keywords" content="Zeus agile project management.">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72.png">
  <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
  <link rel="shortcut icon" href="../images/ico/favicon.ico">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>	
  <link rel="stylesheet" href="../css/login.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
            
            <form id="loginForm" name="loginForm" method="post" action="login-exec.php">
              <input type="text" name="user_email" id="user_email" placeholder="Email">
              <input type="password" name="user_password" id="user_password" placeholder="Password">
              <input type="submit" name="login" class="login login-submit" value="Login">
            </form>
            
            <div class="login-help">
                <!--<a href="register-form.php">Register</a> • <a href="forgot.html">Forgot Password</a>-->
            </div>
        </div>  	
			</div>	
		</div>			
	</div>
</body>
</html>
