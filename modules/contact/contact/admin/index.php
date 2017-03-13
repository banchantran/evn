<?php
//	Project            	:  	EPAGE
//	Nguoi tao          	:   GiangNM (01/09/2008)
//	Sua doi            	:   
//	Chuc nang chinh  	: 	Quan tri lien he

	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
		
	require_once(ROOT_PATH."modules/contact/contact/admin/admin.html.php");
	require_once(ROOT_PATH."modules/contact/contact/admin/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listContact();
			break;
		case "edit":
			editContact();
			break;	
		case "delete":
			deleteContact();
			break;
		default:
			listContact();
			break;
	}
?>