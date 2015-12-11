<?php

//Display the form for entering user's email address
    if(!isset($_GET['email'])){
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
            <link href="http://fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet" type="text/css">	
            <link rel="stylesheet" href="../css/login.css">
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
            <script src="../js/velocity.js"></script>
            <script src="../js/velocity.ui.js"></script>
            
            </head>
            
            <body>
            
            <div id="hero">
                    <div class="container clearfix">
                        <div class="copy">
                    <div class="login-card">
                        <h1>Reset Password</h1><br>
                        
                        <form id="loginForm" name="loginForm" method="post" action="forgotpassword.php">
                        <input type="text" name="email" id="email" placeholder="Enter Your Email address">
                        <input type="submit" name="login" class="login login-submit" value="Reset My Password">
                        </form>
                        
                    </div>  	
                        </div>	
                    </div>			
                </div>
            </body>
        </html>
<?php
        exit();
    }
    
    //Store the email in a variable
    $email=$_GET['email'];
    
    //Include connection details
    include("settings.php");
    
    connect();
    
    //Query to check whether the user exists within the database.
    $q="SELECT user_email FROM test_user WHERE user_email='".$email."'";
    $r=mysql_query($q);
    $n=mysql_num_rows($r);
    
    if($n==0){
        echo "If you're registered we will send you an email with instructions on how to reset your password."; 
        die();
    }
    
    //Store a random string into a variable
    $token=getRandomString(10);
    
    //Insert the token and the email into a database table
    $q="INSERT INTO tokens (token,email) VALUES ('".$token."','".$email."')";
    mysql_query($q);
    
    //Parameters for generating a random string
    function getRandomString($length) {
        $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
        $validCharNumber = strlen($validCharacters);
        $result = "";
    
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        return $result;}
    
    //If the users email does exist in the database then send the following email with a link with the randomly generated token so that only that users email link can reset the password   
    function mailresetlink($to,$token){
        //Subject line
        $subject = "Forgot Password on zeus.co.uk";
        //The website that you have requested this for
        $uri = 'http://'. $_SERVER['HTTP_HOST'] ;
        $message = '
            <html>
                <head>
                    <title>Forgot Password For zeus.co.uk</title>
                </head>
                <body>
                    <p>Click on the given link to reset your password <a href="'.$uri.'/testsite/reset.php?token='.$token.'">Reset Password</a></p>
                </body>
            </html>';
            
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        //The email address that it was sent from
        $headers .= 'From: Admin<group@wearezeus.co.uk>' . "\r\n";
        
        if(mail($to,$subject,$message,$headers)){
            echo "If you're registered we will send you an email with instructions on how to reset your password. <b>".$to."</b>"; 
        }
    }
    
    if(isset($_GET['email']))mailresetlink($email,$token);
?>