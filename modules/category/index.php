<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
	if(!check_permission(getParam('mid', 'int', 0)))
		replace_location('home');
	require_once(ROOT_PATH."modules/category/admin.html.php");
	require_once(ROOT_PATH."modules/category/admin.function.php");
	unset($_SESSION['cat']);
	$task = getParam('task');	
	switch($task){
		case "list":	
			listCategory();
			break;
		case "add":
			addCategory();
			break;
		case "edit":
			editCategory();
			break;	
		case "delete":
			deleteCategory();
			break;
		default:
			listCategory();
			break;
	}
?>