<?php
	require_once 'includes/global.inc.php';
	$logged_in = false;
	$user;
	//check to see if they're logged in
	if(!isset($_SESSION['logged_in']) || !isset($_POST['product_id'])) {
		header("Location: index.php");
	}
	else {
		$logged_in = true;
		//get the user object from the session
		$user = unserialize($_SESSION['user']);
	}
?>
<html>
	<head>
		<title>Confirmation</title>
	</head>
	<body>
		<?php
			require_once "partials/header.php";
			echo "<h2>Confirmation</h2>";
			$user_id = $user->id;
			$product_id = $_POST['product_id'];
			$result = mysql_query("SELECT * FROM products WHERE $product_id = id");
			if ($result) {
				while ($row = mysql_fetch_array($result)) {
					echo "
						<p>$row[title], $row[price] EGP</p>
						<hr>
						<div><strong>Total $row[price] EGP</strong></div>
						<form method='POST'>
							<input type='submit' value='Checkout' />
						</form>
					";
				}
			}
			else {
				header("Location: index.php");
			}
		?>
	</body>
</html>
<?php $db->close() ?>