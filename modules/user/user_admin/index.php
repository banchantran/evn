<?php
//	Chuc nang chinh  	: 	Quan tri nguoi dung

	//Kiem tra quyen
	if(!is_admin())
		replace_location('sign_in');
		
	require_once(ROOT_PATH."modules/user/user_admin/admin.html.php");
	require_once(ROOT_PATH."modules/user/user_admin/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listUsers();
			break;
		case "add":
			addUser();
			break;
		case "edit":
			editUser();
			break;	
		case "lock":
			lockUser();
			break;				
		case "unLock":
			unLockUser();
			break;	
		case "delete":
			deleteUser();
			break;	
		default:
			listUsers();
			break;
	}
?>	