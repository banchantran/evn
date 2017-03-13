<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
	require_once(ROOT_PATH."modules/news/category_admin/admin.html.php");
	require_once(ROOT_PATH."modules/news/category_admin/admin.function.php");
	
	$url = getParam('url', 'str', '');
	if(!$url)
		replace_location('profile');
	$_SESSION['cat'] = $url;
	if($_SESSION['sub_cat'])
		unset($_SESSION['sub_cat']);
	$task = getParam('task');	
	switch($task){
		case "list":	
			listNews_Category();
			break;
		case "add":
			addNews_Category();
			break;
		case "edit":
			editNews_Category();
			break;	
		case "delete":
			deleteNews_Category();
			break;
		default:
			listNews_Category();
			break;
	}
?>