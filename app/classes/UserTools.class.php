<?php
//UserTools.class.php

require_once 'User.class.php';
require_once 'DB.class.php';

class UserTools {

	//Log the user in. First checks to see if the 
	//email and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login($email, $password)
	{

		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM users WHERE email = '$email' AND password = '$hashedPassword'");
		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			if(isset($_POST['remember_me'])) {
				$month = 60 * 60 * 24 * 30;
				$user = unserialize(($_SESSION['user']));
				setcookie('remember_me_user_email', $user->email, time() + $month);
				setcookie('remember_me_user_password', $password, time() + $month);
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function loginWithoutCookies($email, $password)
	{

		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM users WHERE email = '$email' AND password = '$hashedPassword'");
		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			return true;
		}else{
			return false;
		}
	}
	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['login_time']);
		unset($_SESSION['logged_in']);
		setcookie('remember_me_user_email', "", time() - 1000);
		setcookie('remember_me_user_password', "", time() - 1000);
		session_destroy();
	}

	//Check to see if a email exists.
	//This is called during registration to make sure all user names are unique.
	public function checkEmailExists($email) {
		$result = mysql_query("select id from users where email='$email'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//get a user
	//returns a User object. Takes the users id as an input
	public function get($id)
	{
		$db = new DB();
		$result = $db->select('users', "id = $id");
		return new User($result);
	}
	
}

?>