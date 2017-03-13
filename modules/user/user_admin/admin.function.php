<?php
	//List user
	function listUsers()
	{
		global $database;
		$totalRows = 0;
		$itemPerPage = 30;
		$numPageShow = 10;
		$curPg = getParam('curPg', 'int', 1);
		
		$totalRows = $database->getNumRows('user');
		
		$query = 'SELECT * FROM `user` ORDER BY order_name limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$users = $database->loadResult();

		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_user::listUsers($users, $pagging, ($curPg-1)*$itemPerPage);
	}
	function addUser()
	{
		global $database;
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$full_name = getParam("full_name", 'str');
			$order_name = get_end_word($full_name);
			$user_name = getParam("user_name", 'str');
			$password = getParam("password", 'str');
			$verify_password = getParam("verify_password", 'str');
			$birth_date = to_time(getParam("str_day", 'int', ''), getParam("str_month", 'int', ''), getParam("str_year", 'int', ''));
			if(!$birth_date)
				$birth_date = time();
			$gender = getParam("gender", 'int', 0);
			$permission = getParam("permission", 'int', 0);
			$email = getParam("email", 'str');
			$phone = getParam("phone", 'str');
			$address = getParam("address", 'str');
			$lock = getParam("lock", 'int', 0);
			$is_valid = 1;
			if(!$full_name)
			{
				$error_array['full_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$user_name)
			{
				$error_array['user_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$password)
			{
				$error_array['password'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$verify_password)
			{
				$error_array['verify_password'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			elseif($password != $verify_password)
			{
				$error_array['password_not_match'] = '<span class="require_field">'._PASSWORD_NOT_MATCH.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$query = "SELECT id FROM user WHERE user_name = '".$user_name."'";
				$database->setQuery($query);
				$check = $database->loadRow();
				
				if($check!="")
				{
					$error_array['user_exist'] = '<span class="require_field">'._USER_EXISTS.'</span>';;
				}
				else
				{
					$password = encode_password($password);
					$query = "INSERT INTO user (full_name, order_name, user_name, password, email, phone, address, `lock`, `gender`, `birth_date`, `usergroup`)
					 VALUES('$full_name', '$order_name', '$user_name', '$password', '$email', '$phone', '$address', '$lock', '$gender', '$birth_date', '$permission')";
					$database->setQuery($query);
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					} 
					if($action == "save")
						replace_location('user_admin');
					else
						replace_location('user_admin', array('task'=>'add'));
				}
			}
		}
		HTML_user::updateUsers('', $error_array);
	}
	function editUser()
	{
		global $database;
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM user WHERE id = '".$id."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._USER_NOT_EXISTS.'");
						window.location="'.generate_url('user_admin', array('curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$full_name = getParam("full_name", 'str');
			$order_name = get_end_word($full_name);
			$user_name = getParam("user_name", 'str');
			$password = getParam("password", 'str');
			$verify_password = getParam("verify_password", 'str');
			$birth_date = getParam("birth_date", 'str');
			$gender = getParam("gender", 'int', 0);
			$permission = getParam("permission", 'int', 0);
			$email = getParam("email", 'str');
			$phone = getParam("phone", 'str');
			$address = getParam("address", 'str');
			$lock = getParam("lock", 'int', 0);
			$is_valid = 1;
			$birth_date = to_time(getParam("str_day", 'int', ''), getParam("str_month", 'int', ''), getParam("str_year", 'int', ''));
			if(!$birth_date)
				$birth_date = time();
			if(!$full_name)
			{
				$error_array['full_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$user_name)
			{
				$error_array['user_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if($password && $verify_password && ($password != $verify_password))
			{
				$error_array['password_not_match'] = '<span class="require_field">'._PASSWORD_NOT_MATCH.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$query = "SELECT id FROM user WHERE user_name = '".$user_name."' and id <>'".$id."'";
				$database->setQuery($query);
				$check = $database->loadRow();
				
				if($check!="")
				{
					$error_array['user_exist'] = '<span class="require_field">'._USER_EXISTS.'</span>';;
				}
				else
				{
					if($password)
						$password = encode_password($password);
					else
						$password = $row['password'];
					
					$query = "UPDATE user SET full_name='$full_name',order_name = '$order_name',user_name='$user_name', password = '$password', email='$email', phone='$phone', address = '$address',`lock` = '$lock', `gender`='$gender', `birth_date`='$birth_date', `usergroup`='$permission' WHERE `id`='".$id."'";
					$database->setQuery($query);
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					} 
					if($action == "save")
						replace_location('user_admin');
					else
						replace_location('user_admin', array('task'=>'add'));
				}
			}
		}
		HTML_user::updateUsers($row, $error_array);
	}
	function deleteUser()
	{
		global $database;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('delete from user where id = "'.$id.'"');
					$database->query();
				}
			}
		}
		replace_location('user_admin', array('curPg'));
	}
	function lockUser()
	{
		global $database;
		$id = getParam('id', 'int');
		$query="UPDATE user SET `lock`=1 WHERE id='".$id."'";
		$database->setQuery($query);
		$database->query();
		replace_location('user_admin', array('curPg'));
	}
	function unLockUser()
	{
		global $database;
		$id = getParam('id', 'int');
		$query="UPDATE user SET `lock`=0 WHERE id='".$id."'";
		$database->setQuery($query);
		$database->query();
		replace_location('user_admin', array('curPg'));
	}
?>