<?php
	require_once 'includes/global.inc.php';
	$error = "";
	$username = "";
	$password = "";
	//check to see if they've submitted the login form
	if(isset($_POST['submit-login'])) { 

		$username = $_POST['username'];
		$password = $_POST['password'];

		$userTools = new UserTools();
		if(!$userTools->login($username, $password)){
			$error = "Incorrect username or password. Please try again.";
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
							<label for='usernameform'>User Name :</label>
							<input type='text' name='username' id='usernameform'/>
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
						<img src=$row[image_url] /><br>
						$row[title]<br>
						$row[price] EGP
					</div>
				";
				//echo $row{'title'}." ".$row{'stock'}." "."<img src='".$row{'image_url'}."'/>"."<br>";
			}
		?>
	</body>
</html>
<?php $db->close() ?>