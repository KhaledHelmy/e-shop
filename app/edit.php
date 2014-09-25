<?php
	require_once 'includes/global.inc.php';
	if (!$logged_in)
		header("Location: index.php");

	//initialize php variables used in the form
	$firstname = $current_user->firstname;
	$lastname = $current_user->lastname;
	$password = "";
	$password_confirm = "";
	$password_current = "";
	$email = $current_user->email;
	$avatar = $current_user->avatar;
	$error_edit = "";

	//check to see that the form has been submitted
	if(isset($_POST['submit-form'])) {

		//retrieve the $_POST variables
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = $_POST['password'];
		$password_confirm = $_POST['password-confirm'];
		$password_current = $_POST['current_password'];
		$email = $_POST['email'];
		$avatar = $_POST['avatar'];

		//initialize variables for form validation
		$success = true;
		$userTools = new UserTools();

		//validate the current password
		// echo $current_user->hashedPassword . "<br/>";
		// echo $password_current;
		if(empty($password_current) || md5($password_current) != $current_user->hashedPassword){
			$error_edit .= "The entered Password does not match your current password.<br/> \n\r";
			$success = false;
		}

		//validate that the form was filled out correctly
		//check to see if user name already exists
		if(trim($current_user->email) != trim($email) && $userTools->checkEmailExists($email))
		{
			$error_edit .= "That email is already taken.<br/> \n\r";
			$success = false;
		}

		//check to see if passwords match
		if(!empty(trim($password)) && $password != $password_confirm) {
			$error_edit .= "Passwords do not match.<br/> \n\r";
			$success = false;
		}

		if($success)
		{
			//prep the data for saving in a new user object
			$current_user->firstname = $firstname;
			$current_user->lastname = $lastname;
			if(!empty(trim($password)))
				$current_user->hashedPassword = md5(trim($password)); //encrypt the password for storage
			$current_user->email = $email;
			$current_user->avatar = $avatar;

			//save the current user to the database
			$current_user->save();
	
			//redirect them to a welcome page
			header("Location: index.php");

		}
	}
?>
<html>
	<head>
		<title>Edit Profile</title>
	</head>
	<body>
		<?php
			require_once "partials/header.php"
		?>
		<?php echo ($error_edit != "") ? $error_edit : ""; ?>
		<form action="edit.php" method="post">
			E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
			First Name: <input type="text" value="<?php echo $firstname; ?>" name="firstname" /><br/>
			Last Name: <input type="text" value="<?php echo $lastname; ?>" name="lastname" /><br/>
			Photo Url: <input type="text" value="<?php echo $avatar; ?>" name="avatar" /><br/>
			Current Password: <input type="password" name="current_password" /><br/>
			New Password: <input type="password" name="password" /><br/>
			New Password (confirm): <input type="password" name="password-confirm" /><br/>

			<input type="submit" value="Update" name="submit-form" />
		</form>
	</body>
</html>
<?php $db->close(); ?>