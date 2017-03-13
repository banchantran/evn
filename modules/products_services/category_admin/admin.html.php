<?php
class HTML_product
{
	function listProduct($rows)
	{
	?>
		<script >
			function deleteProduct()
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
					document.location.href= "<?php echo generate_url('products_services_admin', array('task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function delete_Product_Image()
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
					document.location.href= "<?php echo generate_url('products_services_admin',array('url'=>getParam('url', 'str'), 'task'=>'delete_image', 'curPg')); ?>&value="+value;
				}
			}
			function delete_Product_Image_Home()
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
					document.location.href= "<?php echo generate_url('products_services_admin',array('url'=>getParam('url', 'str'), 'task'=>'delete_image_home', 'curPg')); ?>&value="+value;
				}
			}
			function delete_Product_Image_Banner()
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
					document.location.href= "<?php echo generate_url('products_services_admin',array('url'=>getParam('url', 'str'), 'task'=>'delete_image_banner', 'curPg')); ?>&value="+value;
				}
			}
			function editProduct()
			{	
				var nCount = countChecked();
				var value= valueChecked();
				value = parseInt(value);
				if (nCount==0)
				{
					alert("<?php echo _NOT_CHECK;?>" );
					return;
				}
				document.location.href= "<?php echo generate_url('products_services_admin', array('url'=>getParam('url', 'str'), 'task'=>'edit', 'curPg')); ?>&id="+value;
			}
			function countChecked() 
			{
				var nCount = 0;
				dml=document.FormListProduct;
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
				dml=document.FormListProduct;
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
				dml = document.FormListProduct;
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
				document.FormListProduct.action.value=pressbutton;
				try
				{
					document.FormListProduct.onsubmit();
				}
				catch(e)
				{}
				document.FormListProduct.submit();
			}
		</SCRIPT>
		<form name="FormListProduct" method="post">
		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PRODUCT_ADMIN;?></h2></td>
					<td align="right">
						<a class="toolbar" href="<?php echo generate_url('products_services_admin', array('url'=>getParam('url', 'str'), 'task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editProduct()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteProduct()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
                        <a class="toolbar" href="#" onclick="return delete_Product_Image()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete_img.png" alt="<?php echo _DELETE_IMAGE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE_IMAGE;?>" align="middle" border="0">
						</a>
                        <a class="toolbar" href="#" onclick="return delete_Product_Image_Home()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete_img.png" alt="<?php echo _DELETE_IMAGE;?>" name="<?php echo _DELETE;?>" title="Xóa ảnh trang chủ" align="middle" border="0">
						</a>
                        <a class="toolbar" href="#" onclick="return delete_Product_Image_Banner()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete_img.png" alt="<?php echo _DELETE_IMAGE;?>" name="<?php echo _DELETE;?>" title="Xóa ảnh banner" align="middle" border="0">
						</a>
						<a class="toolbar" href="<?php 
						if(getParam('mid', 'int', 0))
						echo generate_url('category_admin', array('url'=>getParam('url', 'str')));
						else
						echo generate_url('category_admin');
						 ?>">
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
							<th class="title" width="3%"><?php echo _ORD;?></th>
							<th class="title" width="20%"><?php echo _TITLE;?></th>
							<th class="title" width="5%"><?php echo _OTHER_LINK;?></th>
                            <th class="title" width="14%"><?php echo _IMAGE;?></th>
							<th class="title" width="14%">Ảnh trên trang chủ</th>
                            <th class="title" width="14%">Ảnh banner</th>
							<!--<th class="title" width="10%"><?php echo _CREATE;?></th>
							<th class="title" width="10%"><?php echo _UPDATE;?></th>-->
                            <th class="title" width="5%">Sản phẩm tiêu biểu
                              <select name="publish" onchange="this.form.submit()">
                                <?php echo get_option(array('0'=>_ALL, '1'=>_UN_PUBLISH, '2'=>_PUBLISH), getParam('publish', 'int', 0)); ?>
                              </select> </th>
							<th class="title" width="10%"><?php echo _REGION; ?>&nbsp;<a href="javascript:submitbutton('save_order')"><img src="<?php echo SITE_PATH;?>themes/images/filesave.png" alt="<?php echo _SAVE; ?>" title="<?php echo _SAVE; ?>" border="0" height="16" width="16"></a></th>
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
						if($row['level']==1)
							$tab = '';
						else if ($row['level']==2)
							$tab = '|--&nbsp;&nbsp;';
						else 
							$tab = '|-- --&nbsp;&nbsp;';
			?>
						<tr class="<?php echo $class_row; ?>" valign="top">
							<td>
								<input type="checkbox" name="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
							</td>
							<td><?php echo $i; ?></td>
							<td>
                            	<?php echo $tab;?><a href="<?php echo generate_url('products_services_admin', array('url'=>$_SESSION['cat'], 'task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a>							</td>
					  <td>
								<?php echo $row['other_link']; ?>
							</td>
                            <td>
								<?php
									$image_file = get_image($row, 'small', 'products_services');
									if($image_file)
										echo '<img width="100" src="'.$image_file.'" />';
									else
										echo _NO_IMAGE;
								?>
							</td>
							<td>
								<?php
									$image_file = get_image_home($row, 'home', 'products_services');
									if($image_file)
										echo '<img width="100" src="'.$image_file.'" />';
									else
										echo _NO_IMAGE;
								?>
							</td>
                            <td>
								<?php
									$image_file = get_image_banner($row, 'banner', 'products_services');
									if($image_file)
										echo '<img width="130" src="'.$image_file.'" />';
									else
										echo _NO_IMAGE;
								?>
							</td>
							<!--<td>
								<?php echo '<b>'.$row['user_create'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_create']); ?>
							</td>
							<td>
								<?php echo '<b>'.$row['user_update'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_update']); ?>
							</td>-->
                            <td>
                                <a href="<?php if($row['tieubieu']==2) $status='unpublish'; else $status='publish'; echo generate_url('products_services_admin', array('url'=>$_SESSION['cat'], 'status'=>$status, 'id'=>$row['id'])) ?>"><?php  $status_all = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo $status_all[$row['tieubieu']];?></a>
							</td>
							<td>
                            	<?php echo $tab; ?><input name="region_<?php echo $row['id']; ?>" class="inputbox" size="6" value="<?php echo getParam('region_'.$row['id'], 'str', $row['region']);?>" maxlength="50" type="text">
							</td>
                            <td>								
                            <?php echo $tab;?><?php											
								$other_link = generate_url('products_services_detail_admin', array('url'=>$row['url'], 'sub_url'=>$row['title_url']));							
								echo '<a href="'.$other_link.'">'.$row['title'].'</a>';
							?>
							                   
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
	function updateProduct($row='', $product_arr, $error_array)
	{
	?>
		<form name="FormAddProduct" method="post" enctype="multipart/form-data">
		<script>
			function submitbutton(pressbutton)
			{
				document.FormAddProduct.action.value=pressbutton;
				try
				{
					document.FormAddProduct.onsubmit();
				}
				catch(e)
				{}
				document.FormAddProduct.submit();
			}
		</script>
		<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PRODUCT_ADMIN;?>: <small><?php echo _UPDATE;?></small></h2></td>
					<td align="right">
										<a class="toolbar" href="javascript:submitbutton('save');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
										</a>
										<a class="toolbar" href="javascript:submitbutton('apply');">
											<img src="<?php echo SITE_PATH;?>themes/admin/images/apply.png" alt="<?php echo _APPLY;?>" name="<?php echo _APPLY;?>" title="<?php echo _APPLY;?>" align="middle" border="0">
										</a>
										<a class="toolbar" href="<?php echo generate_url('products_services_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'))); ?>">
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
								<?php echo _UPDATE_PRODUCT;?>
							</th>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _TITLE; ?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="title" class="inputbox" style="width:500px;" value="<?php echo getParam('title', 'str', $row['title']);?>" type="text">&nbsp;&nbsp;<?php echo $error_array['title']; ?>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _OTHER_LINK; ?>
							</td>
							<td>
								<input name="other_link" class="inputbox" style="width:500px;" value="<?php echo getParam('other_link', 'str', $row['other_link']);?>" type="text">
							</td>
						</tr>
                        <tr>
							<td><?php echo _PARENT_CATEGORY;?></td>
							<td colspan="2">
								<select name="parent_id">
									<?php
										echo get_option($product_arr, getParam('parent_id', 'int', $row['parent_id'])); 
									?>
								</select>
							</td>
						</tr>
                        <tr>
							<td>Sản phẩm tiêu biểu</td>
							<td colspan="2">
								<select name="tieubieu"><?php $tieubieu = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo get_option($tieubieu, getParam('tieubieu', 'int', $row['tieubieu'])); ?></select>
							</td>
						</tr>
                        <tr>
							<td>Hiển thị mức 1</td>
							<td colspan="2">
								<select name="publish1"><?php $tieubieu = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo get_option($tieubieu, getParam('publish1', 'int', $row['publish1'])); ?></select>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _CONTENT; ?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('content', getParam('content', 'def', string_strip($row['content'])), 800, 400);
								?>
							</td>
						</tr>
                        <tr>
							<td><?php echo _IMAGE; ?></td>
							<td>
								<input name="imgfile" class="inputbox" type="file" size="40" /> 130x100 px
								 <?php echo $error_array['imagefile']; ?>&nbsp;<?php echo $error_array['imagefile']; ?>
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
							<td>Ảnh hiển trị trên trang chủ</td>
							<td>
								<input name="imgfilehome" class="inputbox" type="file" size="40" /> 223x120 px
							</td>
						</tr>
                        <tr>
							<td>Banner cho trang</td>
							<td>
								<input name="imgfilebanner" class="inputbox" type="file" size="40" /> 728x200 px
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><span class="require_field">(*)</span> <?php echo _REQUIRED_FILED; ?></td>
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