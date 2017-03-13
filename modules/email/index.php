<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
	require_once(ROOT_PATH."modules/email/admin.html.php");
	require_once(ROOT_PATH."modules/email/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listEmail();
			break;
		case "add":
			addEmail();
			break;
		case "edit":
			editEmail();
			break;	
		case "delete":
			deleteEmail();
			break;
		default:
			listEmail();
			break;
	}
?>