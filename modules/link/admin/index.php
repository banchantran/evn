<?php
	if(!is_content_management())
		replace_location('sign_in');
		
	require_once(ROOT_PATH."modules/link/admin/admin.html.php");
	require_once(ROOT_PATH."modules/link/admin/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listLink();
			break;
		case "add":
			addLink();
			break;
		case "edit":
			editLink();
			break;	
		case "delete":
			deleteLink();
			break;
		default:
			listLink();
			break;
	}
?>