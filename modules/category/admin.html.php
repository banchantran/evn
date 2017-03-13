<?php
class HTML_category
{
	function listCategory($rows, $pagging, $start_count)
	{
	?>
		<script >
			function deleteCategory()
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
					document.location.href= "<?php echo generate_url('category_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function editCategory()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('category_admin', array('task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListCategory;
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
				dml=document.FormListCategory;
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
				dml = document.FormListCategory;
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
				document.FormListCategory.action.value=pressbutton;
				try
				{
					document.FormListCategory.onsubmit();
				}
				catch(e)
				{}
				document.FormListCategory.submit();
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
		<form name="FormListCategory" method="post">
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _CATEGORY_ADMIN;?></h2></td>
					<td align="right">
						<a class="toolbar" href="<?php echo generate_url('category_admin', array('task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editCategory()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteCategory()">
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
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
							</td>
							<td><?php echo $i; ?></td>
							<td>
								<?php echo $tab;?><a href="<?php echo generate_url('category_admin', array('task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a>
							</td>
                            <td>
                                <a href="<?php if($row['publish']==2) $status='unpublish'; else $status='publish'; echo generate_url('category_admin', array('status'=>$status, 'id'=>$row['id'])) ?>"><?php  $status_all = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo $status_all[$row['publish']];?></a>
							</td>							
							<td>
								<?php echo '<b>'.$row['user_create'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_create']); ?>
							</td>
							<td>
								<?php echo '<b>'.$row['user_update'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_update']); ?>
							</td>
							<td>
								<?php echo $region_tab;?><input name="region_<?php echo $row['id']; ?>" class="inputbox" size="6" value="<?php echo getParam('region_'.$row['id'], 'str', $row['region']);?>" maxlength="30" type="text">
							</td>
                             <td>								
                            <?php echo $tab;?><?php
							if($row['type']==1)							
								echo _OTHER_LINK;
							else
							{
								if($row['type']==2)							
									$other_link = generate_url('detail_admin', array('url'=>urlSeo( $row['title'])));
								if($row['type']==3)			
									$other_link = generate_url('articles_category_admin', array('url'=>urlSeo($row['title'])));
								if($row['type']==4)			
									$other_link = generate_url('news_category_admin', array('url'=>urlSeo($row['title'])));
								if($row['type']==5)			
									$other_link = generate_url('contact_admin', array('url'=>urlSeo($row['title'])));
								if($row['type']==7)			
									$other_link = generate_url('products_services_admin', array('url'=>urlSeo($row['title'])));
									echo '<a href="'.$other_link.'">'.$row['title'].'</a>';
							}
							?>
							                   
							</td>
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
	function updateCategory($row='', $all_arr, $error_array)
	{
	?>
		<form name="FormAddCategory" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddCategory.action.value=pressbutton;
				try
				{
					document.FormAddCategory.onsubmit();
				}
				catch(e)
				{}
				document.FormAddCategory.submit();
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
						<a class="toolbar" href="<?php echo generate_url('category_admin'); ?>">
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
<?php if(getParam('task', 'str', '')!='edit'){ ?>                        
						<tr>
							<td>
								<?php echo _TYPE; ?>
							</td>
							<td colspan="2">
								<!--<select name="type"><?php $type_array = array('1'=>_LABEL,'2'=>_DETAIL, '3'=>_CATEGORY, '4'=>_NEWS, '5'=>_CONTACT_US, '6'=>_PRODUCT, '7'=>_PRODUCTS_SERVICES); echo get_option($type_array, getParam('type', 'int', $row['type'])); ?></select>-->
                                <select name="type"><?php $type_array = array('2'=>_DETAIL, '3'=>_CATEGORY, '4'=>_NEWS, '5'=>_CONTACT_US, '7'=>_PRODUCTS_SERVICES); echo get_option($type_array, getParam('type', 'int', $row['type'])); ?></select>
							</td>
						</tr>						
                        <tr>
<?php }?>						
						<tr>
							<td width="130px">
								<?php echo _REGION; ?>
							</td>
							<td>
								<input name="region" class="inputbox" style="width:50px;" value="<?php echo getParam('region', 'str', $row['region']);?>" type="text">
							</td>
						</tr>
                        <tr>
                        <tr>
                            <td align="left" valign="top">
                                <?php echo _OTHER_LINK; ?>
                            </td>
                            <td>
                               <input name="other_link" class="inputbox" style="width:500px;" value="<?php echo getParam('other_link', 'str', $row['other_link']);?>" type="text">
                            </td>
                        </tr>
                        <tr>
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