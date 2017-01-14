<?php
	//Start session
	session_start();
	
	//Include database connection details
	//require_once('config.php');
	include('DatabaseCon.php');
    
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
    // Create connection
    $conn = new mysqli($host, $user_name, $pwd, $dbName);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($conn, $data)  {
		$data = trim($data);
		if(get_magic_quotes_gpc()) {
			$data = stripslashes($data);
		}
		$data = mysqli_real_escape_string($conn, $data);
    return $data;
	}
	
	//Sanitize the POST values
	$user_email = clean($conn, $_POST['user_email']);
	$user_password = clean($conn, $_POST['user_password']);
	$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
	$decrypt_pass = hash('sha512', $salt.$user_password);
	
	//Input Validations
	if($user_email == '') {
		$errmsg_arr[] = 'Email missing';
		$errflag = true;
	}
	if($user_password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: login-form.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM users2 WHERE user_email='$user_email' AND user_password='$decrypt_pass'";
	$result=mysqli_query($conn, $qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) == 1) {
			//Login Successful
			//Store variables for the session
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['user_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['user_forename'];
			$_SESSION['SESS_LAST_NAME'] = $member['user_surname'];
			$_SESSION['SESS_EMAIL_ADD'] = $member['user_email'];
			session_write_close();
			header("location: ../dashboard/projects.php");
			exit();
		}else {
			//Login failed
			header("location: login-failed.php");
			exit();
		}
	}else {
		die("Query failed");
	}
    
    $conn->close();
?>