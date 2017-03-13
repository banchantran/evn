<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('home');
		
	require_once(ROOT_PATH."modules/banner/admin_banner_mid/admin.html.php");
	require_once(ROOT_PATH."modules/banner/admin_banner_mid/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listBannerMid();
			break;
		case "add":
			addBannerMid();
			break;
		case "edit":
			editBannerMid();
			break;	
		case "delete":
			deleteBannerMid();
			break;
		case "delete_image":
			deleteBannerMidImage();
			break;
		default:
			listBannerMid();
			break;
	}
?>