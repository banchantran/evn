<?php
class HTML_banner_mid
{
	function listBannerMid($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteBannerMid()
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
					document.location.href= "<?php echo generate_url('banner_mid_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function deleteBannerMidImage()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				res=confirm("<?php echo _SURE_DELETE_IMAGE;?>");
				if (res) 
				{
					document.location.href= "<?php echo generate_url('banner_mid_admin', array('task'=>'delete_image', 'curPg')); ?>&value="+value;
				}
			}
			function submitbutton(pressbutton)
			{
				document.FormListBannerMid.action.value=pressbutton;
				try
				{
					document.FormlistBannerMid.onsubmit();
				}
				catch(e)
				{}
				document.FormListBannerMid.submit();
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
	
			function editBannerMid()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('banner_mid_admin', array('task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListBannerMid;
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
				dml=document.FormListBannerMid;
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
				dml = document.FormListBannerMid;
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
		<form name="FormListBannerMid" method="post">
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _BANNER_MID_ADMIN; ?></h2></td>
					<td align="right">						
						<a class="toolbar" href="<?php echo generate_url('banner_mid_admin', array('task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editBannerMid()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteBannerMid()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('profile'); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/cancel.png" alt="<?php echo _CANCEL;?>" name="<?php echo _CANCEL;?>" title="<?php echo _CANCEL;?>" align="middle" border="0">
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<div class="centermain" align="center">
			<div class="main">
				<table class="adminlist">
					<tbody>
						<tr>
							<th class="title" width="5%"><input type="checkbox" name="all_check" onClick="setChecked()" /></th>
							<th class="title" width="5%"><?php echo _ORD; ?></th>
							<th class="title" width="45%"><?php echo _TITLE; ?></th>
							<th class="title" width="15%"><?php echo _IMAGE; ?></th>
                            <th class="title" width="11%"><?php echo _PUBLISH;?>
                              <select name="publish" onchange="this.form.submit()">
                                <?php echo get_option(array('0'=>_ALL, '1'=>_UN_PUBLISH, '2'=>_PUBLISH), getParam('publish', 'int', 0)); ?>
                              </select> </th>													
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
						if($row['publish'] == 2)
							$publish = _PUBLISH;
						else
							$publish = _UN_PUBLISH;
						$i++;
						?>
						<tr class="<?php echo $class_row; ?>" valign="top">
							<td>
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
							</td>
							<td><?php echo $i; ?></td>
							<td>
								<a href="<?php echo generate_url('banner_mid_admin', array('task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a>								
							</td>
							<td>
								<?php
									$image_file = get_image_banner_mid($row, 'small', 'xml');
									if($image_file)
									{
										if(check_type_file($image_file, array('swf')))
										{
											echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="669" height="108"><param name="movie" value="'.$image_file.'" /><embed src="'.$image_file.'"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="669" height="108"></embed></object>';
										echo '<br /><a href="'.$image_file.'">Download</a>';
										}
										else
											echo '<img width="300" src="'.$image_file.'" />';
									}
									else
										echo _NO_IMAGE;
								?>
							</td>
                            <td>
								<?php echo $publish; ?>
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
			</div>
		</div>
        <input type="hidden" name="action" value="" />
		</form>
	<?php
	}
	function updateBannerMid($row='', $error_array)
	{
	?>
		<form name="FormAddBannerMid" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddBannerMid.action.value=pressbutton;
				try
				{
					document.FormAddBannerMid.onsubmit();
				}
				catch(e)
				{}
				document.FormAddBannerMid.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _BANNER_MID_ADMIN.': <small>'._UPDATE.'</small>'; ?></h2></td>
					<td align="right">
						
										<a class="toolbar" href="javascript:submitbutton('save');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
										</a>
										<a class="toolbar" href="javascript:submitbutton('apply');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/apply.png" alt="<?php echo _APPLY;?>" name="<?php echo _APPLY;?>" title="<?php echo _APPLY;?>" align="middle" border="0">
										</a>
										<a class="toolbar" href="<?php echo generate_url('banner_mid_admin'); ?>">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/cancel.png" alt="<?php echo _CANCEL;?>" name="<?php echo _CANCEL;?>" title="<?php echo _CANCEL;?>" align="middle" border="0">
										</a>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<div class="centermain" align="center">
			<div class="main">
				<table class="adminform">
					<tbody>
						<tr>
							<th colspan="2">
								<?php echo '<span class="news">'._BANNER_UPDATE.'</span>'; ?></th>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _TITLE; ?><span class="require_field">(*)</span></td>
							<td>
								<input name="title" class="inputbox" style="width:500px;" value="<?php echo getParam('title', 'str', $row['title']);?>" maxlength="255" type="text">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $error_array['title']; ?>						</td>
						</tr>
                        <tr>
							<td width="130px">
								<?php echo _LINK; ?><span class="require_field">(*)</span></td>
							<td>
								<input name="link" class="inputbox" style="width:500px;" value="<?php echo getParam('link', 'str', $row['link']);?>" maxlength="255" type="text">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $error_array['link']; ?>						</td>
						</tr>
                         <tr>
							<td>
								<?php echo _PUBLISH; ?>
							</td>
							<td colspan="2">
								<select name="publish"><?php $publish_array = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo get_option($publish_array, getParam('publish', 'int', $row['publish'])); ?></select>
							</td>
						</tr>
						<tr <?php if($error_array['imagefile']) echo "class='error_user_class'";?>>
							<td><?php echo _IMAGE; ?></td>
							<td>
								<input name="imgfile" class="inputbox" type="file" size="40" />
								&nbsp;<?php echo $error_array['imagefile']; ?>							</td>
						</tr>                        
						<tr>
							<td colspan="3">&nbsp;</td>
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