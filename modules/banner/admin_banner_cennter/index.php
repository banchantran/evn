<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/banner/admin_banner_cennter/admin.html.php");
	require_once(ROOT_PATH."modules/banner/admin_banner_cennter/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listBanner_cennter();
			break;
		case "add":
			addBanner_cennter();
			break;
		case "edit":
			editBanner_cennter();
			break;	
		case "delete":
			deleteBanner_cennter();
			break;
		case "delete_image":
			deleteBanner_cennterImage();
			break;
		default:
			listBanner_cennter();
			break;
	}
?>