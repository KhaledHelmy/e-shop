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

	if(empty($email) || empty($firstname) || empty($password) || empty($password_confirm))
	{
		$error .= "Some required fields are missing.<br/> \n\r";
		$success = false;
	}

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
	<?php require_once "partials/header.php"; ?>
	<?php echo ($error != "") ? $error : ""; ?>
	<center>
		<form action="register.php" method="POST">
			<fieldset style="width:250px">
				<legend align="center">Register</legend>
				
				<p><input type="email" value="<?php echo $email; ?>" name="email" placeholder="Email (required)" size="30" required /><p/>
				<p><input type="text" value="<?php echo $firstname; ?>" name="firstname" placeholder="First Name (required)" size="30" required /><p/>
				<p><input type="text" value="<?php echo $lastname; ?>" name="lastname" placeholder="Last Name" size="30" /><p/>
				<p><input type="text" value="<?php echo $avatar; ?>" name="avatar" placeholder="Avatar URL" size="30" /><p/>
				<p><input type="password" name="password" placeholder="Password (required)" size="30" required /><p/>
				<p><input type="password" name="password-confirm" placeholder="Confirm Password (required)" size="30" required /><p/>
				
				<input type="submit" value="Register" name="submit-form" />
			</fieldset>
		</form>
	</center>
</body>
</html>