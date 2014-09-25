<?php
require_once 'classes/User.class.php';
require_once 'classes/UserTools.class.php';
require_once 'classes/DB.class.php';

//connect to the database
$db = new DB();
$db->connect();

//initialize UserTools object
$userTools = new UserTools();

//start the session
session_start();

$current_user;
$logged_in = false;
//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {
	$current_user = unserialize($_SESSION['user']);
	$_SESSION['user'] = serialize($userTools->get($current_user->id));
	$current_user = unserialize($_SESSION['user']);
	$logged_in = true;
}
?>