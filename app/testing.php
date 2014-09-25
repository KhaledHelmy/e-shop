<?php
$test = "";
if(isset($_POST['submit-form'])) {
	$test = $_POST['test'];
	echo $test;
	if(empty(trim($test)))
		echo "True";
	else
		echo "False";
}
?>
<form action="testing.php" method="post">
	First Name: <input type="text" value="<?php echo $test; ?>" name="test" /><br/>
	<input type="submit" value="Register" name="submit-form" />
</form>