<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/articles/admin/admin.html.php");
	require_once(ROOT_PATH."modules/articles/admin/admin.function.php");
	
	$sub_url = getParam('sub_url', 'str', '');
	if(!$sub_url)
		replace_location('profile');
	if(!$_SESSION['sub_cat'])	
		$_SESSION['sub_cat'] = $sub_url;
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listArticles_detail();
			break;
		case "add":
			addArticles_detail();
			break;
		case "edit":
			editArticles_detail();
			break;	
		case "delete":
			deleteArticles_detail();
			break;
		case "delete_image":
			deleteArticles_detailImage();
			break;
		default:
			listArticles_detail();
			break;
	}
?>