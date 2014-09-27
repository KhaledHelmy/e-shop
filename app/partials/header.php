<link rel="stylesheet" type="text/css" href="css/credentials.css"/>
<link rel="stylesheet" type="text/css" href="css/all.css"/>
<div class="container">
	<h1>eShop</h1>
	<div class="pull-right">
		<?php
			if ($logged_in) {
				$current_user = unserialize($_SESSION['user']);
				echo "
				<img src='$current_user->avatar' height=25 width=25/>
				Welcome, <a href='edit.php'>$current_user->firstname $current_user->lastname</a><br/>
				<a href='index.php'>Home</a> |
				<a href='history.php'>History</a> |
				<a href='logout.php'>Logout</a>
				";
			}else{
				$user_email = "";
				$user_password = "";
				$checkbox_checked = "";

				if(isset($_COOKIE['remember_me_user_email'])) {
					$user_email = $_COOKIE['remember_me_user_email'];
				}

				if(isset($_COOKIE['remember_me_user_password'])) {
					$user_password = $_COOKIE['remember_me_user_password'];
				}

				if(isset($_COOKIE['remember_me_user_email']) && isset($_COOKIE['remember_me_user_password'])) {
					$checkbox_checked = "checked";
				}

				echo "
				<form action='index.php' method='POST' id='credentials'>
					<label for='emailform'>Email :</label>
					<input type='text' name='email' id='emailform' value='$user_email'/>
					<label for='passwordform'>Password :</label>
					<input type='password' name='password' id='passwordform' value='$user_password'/>
					<input type='submit' name='submit-login'value='Login'/>
					<label for='remembermecheckbox'>Remember Me </label>
					<input type='checkbox' name='remember_me' $checkbox_checked/>
				</form>
				<a href='register.php'>Register</a>
				";
			}
		?>
	</div>
</div>
<hr/>