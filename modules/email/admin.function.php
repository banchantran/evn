<?php
	function listEmail()
	{
		global $database;
		$query = 'SELECT * FROM `email` WHERE lang="'.$current_lang.'" ORDER BY region';
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

					$email_arr[$one_cat['id']] = $one_cat;
					$email_arr[$one_cat['id']]['level'] = 1;
			}
		}
		
		$action = getParam("action", 'str');
		$status = getParam("status", 'str');
		
		HTML_email_category::listEmail($email_arr);
	}
	function deleteEmail()
	{
		global $database;
		global $current_lang;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('delete from email where id = "'.$id.'"');
					$database->query();
				}
			}
		}
		replace_location('email_admin', array('curPg'));
	}
	function addEmail()
	{
		global $database;
		global $current_lang;
		$mid = getParam('mid', 'int', 0);
		$query = 'SELECT * FROM `email` ORDER BY id DESC';
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
				if(!$one_cat['parent_id'])
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO email (`title`, `user_create`, `time_create`, `user_update`, `time_update`)
				 VALUES('$title', '$user_create', '$time_create', '$user_create', '$time_create')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('email_admin');
				else
					replace_location('email_admin', array('task'=>'add'));
			}
		}
		HTML_email_category::updateEmail('', $all_arr, $error_array);
	}
	function editEmail()
	{
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `email` ORDER BY id DESC';
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
				if(!$one_cat['parent_id'])
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM email WHERE id = '".$id."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._EMAIL_NOT_EXISTS.'");
						window.location="'.generate_url('email_admin').'";
					</script>';
			return;
		}
		
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE email SET `title`='$title', `user_update`='$user_update', `time_update` = '$time_update' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				$query = "UPDATE email SET `title`='$title' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('email_admin', array('curPg'));
				else
					replace_location('email_admin', array('task'=>'add'));
			}
		}
		HTML_email_category::updateEmail($row, $all_arr, $error_array);
	}
?>