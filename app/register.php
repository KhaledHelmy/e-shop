<?php
//register.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
$firstname = "";
$lastname = "";
$password = "";
$password_confirm = "";
$email = "";
$avatar = "";
$error = "";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];
	$avatar = $_POST['avatar'];

	//initialize variables for form validation
	$success = true;
	$userTools = new UserTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($userTools->checkEmailExists($email))
	{
		$error .= "That email is already taken.<br/> \n\r";
		$success = false;
	}

	//check to see if passwords match
	if($password != $password_confirm) {
		$error .= "Passwords do not match.<br/> \n\r";
		$success = false;
	}

	if($success)
	{
		//prep the data for saving in a new user object
		$data['first_name'] = $firstname;
		$data['last_name'] = $lastname;
		$data['password'] = md5($password); //encrypt the password for storage
		$data['email'] = $email;
		if(!empty($avatar))
			$data['avatar'] = $avatar;

		//create the new user object
		$newUser = new User($data);

		//save the new user to the database
		$newUser->save(true);

		//log them in
		$userTools->login($email, $password);

		//redirect them to a welcome page
		header("Location: index.php");

	}

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
	<title>Registration</title>
</head>
<body>
	<?php echo ($error != "") ? $error : ""; ?>
	<form action="register.php" method="post">

	E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
	First Name: <input type="text" value="<?php echo $firstname; ?>" name="firstname" /><br/>
	Last Name: <input type="text" value="<?php echo $lastname; ?>" name="lastname" /><br/>
	Photo Url: <input type="text" value="<?php echo $avatar; ?>" name="avatar" /><br/>
	Password: <input type="password" name="password" /><br/>
	Password (confirm): <input type="password" name="password-confirm" /><br/>
	
	<input type="submit" value="Register" name="submit-form" />

	</form>
</body>
</html>