<?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');	
	require_once(ROOT_PATH."modules/products/admin.html.php");
	require_once(ROOT_PATH."modules/products/admin.function.php");
	
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
		default:
			listProduct();
			break;
	}
?>