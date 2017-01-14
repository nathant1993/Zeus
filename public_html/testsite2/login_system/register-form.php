<?php
	session_start();
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>Zeus - Register</title>
<meta name="Description" content="Zeus Agile Project Management Dashboard - Zeus is a cloud based project management tool. Zeus is primarily focussed on agile project management but no matter how you work Zeus can help.">
<meta name="keywords" content="Zeus agile project management.">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72.png">
<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
<link rel="shortcut icon" href="images/ico/favicon.ico">
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

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>
  <?php
    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
      echo '<ul class="err">';
      foreach($_SESSION['ERRMSG_ARR'] as $msg) {
        echo '<li>',$msg,'</li>'; 
      }
      echo '</ul>';
      unset($_SESSION['ERRMSG_ARR']);
    }
  ?>
  	<div id="hero">
		<div class="container clearfix">
			<div class="copy">
        <div class="login-card">
          <h1>Register</h1><br>
           
            <form id="loginForm" name="loginForm" method="post" action="register-exec.php">
              <input type="text" name="user_forename" id="user_forename" placeholder="First Name">
              <input type="text" name="user_surname" id="user_surname" placeholder="Last Name">
              <input type="text" name="user_email" id="user_email" placeholder="Email">
              <input type="password" name="user_password" id="user_password" placeholder="Password">
              <input type="password" name="cpassword" id="cpassword"  placeholder="Confirm Password">
              <input type="submit" name="register" class="login login-submit" value="Register">
              
              <!--<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr>
                  <th>First Name </th>
                  <td><input name="user_forename" type="text" class="textfield" id="user_forename" /></td>
                </tr>
                <tr>
                  <th>Last Name </th>
                  <td><input name="user_surname" type="text" class="textfield" id="user_surname" /></td>
                </tr>
                <tr>
                  <th width="124">Email</th>
                  <td width="168"><input name="user_email" type="text" class="textfield" id="user_email" /></td>
                </tr>
                <tr>
                  <th>Password</th>
                  <td><input name="user_password" type="password" class="textfield" id="user_password" /></td>
                </tr>
                <tr>
                  <th>Confirm Password </th>
                  <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Register" /></td>
                </tr>
              </table>-->
            </form>
            
        </div>  	
			</div>	
		</div>			
	</div>
</body>
</html>
