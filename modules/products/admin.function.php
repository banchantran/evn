<?php
	function listProduct()
	{
		global $database;
		global $current_lang;
		$curPg = getParam('curPg', 'int', 1);
		$publish = getParam('publish', 'int', 0);
		$url = getParam('url', 'str');
		$sub_url = getParam('sub_url', 'str');
		$itemPerPage = 10;
		$numPageShow = 10;
		$con ='';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		if($url)
			$con .= ' AND url="'.$url.'"';		
		if($sub_url)
			$con .= ' AND sub_url="'.$sub_url.'"';	
		$totalRows = $database->getNumRows('product', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `product` WHERE lang="'.$current_lang.'"'.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$query = 'UPDATE `product` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `product` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
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
					$query = 'UPDATE `product` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `product` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `product` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_product::listProduct($rows, $pagging, ($curPg-1)*$itemPerPage);
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
					$database->setQuery('select id, image_name from product where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'product');
					$database->setQuery('delete from product where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'curPg'));
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
					$database->setQuery('select id, image_name from product where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'product');
					$database->setQuery('update product set `image_name`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'curPg'));
	}
	function addProduct()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$model = getParam("model", 'str');
			$code = getParam("code", 'str');
			$price = getParam("price", 'str');
			$vat = getParam("vat", 'int', 0);
			$promotion = getParam("promotion", 'def');
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			
			$image_name = '';
			$database->setQuery('SELECT max(id) as max_id from product');
			$row = $database->loadRow();
			$max_id = $row['max_id']+1;
			
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
					upload_image(DATA_PATH_ADMIN.'images/product/', $_FILES['imgfile']['tmp_name'], $image_name);
				}
			}
			if($is_valid)
			{
				$cid = $_SESSION['cid'];
				$product_url =  urlSeo($title);
				$url = getParam('url', 'str');
				$sub_url = getParam('sub_url', 'str');
				$region = getParam('region', 'int', 0);
				$publish = getParam('publish', 'int', 0);
				$category_id = getParam('category_id', 'int', 0);
				$source = getParam("source", 'str');
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO product (`id`, `url`, `sub_url`, `title`, `model`, `price`, `brief`,  `content`, `image_name`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `source`, `publish`, `product_url`)
				 VALUES('$max_id', '$url', '$sub_url', '$title', '$model', '$price',  '$brief', '$content', '$image_name', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$source', '$publish', '$product_url')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str')));
				else
					replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'task'=>'add'));
			}
		}
		HTML_product::updateProduct('', $error_array);
	}
	function editProduct()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM product WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._PRODUCT_NOT_EXISTS.'");
						window.location="'.generate_url('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$url = getParam('url', 'str');
			$product_url =  urlSeo($title);
			$sub_url = getParam('sub_url', 'str');			
			$model = getParam("model", 'str');
			$price = getParam("price", 'str');
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			$region = getParam('region', 'int', 0);
			$category_id = getParam('category_id', 'int', 0);
			$publish = getParam('publish', 'int', 0);
			$source = getParam("source", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
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
					$image_name = date('m').'_'.date('Y').'_'.$id.get_file_type($_FILES['imgfile']['name']);
					upload_image(DATA_PATH_ADMIN.'images/product/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						delete_image($row, 'product');
				}
			}
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE product SET `url`='$url', `sub_url`='$sub_url', `product_url`='$product_url', `title`='$title', `model`='$model', `price`='$price', `brief`='$brief', `content` = '$content', `image_name`='$image_name', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `region`='$region', `source`='$source', `publish`='$publish' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'curPg'));
				else
					replace_location('product_admin', array('url'=>getParam('url', 'str'), 'sub_url'=>getParam('sub_url', 'str'), 'task'=>'add'));
			}
		}
		HTML_product::updateProduct($row, $error_array);
	}
?>