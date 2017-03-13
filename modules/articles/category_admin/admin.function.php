<?php
	function listArticles_cat()
	{
		global $database;
		global $current_lang;
		$publish = getParam('publish', 'int', 0);
		$curPg = getParam('curPg', 'int', 1);
		$url = getParam('url', 'str');
		$itemPerPage = 10;
		$numPageShow = 10;		
		$con ='';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		if($url)
			$con .= ' AND url="'.$url.'"';
		$totalRows = $database->getNumRows('articles_category', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" '.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		/*if($rows)
		{
			foreach($rows as $one_cat)   
			{
				$articles_category_arr[$one_cat['id']] = $one_cat;
				$articles_category_arr[$one_cat['id']]['level'] = 1;
			}
		}*/
		
		$action = getParam("action", 'str');
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$list_id = $id;							
				$query = 'UPDATE `articles_category` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id` IN ('.$list_id.')';
				$database->setQuery($query);
				$database->query();
				replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$list_id = $id;
				
				$query = 'UPDATE `articles_category` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id` IN ('.$list_id.')';			
				$database->setQuery($query);
				$database->query();
				replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
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
					$query = 'UPDATE `articles_category` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `articles_category` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `articles_category` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_articles_category::listArticles_cat($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteArticles_cat()
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
					$database->setQuery('delete from articles_category where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
	}
	function addArticles_cat()
	{
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" ORDER BY region ASC, id DESC';
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
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$title_url = urlSeo($title);
				$description = getParam("description", 'def');
				$content = getParam("content", 'def');
				$type = getParam('type', 'int', 0);
				$publish = getParam('publish', 'int', 0);
				$region = getParam('region', 'int', 0);
				$url =  getParam("url", 'str');
				
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO articles_category (`title`, `url`, `title_url`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `publish`, `description`, `content`)
				 VALUES('$title', '$url', '$title_url', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$publish', '$description', '$content')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('articles_category_admin', array('url'=>$_SESSION['cat']));
				else
					replace_location('articles_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_articles_category::updateArticles_cat('', $all_arr, $error_array);
	}
	function editArticles_cat()
	{
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" ORDER BY region ASC, id DESC';
		$database->setQuery($query);
		$all = $database->loadResult();
		$all_arr[0] = _ROOT;
		if($all)
		{
			foreach($all as $one_cat)
					$all_arr[$one_cat['id']] = '--'.$one_cat['title'];
		}
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM articles_category WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._CATEGORY_NOT_EXISTS.'");
						window.location="'.generate_url('articles_category_admin').'";
					</script>';
			return;
		}
		
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$title_url = urlSeo($title);
				$url =  getParam("url", 'str');
				$publish = getParam('publish', 'int', 0);
				$region = getParam('region', 'int', 0);
				$description = getParam("description", 'def');
				$content = getParam("content", 'def');

				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE articles_category SET `title`='$title', `url`='$url', `title_url`='$title_url', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `publish`='$publish', `region`='$region', `description`='$description', `content`='$content' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				$query = "UPDATE articles_category SET `title`='$title' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('articles_category_admin', array('url'=>$_SESSION['cat'], 'curPg'));
				else
					replace_location('articles_category_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_articles_category::updateArticles_cat($row, $all_arr, $error_array);
	}
?>