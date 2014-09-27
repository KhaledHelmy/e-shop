<?php
	require_once 'includes/global.inc.php';
	$logged_in = false;
	$user;

	//check that product id exists
	if(!isset($_POST['product_id'])) {
		header("Location: index.php");
	}

	//check to see if they're logged in
	if(!isset($_SESSION['logged_in'])) {
		header("Location: index.php");
	}
	else {
		$logged_in = true;
		//get the user object from the session
		$user = unserialize($_SESSION['user']);
	}

	//check product exists and is in stock
	$result = mysql_query("SELECT * FROM products WHERE id = " . $_POST['product_id']);
	if(!($product = mysql_fetch_array($result)) || $product['stock'] < 1)
		header("Location: index.php");

	//check if the user already checked out the product
	if(isset($_POST['bought'])) {
		mysql_query("INSERT INTO transactions (user_id, product_id) VALUES (" . $user->id . ", " . $product['id'] . ")");
		$new_stock = $product['stock'] - 1;
		mysql_query("UPDATE products SET stock=" . $new_stock . " WHERE id=" . $product['id']);
		header("Location: index.php");
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
						<form action='checkout_verdict.php' method='POST'>
							<input type='submit' name='bought' value='Checkout' />
							<input type='hidden' name='product_id' value='$row[id]'>
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