<link rel="stylesheet" type="text/css" href="css/credentials.css"/>
<link rel="stylesheet" type="text/css" href="css/all.css"/>
<div class="container">
	<h1>eShop</h1>
	<div class="pull-right">
		<?php
			if ($logged_in) {
				echo "
				<img src='$current_user->avatar' height=25 width=25/>
				Welcome, <a href='edit.php'>$current_user->firstname $current_user->lastname</a><br/>
				<a href='logout.php'>Logout</a>
				";
			}else{
				echo "
				<form action='index.php' method='POST' id='credentials'>
					<label for='emailform'>Email :</label>
					<input type='text' name='email' id='emailform'/>
					<label for='passwordform'>Password :</label>
					<input type='text' name='password' id='passwordform'/>
					<input type='submit' name='submit-login'value='Login'/>
				</form>
				<a href='register.php'>Register</a>
				";
			}
		?>
	</div>
</div>
<hr/>