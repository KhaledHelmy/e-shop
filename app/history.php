<?php
	require_once 'includes/global.inc.php';
	$logged_in = false;
	$user;
	//check to see if they're logged in
	if(isset($_SESSION['logged_in'])) {
		$logged_in = true;
		//get the user object from the session
		$user = unserialize($_SESSION['user']);
	}
	else {
		header("Location: index.php");
	}
?>
<html>
	<head>
		<title>History</title>
	</head>
	<body>
		<?php
			require_once "partials/header.php";
			$user_id = $user->id;
			$result = mysql_query("SELECT * FROM transactions, products WHERE $user_id = user_id AND product_id = products.id");
			if ($result) {
				while ($row = mysql_fetch_array($result)) {
					echo "
						<div class='item'>
							<p><img src=$row[image_url] width='100px' height='120px' /></p>
							<p>$row[title]</p>
							<p>$row[price] EGP</p>
							<p>$row[created_at]</p>
						</div>
					";
				}
			}
		?>
	</body>
</html>
<?php $db->close() ?>