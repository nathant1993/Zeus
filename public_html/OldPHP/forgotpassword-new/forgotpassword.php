<?php
   //PHP form for inputting email address
    if(!isset($_GET['email'])){
    echo
        '<form action="forgotpassword.php">
        Enter Your Email address:
        <input type="text" name="email" />
        <input type="submit" value="Reset My Password" />
        </form>'; 
        exit();
    }
    
    //Store email address entered into a variable
    $email=$_GET['email'];
    
    //Database connection
    include("settings.php");
    
    connect();
    
    //Query to check whether the email address entered is stored within the database
    $q="SELECT user_email FROM test_user WHERE user_email='".$email."'";
    $r=mysql_query($q);
    $n=mysql_num_rows($r);
    
    if($n==0){
        echo "If you're registered we will send you an email with instructions on how to reset your password."; 
        die();
    }
    
    //Assign a randomly generated string to the variable $token
    $token=getRandomString(10);
    
    //Insert the random token into a table in the database
    $q="INSERT INTO tokens (token,email) VALUES ('".$token."','".$email."')";
    mysql_query($q);
    
    //Create the random string using specified characters
    function getRandomString($length) {
        $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
        $validCharNumber = strlen($validCharacters);
        $result = "";
    
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        return $result;}
        
    //Email the person with a link to reset their password    
    function mailresetlink($to,$token){
        $subject = "Forgot Password on zeus.co.uk";
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
        $headers .= 'From: Admin<group@wearezeus.co.uk>' . "\r\n";
        
        //If a reset link has been sent a message will appear
        if(mail($to,$subject,$message,$headers)){
            echo "If you're registered we will send you an email with instructions on how to reset your password. <b>".$to."</b>"; 
        }
    }
    
    if(isset($_GET['email']))mailresetlink($email,$token);
?>