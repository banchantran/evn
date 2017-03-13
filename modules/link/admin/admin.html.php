<?php
class HTML_link
{
	function listLink($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteLink()
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
					document.location.href= "<?php echo generate_url('link_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function editLink()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('link_admin', array('task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListLink;
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
				dml=document.FormListLink;
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
				dml = document.FormListLink;
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
				document.FormListLink.action.value=pressbutton;
				try
				{
					document.FormListLink.onsubmit();
				}
				catch(e)
				{}
				document.FormListLink.submit();
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
		<form name="FormListLink" method="post">
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _LINK_ADMIN;?></h2></td>
					<td align="right">
						<a class="toolbar" href="<?php echo generate_url('link_admin', array('task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editLink()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteLink()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('block_admin'); ?>">
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
							<th class="title" width="4%"><input type="checkbox" name="all_check" onClick="setChecked()" /></th>
							<th class="title" width="4%"><?php echo _ORD;?></th>
							<th class="title" width="12%"><?php echo _TITLE;?></th>
							<th class="title" width="20%"><?php echo _PATH;?></th>
                            <th class="title" width="11%"><?php echo _PUBLISH;?>
                              <select name="publish" onchange="this.form.submit()">
                                <?php echo get_option(array('0'=>_ALL, '1'=>_UN_PUBLISH, '2'=>_PUBLISH), getParam('publish', 'int', 0)); ?>
                              </select> </th>
							<th class="title" width="15%">
								<?php echo _REGION; ?>&nbsp;<a href="javascript:submitbutton('save_order')"><img src="<?php echo SITE_PATH;?>themes/admin/images/filesave.png" alt="<?php echo _SAVE; ?>" title="<?php echo _SAVE; ?>" border="0" height="16" width="16"></a>
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
								<a href="<?php echo generate_url('link_admin', array('task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['fullname']; ?></a>
							</td>
							<td><?php echo string_strip($row['link']);?></td>
                            <td>
                                <a href="<?php if($row['publish']==2) $status='unpublish'; else $status='publish'; echo generate_url('link_admin', array('status'=>$status, 'id'=>$row['id'])) ?>"><?php  $status_all = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo $status_all[$row['publish']];?></a>
							</td>
							<td><input name="region_<?php echo $row['id']; ?>" class="inputbox" size="6" value="<?php echo getParam('region_'.$row['id'], 'str', $row['region']);?>" maxlength="50" type="text"></td>
						</tr>
						<?php
					}
				}				
			?>
					</tbody>
				</table>
			</div>
		</div>
        <input type="hidden" name="action" value="" />
		</form>
	<?php
	if($pagging)
					echo '<th colspan="20" align="left">
								'.$pagging.'
							</th>';
	}
	function updateLink($row='', $error_array)
	{
	?>
		<form name="FormAddLink" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddLink.action.value=pressbutton;
				try
				{
					document.FormAddLink.onsubmit();
				}
				catch(e)
				{}
				document.FormAddLink.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _LINK_ADMIN;?>: <small><?php echo _UPDATE;?></small></h2></td>
					<td align="right">
						<a class="toolbar" href="javascript:submitbutton('save');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="javascript:submitbutton('apply');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/apply.png" alt="<?php echo _APPLY;?>" name="<?php echo _APPLY;?>" title="<?php echo _APPLY;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('link_admin'); ?>">
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
							<th colspan="2">
								<?php echo _UPDATE_LINK;?>
							</th>
						</tr>
						<tr>
							<td>
								<?php echo _PUBLISH; ?>
							</td>
							<td colspan="2">
								<select name="publish"><?php $publish_array = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo get_option($publish_array, getParam('publish', 'int', $row['publish'])); ?></select>
							</td>
						</tr>
                        <tr <?php if($error_array['fullname']) echo "class='error_user_class'";?>>
							<td width="130px">
								<?php echo _TITLE;?>
							</td>
							<td>
								<input name="fullname" class="inputbox" style="width:500px;" value="<?php echo getParam('fullname', 'str', $row['fullname']);?>" maxlength="255" type="text">
							</td>
						</tr>
						<tr <?php if($error_array['link']) echo "class='error_user_class'";?>>
							<td width="130px">
								<?php echo _PATH;?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="link" class="inputbox" style="width:500px;" value="<?php echo getParam('link', 'str', $row['link']);?>" maxlength="255" type="text">
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _REGION; ?>
							</td>
							<td>
								<input name="region" class="inputbox" style="width:50px;" value="<?php echo getParam('region', 'str', $row['region']);?>" type="text">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><span class="require_field">(*)</span> <?php echo _REQUIRED_FIELD; ?></td>
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