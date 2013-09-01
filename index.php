<?php 
if(!isset($_GET['action'])){
	header("Location: index.php?action=login");
}else{
	$action = $_GET['action'];
}

switch ($action){
	//login
	case "login":
		include('login.php');
	break;
	
	//register
	case "register":
		include('register.php');
	break;
	
	case "open":
		include('open.php');
	break;
	
	case "write":
		include('write.php');
	break;
}

?>