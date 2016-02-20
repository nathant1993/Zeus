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
	$user_forename = clean($conn, $_POST['user_forename']);
	$user_surname = clean($conn, $_POST['user_surname']);
	$user_email = clean($conn, $_POST['user_email']);
	$user_password = clean($conn, $_POST['user_password']);
	$cpassword = clean($conn, $_POST['cpassword']);
	
	//Create a unique salt. This will never leave PHP unencrypted.
	$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
    $encrypt_pass = hash('sha512', $salt.$user_password);

	
	//Input Validations
	if($user_forename == '') {
		$errmsg_arr[] = 'First name missing';
		$errflag = true;
	}
	if($user_surname == '') {
		$errmsg_arr[] = 'Last name missing';
		$errflag = true;
	}
	if($user_email == '') {
		$errmsg_arr[] = 'Email missing';
		$errflag = true;
	}
	if($user_password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	if($cpassword == '') {
		$errmsg_arr[] = 'Confirm password missing';
		$errflag = true;
	}
	if( strcmp($user_password, $cpassword) != 0 ) {
		$errmsg_arr[] = 'Passwords do not match';
		$errflag = true;
	}
	
	//Check for duplicate login ID
	if($login != '') {
		$qry = "SELECT * FROM users2 WHERE user_email='$user_email'";
		$result=mysqli_query($conn, $qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errmsg_arr[] = 'Email already in use';
				$errflag = true;
			}
			@mysqli_free_result($result);
		}
		else {
			die("Query failed");
		}
	}
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: register-form.php");
		exit();
	}

	//Create INSERT query
	$qry = "INSERT INTO users2 (user_forename, user_surname, user_email, user_password, user_role_id) VALUES('$user_forename','$user_surname','$user_email','$encrypt_pass', '2')";
	$result = mysqli_query($conn, $qry);
	
	//Check whether the query was successful or not
	if($result) {
		header("location: register-success.php");
		exit();
	}else {
		die("Query failed");
	}
    
    $conn->close();
?>