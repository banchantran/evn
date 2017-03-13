<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/products_services/admin/admin.html.php");
	require_once(ROOT_PATH."modules/products_services/admin/admin.function.php");
	
	$sub_url = getParam('sub_url', 'str', '');
	if(!$sub_url)
		replace_location('profile');
	if(!$_SESSION['sub_cat'])	
		$_SESSION['sub_cat'] = $sub_url;
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listProducts_Services_detail();
			break;
		case "add":
			addProducts_Services_detail();
			break;
		case "edit":
			editProducts_Services_detail();
			break;	
		case "delete":
			deleteProducts_Services_detail();
			break;
		case "delete_image":
			deleteProducts_Services_detailImage();
			break;
		default:
			listProducts_Services_detail();
			break;
	}
?>