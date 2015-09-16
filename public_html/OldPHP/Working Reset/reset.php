<?php

// Connect to MySQL
    $username = "wearezeu_phpserv"; 
    $password = "0!ZeusPhP!0"; 
    $host = "10.168.1.92"; 
    $dbname = "wearezeu_test01"; 
try {
$conn = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
//$conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');
}
catch(PDOException $ex) 
    { 
        $msg = "Failed to connect to the database"; 
    } 
    
// Was the form submitted?
if (isset($_POST["ResetPasswordForm"]))
{
	// Gather the post data
	$user_email = $_POST["user_email"];
	$user_password = $_POST["user_password"];
	$confirmpassword = $_POST["confirmpassword"];
	$hash = $_POST["q"];

	// Use the same salt from the forgot_password.php file
	$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

	// Generate the reset key
	$resetkey = md5($user_email);

	// Does the new reset key match the old one?
	if ($resetkey == $hash)
	{
		if ($user_password == $confirmpassword)
		{
			//has and secure the password
			$user_password = md5($user_password);

			// Update the user's password
				$query = $conn->prepare('UPDATE test_user SET user_password = :user_password WHERE user_email = :user_email');
				$query->bindParam(':user_password', $user_password);
				$query->bindParam(':user_email', $user_email);
				$query->execute();
				$conn = null;
			echo "Your password has been successfully reset.";
		}
		else
			echo "Your password's do not match.";
	}
	else
		echo "Your password reset key is invalid.";
}

?>

