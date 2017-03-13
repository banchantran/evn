<?php
	function listCategory()
	{
		global $database;
		global $current_lang;
		$publish = getParam('publish', 'int', 0);
		$curPg = getParam('curPg', 'int', 1);
		$itemPerPage = 10;
		$numPageShow = 10;		
		$con ='';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		$totalRows = $database->getNumRows('category', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" '.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
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
					$category_arr[$one_cat['id']] = $one_cat;
					$category_arr[$one_cat['id']]['level'] = 1;
			}
		}
		
		$action = getParam("action", 'str');
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$list_id = $id;							
				$query = 'UPDATE `category` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id` IN ('.$list_id.')';
				$database->setQuery($query);
				$database->query();
				replace_location('category_admin');
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$list_id = $id;
				
				$query = 'UPDATE `category` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id` IN ('.$list_id.')';			
				$database->setQuery($query);
				$database->query();
				replace_location('category_admin');
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
					$query = 'UPDATE `category` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('category_admin');
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `category` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('category_admin');
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `category` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('category_admin');
			exit;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_category::listCategory($category_arr, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteCategory()
	{
		global $database;
		global $current_lang;
		$cat_id = getParam('value', 'str');
		$list_id = explode(',',$cat_id);
		if(count($list_id)>0)
		{
			$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" AND id IN('.$cat_id.') ORDER BY region, id DESC';
			$database->setQuery($query);
			$all = $database->loadResult();
			
			foreach($all as $one)
			{
				$id = $one['id'];
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$type = $one['type'];
					if($type==2)
					{
						$database->setQuery('delete from detail where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
					}
					else if($type==3)
					{
						$database->setQuery('delete from articles_detail where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
						$database->setQuery('delete from articles_category where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
					}
					else if($type==4)
					{
						$database->setQuery('delete from news_detail where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
						$database->setQuery('delete from news_category where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
					}
					else if($type==5)//lien he
					{
//						$database->setQuery('delete from news_detail where url="'.$one['url'].'" and lang="'.$current_lang.'"');
//						$database->query();
//						$database->setQuery('delete from news_category where url="'.$one['url'].'" and lang="'.$current_lang.'"');
//						$database->query();
					}
					else if($type==6)//san pham
					{
//						$database->setQuery('delete from news_detail where url="'.$one['url'].'" and lang="'.$current_lang.'"');
//						$database->query();
//						$database->setQuery('delete from news_category where url="'.$one['url'].'" and lang="'.$current_lang.'"');
//						$database->query();
					}
					else if($type==7)//san pham
					{
						$database->setQuery('delete from products_services where url="'.$one['url'].'" and lang="'.$current_lang.'"');
						$database->query();
					}
					$database->setQuery('delete from category where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('category_admin', array('curPg'));
	}
	function addCategory()
	{
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" ORDER BY region, id DESC';
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$url = urlSeo($title);
			$description = getParam("description", 'def');
			$content = getParam("content", 'def');
			$type = getParam('type', 'int', 0);
			$publish = getParam('publish', 'int', 0);
			$other_link = getParam("other_link", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$region = getParam('region', 'int', 0);
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO category (`title`,`url`, `type`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `publish`, `description`, `content`, `other_link`)
				 VALUES('$title', '$url', '$type', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$publish', '$description', '$content', '$other_link')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('category_admin');
				else
					replace_location('category_admin', array('task'=>'add'));
			}
		}
		HTML_category::updateCategory('', $all_arr, $error_array);
	}
	function editCategory()
	{
		global $database;
		global $current_lang;
//		$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" ORDER BY region ASC, id DESC';
//		$database->setQuery($query);
//		$all = $database->loadResult();
//		$all_arr[0] = _ROOT;
//		if($all)
//		{
//			foreach($all as $one_cat)
//					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
//		}
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM category WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._CATEGORY_NOT_EXISTS.'");
						window.location="'.generate_url('category_admin').'";
					</script>';
			return;
		}
		$old_url = $row['url'];
		$type = $row['type'];
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$url = urlSeo($title);
			$publish = getParam('publish', 'int', 0);
			$region = getParam('region', 'int', 0);
			$description = getParam("description", 'def');
			$content = getParam("content", 'def');
			$other_link = getParam("other_link", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE category SET `title`='$title', `url`='$url', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `publish`='$publish', `region`='$region', `description`='$description', `content`='$content', `other_link`='$other_link' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($old_url!=$url)
				{
					if($type==2)
					{
						$query = 'UPDATE `detail` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
					}
					else if($type==3)
					{
						$query = 'UPDATE `articles_category` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
						
						$query = 'UPDATE `articles_detail` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
					}
					else if($type==4)
					{
						$query = 'UPDATE `news_category` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
						
						$query = 'UPDATE `news_detail` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
					}
					else if($type==7)
					{
						$query = 'UPDATE `products_services` SET `url`="'.$url.'" WHERE lang="'.$current_lang.'" and `url`="'.$old_url.'"';
						$database->setQuery($query);
						$database->query();
					}
				}
				if($action == "save")
					replace_location('category_admin', array('curPg'));
				else
					replace_location('category_admin', array('task'=>'add'));
			}
		}
		HTML_category::updateCategory($row, $all_arr, $error_array);
	}
?>
