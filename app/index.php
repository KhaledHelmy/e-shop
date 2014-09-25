<?php
	require_once 'includes/global.inc.php';
	$error = "";
	$email = "";
	$password = "";
	//check to see if they've submitted the login form
	if(isset($_POST['submit-login'])) { 

		$email = $_POST['email'];
		$password = $_POST['password'];

		$userTools = new UserTools();
		if(!$userTools->login($email, $password)){
			$error = "Incorrect email or password. Please try again.";
		}
	}
	$logged_in = false;
	$user;
	//check to see if they're logged in
	if(isset($_SESSION['logged_in'])) {
		$logged_in = true;
		//get the user object from the session
		$user = unserialize($_SESSION['user']);
	}
?>
<html>
	<head>
		<title>eShop</title>
		<link rel="stylesheet" type="text/css" href="css/credentials.css"/>
		<link rel="stylesheet" type="text/css" href="css/all.css"/>
	</head>
	<body>
		<div class="container">
			<h1>eShop</h1>
			<div class="pull-right">
				<?php
					echo $error;
					if ($logged_in) {
						echo "
						<img src='$user->avatar' height=25 width=25/>
						<a href='edit.php'>$user->firstname $user->lastname</a><br/>
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
		<?php
			$result = mysql_query("SELECT * FROM products");
			while ($row = mysql_fetch_array($result)) {
				echo "
					<div class='item'>
						<p><img src=$row[image_url] width='100px' height='120px' /></p>
						<p>$row[title]</p>
						<p>$row[price] EGP</p>
					</div>
				";
			}
		?>
	</body>
</html>
<?php $db->close() ?>