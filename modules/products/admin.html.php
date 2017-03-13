<?php
class HTML_product
{
	function listProduct($rows, $pagging, $start_count)
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
					document.location.href= "<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'), 'task'=>'delete', 'curPg')); ?>&value="+value;
				}
			}
			function deleteProductImage()
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
					document.location.href= "<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'), 'task'=>'delete_image', 'curPg')); ?>&value="+value;
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
				document.location.href= "<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'), 'task'=>'edit', 'curPg')); ?>&id="+value;
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
		<form name="FormListProduct" method="post">
		<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td align="left"><h2><?php echo _PRODUCT_ADMIN;?></h2></td>
					<td align="right">
						<a class="toolbar" href="<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'), 'task'=>'add', 'curPg')); ?>">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/new.png" alt="<?php echo _NEW;?>" name="<?php echo _NEW;?>" title="<?php echo _NEW;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return editProduct()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/edit.png" alt="<?php echo _EDIT;?>" name="<?php echo _EDIT;?>" title="<?php echo _EDIT;?>" align="middle" border="0">
						</a>
						<a class="toolbar" href="#" onclick="return deleteProduct()">
							<img src="<?php echo SITE_PATH;?>themes/admin/images/delete.png" alt="<?php echo _DELETE;?>" name="<?php echo _DELETE;?>" title="<?php echo _DELETE;?>" align="middle" border="0">
						</a>
						</a>
						<a class="toolbar" href="<?php 
						if(getParam('mid', 'int', 0))
						echo generate_url('category_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str')));
						else
						echo generate_url('profile');
						 ?>">
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
							<th class="title" width="30%"><?php echo _TITLE.' / '._BRIEF;?></th>
							<th class="title" width="14%"><?php echo _IMAGE;?></th>
							<th class="title" width="9%"><?php echo _LANGUAGE;?></th>
                            <th align="center" width="9%"><?php echo _PRICE;?></th>
							<th class="title" width="9%"><?php echo _UPDATE;?></th>
                            <th class="title" width="11%"><?php echo _PUBLISH;?>
                              <select name="publish" onchange="this.form.submit()">
                                <?php echo get_option(array('0'=>_ALL, '1'=>_UN_PUBLISH, '2'=>_PUBLISH, '3'=>_PRIVATE), getParam('publish', 'int', 0)); ?>
                              </select> </th>
							<th class="title" width="10%"><?php echo _REGION; ?>&nbsp;<a href="javascript:submitbutton('save_order')"><img src="<?php echo SITE_PATH;?>themes/admin/images/filesave.png" alt="<?php echo _SAVE; ?>" title="<?php echo _SAVE;?>" border="0" height="16" width="16"></a></th>
						</tr>
			<?php
				if($rows)
				{
					$i = 0;
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
								<a href="<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'task'=>'edit', 'id'=>$row['id'])); ?>"><?php echo $row['title']; ?></a>
							</td>
							<td align="center">
								<?php
									$image_file = get_image($row, 'small', 'product');
									if($image_file)
										echo '<img width="75px" height="75px" src="'.$image_file.'" />';
									else
										echo '<img width="75px;" src="'.SITE_PATH.'template/product/images/no_image.jpg'.'" />';
								?>
							</td>
							<td>
								<?php echo $row['lang']; ?>
							</td>
							<td align="center">
								<?php echo '<b>'.$row['price'].'</b><br />'; if($row['vat']==2) echo _VAT; if($row['vat']==1) echo _UN_VAT;?>
							</td>
							<td align="center">
								<?php echo '<b>'.$row['user_update'].'</b><br />'; echo date('d/m/Y, H:i:s', $row['time_update']); ?>
							</td>
                            <td align="center">
                                <a href="<?php if($row['publish']==2) $status='unpublish'; else $status='publish'; echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'), 'status'=>$status, 'id'=>$row['id'])) ?>"><?php  $status_all = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH, '3'=>_PRIVATE); echo $status_all[$row['publish']];?></a>
							</td>
							<td align="center">
								<input name="region_<?php echo $row['id']; ?>" class="inputbox" size="6" value="<?php echo getParam('region_'.$row['id'], 'str', $row['region']);?>" maxlength="50" type="text">
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
					echo '<th colspan="20" align="center">
								'.$pagging.'
							</th>';
	}
	function updateProduct($row='', $error_array)
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
										<a class="toolbar" href="<?php echo generate_url('product_admin', array('url'=>getParam('url', 'str'),  'sub_url'=>getParam('sub_url', 'str'))); ?>">
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
								<select name="publish"><?php $publish_array = array('1'=>_UN_PUBLISH, '2'=>_PUBLISH); echo get_option($publish_array, getParam('publish', 'int', $row['publish'])); ?></select>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _PRODUCT_NAME; ?> <span class="require_field">(*)</span>
							</td>
							<td>
								<input name="title" class="inputbox" style="width:500px;" value="<?php echo getParam('title', 'str', $row['title']);?>" maxlength="255" type="text">&nbsp;<?php echo $error_array['title']; ?>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _MODEL; ?>
							</td>
							<td>
								<input name="model" class="inputbox" style="width:500px;" value="<?php echo getParam('model', 'str', $row['model']);?>" maxlength="255" type="text">&nbsp;<?php echo $error_array['model']; ?>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _PRICE; ?>
							</td>
							<td>
								<input name="price" class="inputbox" style="width:500px;" value="<?php echo getParam('price', 'str', $row['price']);?>" maxlength="255" type="text">&nbsp;<?php echo $error_array['price']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _BRIEF; ?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('brief', getParam('brief', 'def', string_strip($row['brief'])), 800, 175);
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo _IMAGE; ?></td>
							<td>
								<input name="imgfile" class="inputbox" type="file" size="40" />
								 <?php echo $error_array['imagefile']; ?>&nbsp;<?php echo $error_array['imagefile']; ?>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo _CONTENT; ?>
							</td>
							<td>
								<?php 
									printEditor(); 
									getEditor('content', getParam('content', 'def', string_strip($row['content'])), 700, 300);
								?>
							</td>
						</tr>
						<tr>
							<td width="130px">
								<?php echo _REGION;?>
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