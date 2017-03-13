<?php
	function editProfile()
	{
		global $database;
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save")
		{
			$full_name = getParam("full_name", 'str');
			$order_name = get_end_word($full_name);
			$birth_date = to_time(getParam("str_day", 'int', ''), getParam("str_month", 'int', ''), getParam("str_year", 'int', ''));
			if(!$birth_date)
				$birth_date = time();
			$gender = getParam("gender", 'int', 0);
			$email = getParam("email", 'str');
			$phone = getParam("phone", 'str');
			$address = getParam("address", 'str');
			$is_valid = 1;
			if(!$full_name)
			{
				$error_array['full_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$query = "UPDATE user SET full_name='$full_name',order_name = '$order_name',email='$email', phone='$phone', address = '$address',`gender`='$gender', `birth_date`='$birth_date' WHERE `id`='".$_SESSION['user']['id']."'";
				$database->setQuery($query);
				$database->query();
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				}
				$query = 'SELECT * FROM user WHERE id = "'.$_SESSION['user']['id'].'"';
				$database->setQuery($query);
				$user = $database->loadRow();
				if($database->getErrorNum())
				{
					echo $database->stderr();
					exit();
				}
				if(is_array($user))
				{
					unset($_SESSION["user"]);
					$_SESSION["user"] = $user;
				}
				replace_location('profile');
			}
		}
		HTML_profile::editProfile($_SESSION['user'], $error_array);
	}
	function changePass()
	{
		global $database;
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save")
		{
			$old_pass = getParam("old_pass", 'str');
			$password = getParam("password", 'str');
			$verify_password = getParam("verify_password", 'str');
			$is_valid = 1;
			if(!$old_pass)
			{
				$error_array['old_pass'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			else
			{
				$old_pass = encode_password($old_pass);
				if($old_pass != $_SESSION['user']['password'])
				{
					$error_array['old_pass_valid'] = '<span class="require_field">'._OLD_PASS_NOT_VALID.'</span>';
					$is_valid = 0;
				}
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
				$password = encode_password($password);		
				$query = "UPDATE user SET password='$password' WHERE `id`='".$_SESSION['user']['id']."'";
				$database->setQuery($query);
				$database->query();
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				}
				$_SESSION["user"]['password'] = $password;
				replace_location('profile');
			}
		}
		HTML_profile::changePass($_SESSION['user'], $error_array);
	}
?>