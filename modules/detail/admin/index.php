<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/detail/admin/admin.html.php");
	require_once(ROOT_PATH."modules/detail/admin/admin.function.php");
	$url = getParam('url', 'str', '');
	if(!$url)
		replace_location('profile');
	$_SESSION['cat'] = $url;
	$task = getParam('task');	
	switch($task){
		case "list":	
			listdetail();
			break;
		case "add":
			adddetail();
			break;
		case "edit":
			editdetail();
			break;	
		case "delete":
			deletedetail();
			break;
			break;
		default:
			listdetail();
			break;
	}
?>