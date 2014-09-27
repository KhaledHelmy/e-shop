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
	</head>
	<body>
		<?php
			echo "$error";
			require_once "partials/header.php";
			$result = mysql_query("SELECT * FROM products");
			while ($row = mysql_fetch_array($result)) {
				echo "
					<div class='item'>
						<p><img src=$row[image_url] width='100px' height='120px' /></p>
						<p>$row[title]</p>
				";
				if ($row['stock'] < 1) {
					echo "
						<img src='img/soldout.png' width='60px' height='60px' />
					";
				}
				else {
					echo "
						<p>
							<form action='confirmation.php' method='POST'>
								<input type='hidden' name='product_id' value='$row[id]'>
								<input type='image' src='img/cart.jpg' alt='Buy' width='25px' height='25px'>$row[price] EGP
							</form>
						</p>
					";
				}
				echo "
					</div>
				";
			}
		?>
	</body>
</html>
<?php $db->close() ?>