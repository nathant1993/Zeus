<?php
// Connect to MySQL
    $username = "wearezeu_phpserv"; 
    $password = "0!ZeusPhP!0"; 
    $host = "10.168.1.92"; 
    $dbname = "wearezeu_test01"; 
try {
$conn = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
}
catch(PDOException $ex) 
    { 
        $msg = "Failed to connect to the database"; 
    } 

// Was the form submitted?
if (isset($_POST["ForgotPassword"])) {
	
	// Harvest submitted e-mail address
	if (filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
		$user_email = $_POST["user_email"];
		
	}else{
		echo "email is not valid";
		exit;
	}

	// Check to see if a user exists with this e-mail
	$query = $conn->prepare('SELECT user_email FROM test_user WHERE user_email = :user_email');
	$query->bindParam(':user_email', $user_email);
	$query->execute();
	$userExists = $query->fetch(PDO::FETCH_ASSOC);
	$conn = null;
	
	if ($userExists["user_email"])
	{
		// Create a unique salt. This will never leave PHP unencrypted.
		$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

		// Create the unique user password reset key
		$password = md5( $userExists["user_email"]);

		// Create a url which we will direct them to reset their password
		$pwrurl = "www.wearezeus.co.uk/testsite/reset_password.php?q=".$password;
		
		// Mail them their key
		$mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website www.wearezeus.co.uk\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nAdmin";
		mail($userExists["user_email"], "wearezeus.co.uk - Password Reset", $mailbody);
		echo "Your password recovery key has been sent to your e-mail address.";
		
	}
	else
		echo "No user with that e-mail address exists.";
}
?>
