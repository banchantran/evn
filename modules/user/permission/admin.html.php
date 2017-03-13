<?php
class HTML_permission_category
{
	function listPermission($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deletePermission()
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
					document.location.href= "<?php echo generate_url('permission_admin', array('uid'=>getParam('uid', 'int', 0), 'task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function editPermission()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('permission_admin', array('uid'=>getParam('uid', 'int', 0),'task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListPermission;
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
				dml=document.FormListPermission;
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
				dml = document.FormListPermission;
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
			function submitbutton(pressbutton)
			{
				document.FormListPermission.action.value=pressbutton;
				try
				{
					document.FormListPermission.onsubmit();
				}
				catch(e)
				{}
				document.FormListPermission.submit();
			}
			function publish(pressbutton)
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				submitbutton(pressbutton);
			}
		</SCRIPT>
		<form name="FormListPermission" method="post">
		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PERMISSION_ADMIN; ?><br /><small><?php echo user_d(getParam('uid', 'int', 0)); ?></small></h2></td>
					<td align="right">
						<a class="toolbar" href="#" onclick="return editPermission()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deletePermission()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('user_admin'); ?>">
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
							<th class="title" width="5%"><input type="checkbox" name="all_check" onClick="setChecked()" /></th>
							<th class="title" width="5%"><?php echo _ORD;?></th>
							<th class="title" width="80%"><?php echo _MODULE;?></th>
							<th class="title" width="10%"><?php echo _DELETE;?></th>
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
								<a href="<?php echo generate_url('permission_admin', array('uid'=>getParam('uid', 'int', 0),'task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a>
							</td>     
							<td>
								<a href="<?php echo generate_url('permission_admin', array('uid'=>getParam('uid', 'int', 0),'task'=>'delete', 'id'=>$row['id'])); ?>"><?php echo _DELETE; ?></a>
							</td>                                              
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
				<?php
				
				?>
			</div>
		</div>
		<input type="hidden" name="action" value="" />
		</form>
	<?php
	}
	function updatePermission($row='', $all_arr, $error_array)
	{
	?>
		<form name="FormAddPermission" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddPermission.action.value=pressbutton;
				try
				{
					document.FormAddPermission.onsubmit();
				}
				catch(e)
				{}
				document.FormAddPermission.submit();
			}
		</script>		
			<center>
				<table class="nostyle" width="30%">
					<tbody>
						<tr>
							<th colspan="3"><center><span style="font-size:16px; color:#0000CC">
								<?php echo _NEW;?></span></center>
								
							</th>
						</tr>
						<tr>
							<td width="20%">
								<?php echo _MODULE; ?>
							</td>
							<td width="60%">
									<select name="module_id"><?php module_option(); ?></select>
							</td>
							<td width="20%">
									<a class="toolbar" href="javascript:submitbutton('save');"><?php echo _SAVE;?></a>
							</td>
						</tr>       
					</tbody>
				</table>
			</center>
		<input type="hidden" name="action" value="" />
		</form>
	<?php
	}
}

?>