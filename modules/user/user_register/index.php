<?php
//	Chuc nang chinh  	: 	Dang ki thanh vien

	global $database;
	$action = getParam("action", 'str');
	$error_array = array();
	if (isset($_SESSION['security_code']))
	{
		@unlink('data/images/ocr_captcha/'.md5($_SESSION['security_code']).'.png');
	}
	if($action == "save")
	{
		if (isset($_SESSION['security_code']))
		{
			@unlink('data/images/ocr_captcha/'.md5($_SESSION['security_code']).'.png');
		}
		if(!$_REQUEST['register_agree'])
			$error_array['register_agree'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
		elseif(strtolower($_REQUEST['security_code'])!=$_SESSION['security_code'])
		{
			$error_array['security_code'] = '<span class="require_field">'._SECURITY_CODE_NOT_VALID.'</span>';
		}
		else
		{
			$password 		=	$_REQUEST['password'];
			$verify_password =	$_REQUEST['verify_password'];
			$full_name = getParam("full_name", 'str');
			$order_name = get_end_word($full_name);
			$user_name		=	strtolower(getParam('user_name'));
			$birth_date = to_time(getParam("str_day", 'int', ''), getParam("str_month", 'int', ''), getParam("str_year", 'int', ''));
			if(!$birth_date)
				$birth_date = time();
			$gender = getParam("gender", 'int', 0);
			$email = getParam("email", 'str');
			$phone = getParam("phone", 'str');
			$address = getParam("address", 'str');
			$register_date = time();
			$lastvisit_date = time();
			$is_valid = 1;
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
			if ($password!=$verify_password)
			{
				$this->error('verify_password', _PASSWORD_NOT_MATCH);
			}
			if(!$email)
			{
				$error_array['email'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$full_name)
			{
				$error_array['full_name'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$query = "SELECT id FROM user WHERE user_name = '".$user_name."' or email='".$email."'";
				$database->setQuery($query);
				$check = $database->loadRow();
				
				if($check['user_name']==$user_name)
				{
					$error_array['user_name'] = '<span class="require_field">'._USER_EXISTS.'</span>';;
				}
				elseif($check['email']==$email)
				{
					$error_array['email'] = '<span class="require_field">'._EMAIL_EXISTS.'</span>';;
				}
				else
				{
					$password = encode_password($password);
					$query = "INSERT INTO user (full_name, order_name, user_name, password, email, phone, address, `lock`, `gender`, `birth_date`, `usergroup`, `register_date`, `lastvisit_date`)
					 VALUES('$full_name', '$order_name', '$user_name', '$password', '$email', '$phone', '$address', '0', '$gender', '$birth_date', '0', '$register_date', '$lastvisit_date')";
					$database->setQuery($query);
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					}
					if (isset($_SESSION['security_code']))
					{
						unset($_SESSION['security_code']);
					}
					replace_location('home');
				}
			}
		}
	}
?>	
<form name="FormRegister" method="post">
<table width="100%">
	<tbody>
		<tr><td colspan="2"><strong><?php echo _ACCOUNT_INFOMATION;?></strong></td></tr>
		<tr>
			<td align="right" width="170px">
				<?php echo _USER_NAME; ?> <span class="require_field">(*)</span>
			</td>
			<td>
				<input name="user_name" class="inputbox" size="40" value="<?php echo getParam('user_name', 'str', $row['user_name']);?>" maxlength="50" type="text">&nbsp;<?php echo $error_array['user_name']; ?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _PASSWORD; ?> <span class="require_field">(*)</span>
			</td>
			<td>
			<input class="inputbox" name="password" size="40" value="" type="password">&nbsp;<?php echo $error_array['password']; ?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _VERIFY_PASSWORD; ?> <span class="require_field">(*)</span>
			</td>
			<td>
			<input class="inputbox" name="verify_password" size="40" value="" type="password">&nbsp;<?php echo $error_array['verify_password']; echo $error_array['password_not_match']; ?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _EMAIL; ?> <span class="require_field">(*)</span>
			</td>
			<td>
				<input class="inputbox" name="email" size="40" value="<?php echo getParam('email', 'str', $row['email']);?>" type="text">&nbsp;<?php echo $error_array['email']; ?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2" style="border-top:#999999 1px dotted">&nbsp;</td></tr>
		<tr><td colspan="2"><strong><?php echo _PERSIONAL_INFOMATION;?></strong></td></tr>
		<tr>
			<td align="right">
				<?php echo _FULL_NAME; ?> <span class="require_field">(*)</span>
			</td>
			<td>
				<input name="full_name" class="inputbox" size="40" value="<?php echo getParam('full_name', 'str', $row['full_name']);?>" maxlength="50" type="text">&nbsp;<?php echo $error_array['full_name']; ?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _BIRTH_DATE; ?>
			</td>
			<td>
				<select name="str_month">
					<?php 
						if($row['birth_date'])
							$month_select = date('m', $row['birth_date']);
						else
							$month_select = date('m', time());
						echo get_option_month(getParam('str_month', 'int', $month_select));
					?>
				</select>&nbsp;
				<select name="str_day">
					<?php
						if($row['birth_date'])
							$day_select = date('d', $row['birth_date']);
						else
							$day_select = date('d', time());
						echo get_option_day(getParam('str_day', 'int', $day_select));
					?>
				</select>&nbsp;
				<select name="str_year">
					<?php 
						if($row['birth_date'])
							$year_select = date('Y', $row['birth_date']);
						else
							$year_select = date('Y', time());
						echo get_option_year(getParam('str_year', 'int', $year_select));
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _GENDER; ?>
			</td>
			<td>
				<select name="gender"><?php $gender_array = array('0'=>_MALE, '1'=>_FEMALE); echo get_option($gender_array, getParam('gender', 'int', $row['gender'])); ?></select>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _PHONE; ?>
			</td>
			<td>
				<input class="inputbox" name="phone" size="40" value="<?php echo getParam('phone', 'str', $row['phone']);?>" type="text">
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo _ADDRESS; ?>
			</td>
			<td>
				<input class="inputbox" name="address" size="40" value="<?php echo getParam('address', 'str', $row['address']);?>" type="text">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2" style="border-top:#999999 1px dotted">&nbsp;</td></tr>
		<tr>
			<td align="right">
				<?php echo _TYPE_CODE_SHOW; ?>
			</td>
			<td>
				<input class="inputbox" name="security_code" size="20" value="" type="text">&nbsp;<?php echo $error_array['security_code']; ?>
			</td>
		</tr>
		<tr valign="top">
			<td align="right"><a href=""><img src="<?php echo SITE_PATH;?>themes/images/refresh.gif" border="0" /></a></td>
			<td>
				<?php 
					require_once(ROOT_PATH."includes/ocr_captcha.php");
					$p = new ocr_captcha();
					echo $p->display_captcha(false);
					$_SESSION['security_code']=$p->public_key;
				?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td>
				<input name="register_agree" tabindex="18" type="checkbox" checked="checked">&nbsp;
				<?php 
					echo _AGREE;
					echo '<br />'.$error_array['register_agree'];
				?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="<?php echo _REGISTER; ?>" />&nbsp;<input type="button" value="<?php echo _REGISTER_CANCEL; ?>" onclick="window.location='<?php echo generate_url('')?>'" /></td></tr>
	</tbody>
</table>
<input type="hidden" name="action" value="save" />
</form>