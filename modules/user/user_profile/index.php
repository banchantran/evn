<?php
//	Chuc nang chinh  	: 	Quan tri thông tin cá nhân

	//Kiem tra quyen
	if(!is_login())
		replace_location('home');
		
	require_once(ROOT_PATH."modules/user/user_profile/admin.html.php");
	require_once(ROOT_PATH."modules/user/user_profile/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "edit":
			editProfile();
			break;	
		case "change_pass":
			changePass();
			break;				
		default:
			editProfile();
			break;
	}
?>	