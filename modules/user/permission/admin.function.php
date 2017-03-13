<?php
	function listPermission()
	{
		global $database;
		global $current_lang;
		$curPg = getParam('curPg', 'int', 1);
		$uid = getParam('uid', 'int', 0);
		$itemPerPage = 10;
		$numPageShow = 10;
		$totalRows = $database->getNumRows('permission', ' lang="'.$current_lang.'"');
		$query = 'SELECT * FROM `permission` WHERE lang="'.$current_lang.'" AND uid='.$uid;
		$database->setQuery($query);
		$rows = $database->loadResult();
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		if($rows)
		{
			foreach($rows as $one_cat)
			{
					$permission_arr[$one_cat['id']] = $one_cat;
					$permission_arr[$one_cat['id']]['level'] = 1;
			}
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_permission_category::listPermission($permission_arr, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deletePermission()
	{
		global $database;
		global $current_lang;
		$id = getParam('id', 'int');
		if($id)
		{
			$database->setQuery('delete from permission where id = "'.$id.'" and lang="'.$current_lang.'"');
			$database->query();
		}
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('delete from permission where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('permission_admin', array('uid'=>getParam('uid', 'int', 0), 'curPg'));
	}
	function addPermission()
	{
		global $database;
		global $current_lang;
		$uid = getParam('uid', 'int', 0);
		$query = 'SELECT * FROM `permission` WHERE lang="'.$current_lang.'" AND uid ='.$uid;
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$mid = getParam('module_id', 'int');
			$uid = getParam('uid', 'int', 0);
			$is_valid = 1;			
			if($is_valid)
			{
				$region = getParam('region', 'int', 0);
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$title = module_title($mid);
				$query = "INSERT INTO permission (`title`,`uid` , `mid`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`)
				 VALUES('$title', '$uid', '$mid', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('permission_admin', array('uid'=>getParam('uid', 'int', 0)));
				else
					replace_location('permission_admin', array('uid'=>getParam('uid', 'int', 0), 'task'=>'add'));
			}
		}
		HTML_permission_category::updatePermission('', $all_arr, $error_array);
	}
	function editPermission()
	{
		global $database;
		global $current_lang;
		$uid = getParam('uid', 'int');
		$query = 'SELECT * FROM `permission` WHERE lang="'.$current_lang.'" AND uid='.$uid;
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM permission WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._PERMISSION_NOT_EXISTS.'");
						window.location="'.generate_url('permission_admin', array('uid'=>getParam('uid', 'int', 0))).'";
					</script>';
			return;
		}
		
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$mid = getParam('module_id', 'int');
			$uid = getParam('uid', 'int', 0);
			$is_valid = 1;
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$title = module_title($mid);
				$query = "UPDATE permission SET `title`='$title', `uid`='$uid', `mid`='$mid', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				$query = "UPDATE permission SET `mid`='$mid' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('permission_admin', array('uid'=>getParam('uid', 'int', 0), 'curPg'));
				else
					replace_location('permission_admin', array('uid'=>getParam('uid', 'int', 0), 'task'=>'add'));
			}
		}
		HTML_permission_category::updatePermission($row, $all_arr, $error_array);
	}
?>