<?php
	require_once 'includes/global.inc.php';
	if (!$logged_in)
		header("Location: index.php");
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
				<img src=<?php echo "'$current_user->avatar'" ?> height=25 width=25/>
				<a href='edit.php'><?php echo "$current_user->firstname $current_user->lastname" ?></a><br/>
				<a href='logout.php'>Logout</a>
			</div>
		</div>
		<hr/>
	</body>
</html>
<?php $db->close(); ?>