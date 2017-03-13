<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
	require_once(ROOT_PATH."modules/articles/category_admin/admin.html.php");
	require_once(ROOT_PATH."modules/articles/category_admin/admin.function.php");
	
	$url = getParam('url', 'str', '');
	if(!$url)
		replace_location('profile');
	$_SESSION['cat'] = $url;
	if($_SESSION['sub_cat'])
		unset($_SESSION['sub_cat']);
	$task = getParam('task');	
	switch($task){
		case "list":	
			listArticles_cat();
			break;
		case "add":
			addArticles_cat();
			break;
		case "edit":
			editArticles_cat();
			break;	
		case "delete":
			deleteArticles_cat();
			break;
		default:
			listArticles_cat();
			break;
	}
?>