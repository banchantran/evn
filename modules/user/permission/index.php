  <?php
	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');
	require_once(ROOT_PATH."modules/user/permission/admin.html.php");
	require_once(ROOT_PATH."modules/user/permission/admin.function.php");
	
	$task = getParam('task');	
	switch($task){
		case "list":	
			listPermission();
			break;
		case "edit":
			editPermission();
			break;	
		case "delete":
			deletePermission();
			break;
		default:
		{			
			listPermission();
			addPermission();
			break;
		}
	}
?>