<?php
class HTML_news_category
{
	function listNews_Category($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteNews_Category()
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
					document.location.href= "<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'delete')); ?>&value="+value;
				}
			}
			function editNews_Category()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'edit')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListNews_Category;
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
				dml=document.FormListNews_Category;
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
				dml = document.FormListNews_Category;
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
				document.FormListNews_Category.action.value=pressbutton;
				try
				{
					document.FormListNews_Category.onsubmit();
				}
				catch(e)
				{}
				document.FormListNews_Category.submit();
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
		<form name="FormListNews_Category" method="post">
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _NEWS_CATEGORY_ADMIN;?></h2></td>
					<td align="right">
						<a class="toolbar" href="<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editNews_Category()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteNews_Category()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('category_admin'); ?>">
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
							<th class="title" width="15%"><?php echo _TITLE;?></th>
                            <th class="title" width="11%"><?php echo _PUBLISH;?>
                              <select name="publish" onchange="this.form.submit()">
                                <?php echo get_option(array('0'=>_ALL, '1'=>_UN_PUBLISH, '2'=>_PUBLISH), getParam('publish', 'int', 0)); ?>
                              </select> </th>
							<th class="title" width="10%"><?php echo _CREATE;?></th>
							<th class="title" width="10%"><?php echo _UPDATE;?></th>
							<th class="title" width="10%"><?php echo _REGION; ?>&nbsp;<a href="javascript:submitbutton('save_order')"><img src="<?php echo SITE_PATH;?>themes/admin/images/filesave.png" alt="<?php echo _SAVE; ?>" title="<?php echo _SAVE; ?>" border="0" height="16" width="16"></a></th>
                            <th class="title" width="10%"><?php echo _ADMIN;?></th>
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
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />							</td>
							<td><?php echo $i; ?></td>
							<td>
							<?php echo $tab;?><a href="<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a><a href="<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'edit', 'id'=>$row['id'])); ?>"></a></td>
              <td>
                                <a href="<?php if($row['publish']==2) $status='unpublish'; else $status='publish'; echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'], 'status'=>$status, 'id'=>$row['id'])) ?>"><?php  $status_all = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo $status_all[$row['publish']];?></a>							</td>							
							<td>
								<?php echo '<b>'.$row['user_create'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_create']); ?>							</td>
							<td>
								<?php echo '<b>'.$row['user_update'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_update']); ?>							</td>
							<td>
								<?php echo $region_tab;?><input name="region_<?php echo $row['id']; ?>" class="inputbox" size="6" value="<?php echo getParam('region_'.$row['id'], 'str', $row['region']);?>" maxlength="30" type="text">							</td>
                             <td>								
                            <?php echo $tab;?><?php											
								$other_link = generate_url('news_admin', array('url'=>$row['url'], 'sub_url'=>$row['title_url']));							
								echo '<a href="'.$other_link.'">'.$row['title'].'</a>';
							?>							</td>
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
					echo '
							<th colspan="20" align="center">
								'.$pagging.'
							</th>';
						
	}
	function updateNews_Category($row='', $all_arr, $error_array)
	{
	?>
		<form name="FormAddNews_Category" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddNews_Category.action.value=pressbutton;
				try
				{
					document.FormAddNews_Category.onsubmit();
				}
				catch(e)
				{}
				document.FormAddNews_Category.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _CATEGORY_ADMIN;?>: <small><?php echo _UPDATE_CATEGORY;?></small></h2></td>
					<td align="right">
						<a class="toolbar" href="javascript:submitbutton('save');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="javascript:submitbutton('apply');">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/apply.png" alt="<?php echo _APPLY;?>" name="<?php echo _APPLY;?>" title="<?php echo _APPLY;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php echo generate_url('news_category_admin', array('url'=>$_SESSION['cat'])); ?>">
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
								<?php echo _UPDATE;?>
							</th>
						</tr>		
                        <tr>
							<td>
								<?php echo _PUBLISH; ?>
							</td>
							<td colspan="2">
								<select name="publish"><?php $publish_array = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH, '3'=>_PRIVATE); echo get_option($publish_array, getParam('publish', 'int', $row['publish'])); ?></select>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _TITLE; ?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="title" class="inputbox" style="width:500px;" value="<?php echo getParam('title', 'str', $row['title']);?>" type="text">&nbsp;&nbsp;<?php echo $error_array['title']; ?>
							</td>
						</tr>						
						<!--<tr>
							<td align="left" valign="top">
								<?php echo _DESCRIPTION; ?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('description', getParam('description', 'def', string_strip($row['description'])), 800, 175);
								?>
							</td>
						</tr>
                        <tr>
							<td align="left" valign="top">
								<?php echo _CONTENT; ?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('content', getParam('content', 'def', string_strip($row['content'])), 800, 175);
								?>
							</td>
						</tr>-->
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