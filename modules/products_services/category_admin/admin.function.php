<?php
	//List product
	function listProduct()
	{
		global $database;
		global $current_lang;
		$con = 'AND url="'.$_SESSION['cat'].'"';
		$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" '.$con.' ORDER BY region';
		$database->setQuery($query);
		$rows = $database->loadResult();
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		if($rows)
		{
			foreach($rows as $one_cat)
			{
				if(!$one_cat['parent_id'])
				{
					$product_arr[$one_cat['id']] = $one_cat;
					$product_arr[$one_cat['id']]['level'] = 1;
					foreach($rows as $one_cat1)
					{
						if($one_cat1['parent_id']==$one_cat['id'])
						{
							$product_arr[$one_cat1['id']] = $one_cat1;
							$product_arr[$one_cat1['id']]['level'] = 2;
							/*foreach($rows as $one_cat2)
							{
								if($one_cat2['parent_id']==$one_cat1['id'])
								{
									$product_arr[$one_cat2['id']] = $one_cat2;
									$product_arr[$one_cat2['id']]['level'] = 3;
								}
							}*/
						}
					}
				}
			}
		}
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$query = 'UPDATE `products_services` SET `tieubieu`=2 WHERE  `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();
				replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `products_services` SET `tieubieu`=1 WHERE `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
				exit;
			}
		}
		
		$action = getParam("action", 'str');
		if($action == "publish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `products_services` SET `publish`=2 WHERE `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `products_services` SET `publish`=1 WHERE and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `products_services` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		HTML_product::listProduct($product_arr);
	}
	function deleteProduct()
	{
		global $database;
		global $current_lang;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{

					$database->setQuery('select * from products_services where parent_id = "'.$id.'" and lang="'.$current_lang.'"');
					$rows = $database->loadResult();
					if($rows)
					foreach($rows as $row)
					{
						delete_image($row, 'products_services');
						
						$database->setQuery('select * from products_services_detail where url="'.$row['url'].'" AND sub_url="'.$row['title_url'].'" and lang="'.$current_lang.'"');					$row_sub = $database->loadRow();
						delete_image($row_sub, 'products_services_detail');
						
						$database->setQuery('delete from products_services_detail where url="'.$row['url'].'" AND sub_url="'.$row['title_url'].'"  AND lang="'.$current_lang.'"');
						$database->query();
						if($database->getErrorNum()){
							echo $database->stderr();
							return;
						} 
					}
					
					$database->setQuery('select * from products_services where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					if($row)
					{
						delete_image($row, 'products_services');
						$database->setQuery('delete from products_services_detail where url="'.$row['url'].'" AND sub_url="'.$row['title_url'].'" AND lang="'.$current_lang.'"');
						$database->query();
						if($database->getErrorNum()){
							echo $database->stderr();
							return;
						} 
					}
					
					$database->setQuery('delete from products_services where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					} 
					$database->setQuery('delete from products_services where parent_id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					} 
				}
			}
		}
		replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
	}
	function deleteProductImage()
	{
		global $database;
		global $current_lang;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('select id, image_name from products_services where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'products_services');
					$database->setQuery('update products_services set `image_name`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
	}
	function deleteProductImageHome()
	{
		global $database;
		global $current_lang;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('select id, image_name_home from products_services where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image_home($row, 'products_services');
					$database->setQuery('update products_services set `image_name_home`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
	}
	function deleteProductImageBanner()
	{
		global $database;
		global $current_lang;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('select id, image_name_banner from products_services where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image_banner($row, 'products_services');
					$database->setQuery('update products_services set `image_name_banner`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
	}
	function addProduct()
	{
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND url="'.$_SESSION['cat'].'" ORDER BY region';
		$database->setQuery($query);
		$product = $database->loadResult();
		$product_arr[0] = _PARENT_CATEGORY;
		if($product)
		{
			foreach($product as $one_cat)
			{
				if(!$one_cat['parent_id'])
				{
					$product_arr[$one_cat['id']] = '--'.$one_cat['title'];
					/*foreach($product as $one_cat1)
					{
						if($one_cat1['parent_id']==$one_cat['id'])
						{
							$product_arr[$one_cat1['id']] = '-- --'.$one_cat1['title'];							
						}
					}*/
				}
			}
		}
		
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$parent_id = getParam("parent_id", 'int', 0);
			$title = getParam("title", 'str');
			$other_link = getParam("other_link", 'str');
			$content = getParam("content", 'def');
			$tieubieu = getParam('tieubieu', 'int', 0);
			$publish1 = getParam('publish1', 'int', 0);
			$title_url = urlSeo($title);
			$url = getParam('url', 'str');
			if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfile']['name']);
					upload_image_ps(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfile']['tmp_name'], $image_name, array('0'=>130, '1'=>100));
				}
			}
			
			if(isset($_FILES['imgfilehome']) and $_FILES['imgfilehome']['error']==0)
			{
				if(!check_type_file($_FILES['imgfilehome']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imgfilehome'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name_home = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfilehome']['name']);
					upload_image_ps_home(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfilehome']['tmp_name'], $image_name_home, array('0'=>223, '1'=>120));
				}
			}
			
			if(isset($_FILES['imgfilebanner']) and $_FILES['imgfilebanner']['error']==0)
			{
				if(!check_type_file($_FILES['imgfilebanner']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imgfilebanner'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name_banner = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfilebanner']['name']);
					upload_image_ps_banner(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfilebanner']['tmp_name'], $image_name_banner, array('0'=>728, '1'=>200));
				}
			}
			
			
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$region = getParam('region', 'int', 0);
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO products_services (`parent_id`, `title`, `other_link`, `content`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `tieubieu`, `title_url`, `url`, `image_name`, `image_name_home`, `image_name_banner`, `publish1`)
				 VALUES('$parent_id', '$title', '$other_link', '$content', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$tieubieu', '$title_url', '$url', '$image_name', '$image_name_home', '$image_name_banner', '$publish1')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
				else
					replace_location('products_services_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_product::updateProduct('', $product_arr, $error_array);
	}
	function editProduct()
	{
		global $database;
		global $current_lang;
		
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM products_services WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._PRODUCT_NOT_EXISTS.'");
						window.location="'.generate_url('products_services_admin').'";
					</script>';
			return;
		}
		
		$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND id<>'.$id.' AND url="'.$_SESSION['cat'].'" ORDER BY region';
		$database->setQuery($query);
		$product = $database->loadResult();
		$product_arr[0] = _PARENT_CATEGORY;
		if($product)
		{
			foreach($product as $one_cat)
			{
				if(!$one_cat['parent_id'])
				{
					$product_arr[$one_cat['id']] = '--'.$one_cat['title'];
					/*foreach($product as $one_cat1)
					{
						if($one_cat1['parent_id']==$one_cat['id'])
						{
							$product_arr[$one_cat1['id']] = '-- --'.$one_cat1['title'];							
						}
					}*/
				}
			}
		}
		
		
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$parent_id = getParam("parent_id", 'int', 0);
			$title = getParam("title", 'str');
			$other_link = getParam("other_link", 'str');
			$content = getParam("content", 'def');
			$region = getParam('region', 'int', 0);
			$tieubieu = getParam('tieubieu', 'int', 0);
			$publish1 = getParam('publish1', 'int', 0);
			$title_url = urlSeo($title);
			$url = getParam('url', 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			$image_name = $row['image_name'];
			if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$row['id'].get_file_type($_FILES['imgfile']['name']);
					upload_image_ps(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						delete_image($row, 'products_services');
				}
			}
			$image_name_home = $row['image_name_home'];
			if(isset($_FILES['imgfilehome']) and $_FILES['imgfilehome']['error']==0)
			{
				if(!check_type_file($_FILES['imgfilehome']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imgfilehome'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name_home = date('m').'_'.date('Y').'_'.$row['id'].get_file_type($_FILES['imgfilehome']['name']);
					upload_image_ps_home(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfilehome']['tmp_name'], $image_name_home);
				}
			}
			$image_name_banner = $row['image_name_banner'];
			if(isset($_FILES['imgfilebanner']) and $_FILES['imgfilebanner']['error']==0)
			{
				if(!check_type_file($_FILES['imgfilebanner']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imgfilebanner'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name_banner = date('m').'_'.date('Y').'_'.$row['id'].get_file_type($_FILES['imgfilebanner']['name']);
					upload_image_ps_banner(DATA_PATH_ADMIN.'images/products_services/', $_FILES['imgfilebanner']['tmp_name'], $image_name_banner);
				}
			}
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE products_services SET  `title`='$title', `other_link`='$other_link', `content` = '$content',  `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `region`='$region', `tieubieu`='$tieubieu', `parent_id`='$parent_id', `title_url`='$title_url', `url`='$url', `image_name`='$image_name', `image_name_home`='$image_name_home', `image_name_banner`='$image_name_banner', `publish1`='$publish1' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('products_services_admin', array('url'=>$_SESSION['cat']));
				else
					replace_location('products_services_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_product::updateProduct($row, $product_arr, $error_array);
	}
?>