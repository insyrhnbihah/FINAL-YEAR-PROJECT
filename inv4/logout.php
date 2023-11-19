<?php

// logout script
session_start();

if($_SESSION['user_role'] == 'staff'){
	$role = 'staff';
}else{
	$role = 'admin';
}

session_unset();

session_destroy();
	
if($role == 'staff'){
	header('Location: login.php');
}else{
	header('Location: admin.php');
}


?>