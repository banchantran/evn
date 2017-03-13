<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/news/admin/admin.html.php");
	require_once(ROOT_PATH."modules/news/admin/admin.function.php");
	$url = getParam('url', 'str', '');
	if(!$url)
		replace_location('profile');
	$_SESSION['cat'] = $url;	
	$sub_url = getParam('sub_url', 'str', '');
	if(!$sub_url)
		replace_location('profile');
	$_SESSION['sub_cat'] = $sub_url;
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listNews();
			break;
		case "add":
			addNews();
			break;
		case "edit":
			editNews();
			break;	
		case "delete":
			deleteNews();
			break;
		case "delete_image":
			deleteNewsImage();
			break;
		default:
			listNews();
			break;
	}
?>