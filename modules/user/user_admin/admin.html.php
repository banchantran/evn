<?php
class HTML_user
{
	function listUsers($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteUser()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				res=confirm("<?php echo _SURE_DELETE;?>");
				if (res) 
				{
					document.location.href= "<?php echo generate_url('user_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function editUser()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('user_admin', array('task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListUser;
				len = dml.elements.length;
				var i=0;
				for( i=0 ; i<len ; i++) 
				{
					if (dml.elements[i].type=='checkbox' && dml.elements[i].checked) 
					{
					   nCount++;
					}
				}    
				return nCount;
			}
			
			function valueChecked() 
			{
				var value = "";
				var check = 0;
				dml=document.FormListUser;
				len = dml.elements.length;
				var i=0;
				for( i=0 ; i<len ; i++) 
				{
					if (dml.elements[i].type=='checkbox' && dml.elements[i].checked) 
					{
						if(!isNaN(dml.elements[i].value))
						{
						   if(check== 0){
							 value= dml.elements[i].value;
							 check= 1;
						   }else{
							 value+= ","+dml.elements[i].value;
						   }
						}
					}
				}
				return value;
			}
			function setChecked() 
			{
				dml = document.FormListUser;
				val = dml.all_check.checked;
				len = dml.elements.length;
				var i=0;
				for( i=0 ; i<len ; i++) 
				{
					if (dml.elements[i].type=='checkbox') 
					{
					   dml.elements[i].checked=val;
					}
				}    
			}
		</SCRIPT>
		<form name="FormListUser" method="post">
		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _USER_ADMIN; ?></h2></td>
					<td align="right">						
						<a class="toolbar" href="<?php echo generate_url('user_admin', array('task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editUser()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteUser()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
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
				<table class="adminlist">
					<tbody>
						<tr>
							<th class="title" width="4%"><input type="checkbox" name="all_check" onClick="setChecked()" /></th>
							<th class="title" width="4%"><?php echo _ORD; ?></th>
							<th class="title" width="10%"><?php echo _USER_NAME; ?></th>
							<th class="title" width="14%"><?php echo _FULL_NAME; ?></th>
							<th class="title" width="10%"><?php echo _BIRTH_DATE; ?></th>
							<th class="title" width="8%"><?php echo _GENDER; ?></th>
							<th class="title" width="10%"><?php echo _EMAIL; ?></th>
							<th class="title" width="12%"><?php echo _PHONE; ?></th>
							<th class="title" width="12%"><?php echo _ADDRESS; ?></th>
							<th class="title" width="8%"><?php echo _GROUP; ?></th>
							<!--<th class="title" width="8%"><?php echo _PERMISSION; ?></th>-->
							<th class="title" width="8%"><?php echo _LOCK; ?></th>
						</tr>
			<?php
				if($rows)
				{
					global $permission;
					$i = $start_count;
					foreach($rows as $row)
					{
						if($i%2 == 0)
							$class_row = 'row0';
						else
							$class_row = 'row1';
						$i++;
						if($row['lock']==1)
						{
							$lock_title = _LOCK;
							$lock_url = generate_url('user_admin', array('task'=>'unLock', 'id'=>$row['id'], 'curPg'));
						}
						else
						{
							$lock_title = _UNLOCK;
							$lock_url = generate_url('user_admin', array('task'=>'lock', 'id'=>$row['id'], 'curPg'));
						}
						if($row['gender']==1)
							$gender = _FEMALE;
						else
							$gender = _MALE;
						?>
						<tr class="<?php echo $class_row; ?>">
							<td>
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
							</td>
							<td><?php echo $i; ?></td>
							<td>
								<a href="<?php echo generate_url('user_admin', array('task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['user_name']; ?></a>
							</td>
							<td>
								<?php echo $row['full_name']; ?>
							</td>
							<td>
								<?php echo date('d/m/Y', $row['birth_date']); ?>
							</td>
							<td>
								<?php echo $gender; ?>
							</td>
							<td>
								<a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
							</td>
							<td>
								<?php echo $row['phone']; ?>
							</td>
							<td>
								<?php echo $row['address']; ?>
							</td>
							<td>
								<?php echo $permission[$row['usergroup']]; ?>
							</td>
							<!--<td>
								<?php if($row['id'] != 1){
								?>
								<a href="<?php echo generate_url('permission_admin', array('uid'=>$row['id'])); ?>"> <?php echo _PERMISSION; ?></a>
								<?php 
								}
								else echo $row['full_name'];
								?>
							</td>-->
							<td>
								<a href="<?php echo $lock_url; ?>" title="<?php echo $lock_title; ?>">
									<?php echo $lock_title; ?>
								</a>
							</td>
						</tr>
						<?php
					}
					if($pagging)
					echo '
						<tr>
							<th colspan="20">
								'.$pagging.'
							</th>
						</tr>';
				}
			?>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	<?php
	}
	function updateUsers($row='', $error_array)
	{
	?>
		<form name="FormAddUser" method="post">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddUser.action.value=pressbutton;
				try
				{
					document.FormAddUser.onsubmit();
				}
				catch(e)
				{}
				document.FormAddUser.submit();
			}
		</script>

		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _USER_ADMIN; ?>: <small><?php echo _USER_ADMIN_ADD; ?></small></h2></td>
					<td align="right">
										<a class="toolbar" href="javascript:submitbutton('save');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">										
										</a>
										<a class="toolbar" href="javascript:submitbutton('apply');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/apply.png" alt="<?php echo _APPLY;?>" name="<?php echo _APPLY;?>" title="<?php echo _APPLY;?>" align="middle" border="0">								
											</a>
										<a class="toolbar" href="<?php echo generate_url('user_admin'); ?>"><img src="<?php echo SITE_PATH;?>themes/admin/images/cancel.png" alt="<?php echo _CANCEL;?>" name="<?php echo _CANCEL;?>" title="<?php echo _CANCEL;?>" align="middle" border="0" />
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
								<?php echo _USER_ADMIN_ADD; ?>
							</th>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _FULL_NAME; ?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="full_name" class="inputbox" size="145" value="<?php echo getParam('full_name', 'str', $row['full_name']);?>" maxlength="50" type="text"><?php echo $error_array['full_name']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _USER_NAME; ?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="user_name" class="inputbox" size="145" value="<?php echo getParam('user_name', 'str', $row['user_name']);?>" maxlength="25" type="text"><?php echo $error_array['user_name']; echo $error_array['user_exist']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _NEW_PASSWORD; ?> <span class="require_field">(*)</span>
							</td>
							<td>
							<input class="inputbox" name="password" size="145" value="" type="password"><?php echo $error_array['password']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _VERIFY_PASSWORD; ?> <span class="require_field">(*)</span>
							</td>
							<td>
							<input class="inputbox" name="verify_password" size="145" value="" type="password"><?php echo $error_array['verify_password']; echo $error_array['password_not_match']; ?>
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
								<select name="lock">
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
								<select name="permission">
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
}
?>