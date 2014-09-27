<?php
	require_once 'includes/global.inc.php';
	$logged_in = false;
	$user;

	$error_html = "	<html>
						<title>Verdict</title>
						<body>
							Something went wrong, please try agian later. Sorry for any inconvenience.
							<a href='index.php'>Go To Home</a>
						</body>
					</html>";

	if(!isset($_SESSION['logged_in'])) {
		require_once "partials/header.php";
		echo $error_html;
	}
	else{
		$logged_in = true;
		//get the user object from the session
		$user = unserialize($_SESSION['user']);
		require_once "partials/header.php";

		if(!isset($_POST['product_id'])) {
			echo $error_html;
		}
		else {
			$result = mysql_query("SELECT * FROM products WHERE id = " . $_POST['product_id']);
			if(!($product = mysql_fetch_array($result)) || $product['stock'] < 1) {
				echo $error_html;
			}

			//check if the user already checked out the product
			else if(isset($_POST['bought'])) {
				mysql_query("INSERT INTO transactions (user_id, product_id) VALUES (" . $user->id . ", " . $product['id'] . ")");
				$new_stock = $product['stock'] - 1;
				mysql_query("UPDATE products SET stock=" . $new_stock . " WHERE id=" . $product['id']);
				
				echo "	<html>
							<title>Verdict</title>
							<body>
								You purchase was successful!
								<a href='index.php'>Go To Home</a>
							</body>
						</html>";
			}
			else {
				echo $error_html;
			}
		}
	}
?>
<?php $db->close() ?>