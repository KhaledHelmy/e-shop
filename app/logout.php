<?php
//logout.php
require_once 'includes/global.inc.php';

$userTools = new UserTools();
$userTools->logout();

$db->close();
header("Location: index.php");
?>