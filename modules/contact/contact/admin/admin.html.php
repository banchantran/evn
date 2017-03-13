<?php
class HTML_contact
{
	function listContact($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteContact()
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
					document.location.href= "<?php echo generate_url('contact_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function editContact()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('contact_admin', array('task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListContact;
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
				dml=document.FormListContact;
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
				dml = document.FormListContact;
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
		<form name="FormListContact" method="post">
		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _CONTACT_ADMIN;?></h2></td><td>
					<a class="toolbar" href="<?php echo generate_url('contact_info_admin'); ?>">
					<img src="<?php echo SITE_PATH;?>themes/admin/images/info.png" alt="<?php echo _CONTACT_INFO_ADMIN;?>" name="<?php echo _CONTACT_INFO_ADMIN;?>" title="<?php echo _CONTACT_INFO_ADMIN;?>" align="middle" border="0"><?php echo _CONTACT_INFO_ADMIN;?>
					</a>&nbsp;&nbsp;
					<a class="toolbar" href="<?php echo generate_url('email_admin'); ?>">
					<img src="<?php echo SITE_PATH;?>themes/admin/images/e-mail.png" alt="<?php echo _EMAIL_ADMIN;?>" name="<?php echo _EMAIL_ADMIN;?>" title="<?php echo _EMAIL_ADMIN;?>" align="middle" border="0"><?php echo _EMAIL_ADMIN;?>
					</a>
					</td>
					<td align="right">
						<a class="toolbar" href="#" onclick="return editContact()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteContact()">
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
				<table class="adminlist" width="100%">
					<tbody>
						<tr>
							<th class="title" width="5%"><input type="checkbox" name="all_check" onClick="setChecked()" /></th>
							<th class="title" width="5%"><?php echo _ORD;?></th>
							<th class="title" width="10%"><?php echo _FULL_NAME;?></th>
							<th class="title" width="10%"><?php echo _ADDRESS;?></th>
							<th class="title" width="10%"><?php echo _EMAIL;?> / <font color="RED"><?php echo _PHONE;?></font></th>
							<th class="title" width="10%"><?php echo _SEND_TIME;?></th>
							<th class="title" width="40%"><?php echo _CONTENT;?></th>
							<th class="title" width="10%">
								<?php echo _STATUS;?>: <select name="status" onchange="this.form.submit()">
									<?php
										$status_arr = array('3'=>_ALL, '1'=>_UN_READ, '2'=>_READ);
										echo get_option($status_arr, getParam('status', 'int', 1));
									?>
									</select>
							</th>
						</tr>
			<?php
				if($rows)
				{
					$i = $start_count;
					foreach($rows as $row)
					{
						if($i%2 == 0)
							$class_row = 'row0';
						else
							$class_row = 'row1';
						$i++;
						?>
						<tr class="<?php echo $class_row; ?>" valign="top">
							<td>
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
							</td>
							<td><?php echo $i; ?></td>
							<td>
								<a href="<?php echo generate_url('contact_admin', array('task'=>'edit', 'curPg', 'id'=>$row['id']));?>"><?php echo $row['fullname']?></a>
							</td>
							<td><?php echo string_strip($row['address']);?></td>
							<td>
								<a href="mailto:<?php echo $row['email']?>"><?php echo $row['email'];?></a><br />
								<?php 
									echo '<font color="RED">'.$row['phone'].'</font>';
								?>
							</td>
							<td>
								<?php echo '<b>'.date('d/m/Y h:s', $row['time_create']).'</b>';?>
							</td>
							<td>
								<?php echo string_strip($row['content']); ?>
							</td>
							<td><?php echo $status_arr[$row['status']]?></td>
						</tr>
						<?php
					}
				}
				if($pagging)
					echo '
						<tr>
							<th colspan="20" align="left">
								'.$pagging.'
							</th>
						</tr>';
			?>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	<?php
	}
	function updateContact($row)
	{
	?>
		<form name="FormUpdateContact" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormUpdateContact.action.value=pressbutton;
				try
				{
					document.FormUpdateContact.onsubmit();
				}
				catch(e)
				{}
				document.FormUpdateContact.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _CONTACT_ADMIN;?>: <small><?php echo _UPDATE_CONTACT;?></small></h2></td>
					<td align="right">
						<input type="image" src="<?php echo SITE_PATH;?>themes/admin/images/save.png" name="btn_save" />
						<a class="toolbar" href="<?php echo generate_url('contact_admin'); ?>">
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
							<th colspan="2" width="130">
								<?php echo _UPDATE_CONTACT;?>
							</th>
						</tr>
						<tr>
							<td>
								<?php echo _STATUS;?>
							</td>
							<td colspan="2">	
								<select name="status">
								<?php
									$status_arr = array('1'=>_UN_READ, '2'=>_READ);
									echo get_option($status_arr, getParam('status', 'int', $row['status']));
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _COMMENT;?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('admin_comment', getParam('admin_comment', 'def', string_strip($row['admin_comment'])), 800, 200);
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="action" value="save" />
		</form>
	<?php
	}
}
?>