<div class="boder123" style="margin-top:3px;" align="center">
    <div class="td_left"><div class="td_left_text"><?php echo _LOGIN;?></div></div>
<?php
	//	Chuc nang chinh  	: 	Module dang nhap
	if(!is_login())
	{	
		$act = getParam("form_name");
		if($act == "doLogin")
		{
			$user_name = getParam("user_name");
			$password = getParam("password");
			if(trim($user_name)=="" || trim($password)=="")
			{
				if(trim($user_name)=="")
					$user_error = '<div class="message">'._USER_EMPTY.'</div>';
				if(trim($password)=="")
					$password_error = '<div class="message">'._PASSWORD_EMPTY.'</div>';
			}
			else
			{
				global $database;
				$password = encode_password($password);
				$query = 'SELECT * FROM user WHERE user_name = "'.$user_name.'" AND password = "'.$password.'"';
				$database->setQuery($query);
				$user = $database->loadRow();
				if($database->getErrorNum())
				{
					echo $database->stderr();
					exit();
				}
				if(is_array($user))
				{
					$_SESSION["user"] = $user;
					//replace_location('profile');
					//exit();
				}
				else
				{
					$user_pass_valid = '<br /><div class="message">'._USER_PASS_VALID.'</div>';
				}
			}
		}
?>
<form id="form1" name="form1" method="post" action="">    
    <input type="text" name="user_name" style="width:166px; margin:3px;" value="Tài khoản" />
    <input type="password" name="password" style="width:166px; margin:3px;" value="mat khau" />
    <input  type="submit"  value="Login" style="margin:3px;" />
	<input type="hidden" name="form_name" value="doLogin" />
</form>
	<?php
    }
    else
    {
    ?>
        <div style="font-family:Arial, Arial, Helvetica, sans-serif; font-size:12px; text-align:left; padding-bottom:10px; padding-top:10px; padding-left:5px; font-weight:bold;">
            <a href="<?php echo generate_url('profile');?>"><?php echo _PROFILE;?></a><br />
            <a href="<?php echo generate_url('sign_out');?>"><?php echo _LOGOUT;?></a>
        </div>
    <?php
    }
    ?>
</div>