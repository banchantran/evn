<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
		
	require_once(ROOT_PATH."modules/products_services/category_admin/admin.html.php");
	require_once(ROOT_PATH."modules/products_services/category_admin/admin.function.php");
	
	
	$url = getParam('url', 'str', '');
	if(!$url)
		replace_location('profile');
	$_SESSION['cat'] = $url;
	if($_SESSION['sub_cat'])
		unset($_SESSION['sub_cat']);
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listProduct();
			break;
		case "add":
			addProduct();
			break;
		case "edit":
			editProduct();
			break;	
		case "delete":
			deleteProduct();
			break;
		case "delete_image":
			deleteProductImage();
			break;
		case "delete_image_home":
			deleteProductImageHome();
			break;
		case "delete_image_banner":
			deleteProductImageBanner();
			break;
		default:
			listProduct();
			break;
	}
?>