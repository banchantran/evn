<?php
	//	Chuc nang chinh  	: 	Module dang nhap
	$act = getParam("form_name");
	if(is_login())
		replace_location('profile');
	else
	{
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
					replace_location('profile');
					exit();
				}
				else
				{
					$user_pass_valid = '<br /><div class="message">'._USER_PASS_VALID.'</div>';
				}
			}
		}
?>
<script type="text/javascript" language="javascript">
	function submits()
	{
		var user_name = document.getElementById("user_name").value;
		var password = document.getElementById("password").value;
		if(user_name == "User name" || password == "      " || user_name == "" || password == "")
			alert("Nhập Tên và mật khẩu");
		else
			document.form1.submit();
	}
	function KeyCheck(e)
	{
	   var KeyID = (window.event) ? event.keyCode : e.keyCode;
	   if(KeyID ==13)
	   		submits();
	}	
</script>
	<form id="form1" name="form1" method="post" action="">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    	<td colspan="2" height="20"></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><?php echo _LOGIN_USER_NAME;?>:&nbsp;</td>
                        <td align="left" valign="top">
                            <input class="inputbox" size="15" onkeypress="KeyCheck(event)"   onfocus="javascript:if(this.value=='User name'){this.value='';};" onblur="javascript:if(this.value==''){this.value='User name';};" id="user_name" name="user_name" type="text" value="User name"><?php echo $user_error ?>
                        </td>
                    </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                        <td align="right" valign="middle" style="padding-left:15px;"><?php echo _LOGIN_PASSWORD;?>:&nbsp;</td>
                        <td align="left" valign="top">
                            <input class="inputbox" onkeypress="KeyCheck(event)"  name="password" id="password" type="password" onfocus="javascript:if(this.value=='      '){this.value='';};" onblur="javascript:if(this.value==''){this.value='      ';};" value="      "  size="15"/><?php echo $password_error?>
                        </td>
                    </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><input type="button" onclick="submits()" value="Login" /></td>
                    </tr>
        </table>
        <input type="hidden" name="form_name" value="doLogin" />
	</form>
<?php 
}
?>
</div>
