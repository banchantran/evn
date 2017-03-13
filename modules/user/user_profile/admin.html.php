<?php
class HTML_profile
{
	function editProfile($row, $error_array)
	{
	?>
		<form name="FormEditProfile" method="post">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormEditProfile.action.value=pressbutton;
				try
				{
					document.FormEditProfile.onsubmit();
				}
				catch(e)
				{}
				document.FormEditProfile.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PROFILE; ?></h2></td>
					<td align="right">
						<a class="toolbar" href="javascript:submitbutton('save');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
						</a>						
					</td>
				</tr>
			</tbody>
		</table>
		<div class="centermain" align="center">
			<div class="main">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<th colspan="3">
								<?php echo _PROFILE; ?>
							</th>
						</tr>
						<tr>
							<td width="130">
								<?php echo _FULL_NAME; ?> <span class="require_field">(*)</span>
							</td>
							<td width="270">
								<input name="full_name" class="inputbox" size="145" value="<?php echo getParam('full_name', 'str', $row['full_name']);?>" maxlength="50" type="text"><?php echo $error_array['full_name']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _USER_NAME; ?>
							</td>
							<td colspan="2">
								<strong><?php echo $row['user_name'];?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _BIRTH_DATE; ?>
							</td>
							<td colspan="2">
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
							<td>
								<?php echo _GENDER; ?>
							</td>
							<td colspan="2">
								<select name="gender"><?php $gender_array = array('0'=>_MALE, '1'=>_FEMALE); echo get_option($gender_array, getParam('gender', 'int', $row['gender'])); ?></select>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _PASSWORD; ?>
							</td>
							<td colspan="2">
								<a class="toolbar" href="<?php echo generate_url('profile', array('task'=>'change_pass')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/change_pass.png" alt="<?php echo _CHANGE_PASS;?>" name="<?php echo _CHANGE_PASS;?>" title="<?php echo _CHANGE_PASS;?>" align="middle" border="0"><?php echo _CHANGE_PASS;?>
								</a>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _EMAIL; ?>
							</td>
							<td colspan="2">
								<input class="inputbox" name="email" size="145" value="<?php echo getParam('email', 'str', $row['email']);?>" type="text">
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _PHONE; ?>
							</td>
							<td colspan="2">
								<input class="inputbox" name="phone" size="145" value="<?php echo getParam('phone', 'str', $row['phone']);?>" type="text">
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _ADDRESS; ?>
							</td>
							<td colspan="2">
								<input class="inputbox" name="address" size="145" value="<?php echo getParam('address', 'str', $row['address']);?>" type="text">
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _LOCK; ?>
							</td>
							<td colspan="2">	
								<select name="lock" disabled="disabled">
									<?php
										$lock_arr = array(0=>_UNLOCK, 1=>_LOCK);
										echo get_option($lock_arr, getParam('lock', 'int', $row['lock'])); 
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _PERMISSION; ?>
							</td>
							<td colspan="2">	
								<select name="permission" disabled="disabled">
									<?php global $permission; echo get_option($permission, getParam('permission', 'int', $row['usergroup'])); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><span class="require_field">(*)</span> <?php echo _REQUIRED_FILED; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="action" value="" />
		</form>
	<?php
	}
	function changePass($row, $error_array)
	{
	?>
		<form name="FormChangePass" method="post">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormChangePass.action.value=pressbutton;
				try
				{
					document.FormChangePass.onsubmit();
				}
				catch(e)
				{}
				document.FormChangePass.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PROFILE; ?>: <small><?php echo _CHANGE_PASS; ?></small></h2></td>
					<td align="right">
						<a class="toolbar" href="javascript:submitbutton('save');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('profile'); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/cancel.png" alt="<?php echo _CANCEL;?>" name="<?php echo _CANCEL;?>" title="<?php echo _CANCEL;?>" align="middle" border="0">
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="centermain" align="center">
			<div class="main">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<th colspan="3">
								<?php echo _CHANGE_PASS; ?>
							</th>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _OLD_PASS; ?> <span class="require_field">(*)</span>
							</td>
							<td width="270px">
								<input name="old_pass" class="inputbox" size="45" value="" maxlength="50" type="password"><?php echo $error_array['old_pass'];  echo $error_array['old_pass_valid'];?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _NEW_PASSWORD; ?> <span class="require_field">(*)</span>
							</td>
							<td>
							<input class="inputbox" name="password" size="45" value="" type="password"><?php echo $error_array['password']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _VERIFY_PASSWORD; ?> <span class="require_field">(*)</span>
							</td>
							<td>
							<input class="inputbox" name="verify_password" size="45" value="" type="password"><?php echo $error_array['verify_password']; echo $error_array['password_not_match']; ?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><span class="require_field">(*)</span> <?php echo _REQUIRED_FILED; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="action" value="" />
		</form>
	<?php
	}
}
?>