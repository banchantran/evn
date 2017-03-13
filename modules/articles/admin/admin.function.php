<?php
	function listArticles_detail()
	{
		global $database;
		global $current_lang;

		$curPg = getParam('curPg', 'int', 1);
		$publish = getParam('publish', 'int', 0);
		$url = getParam('url', 'str');
		$sub_url = getParam('sub_url', 'str');
	
		$itemPerPage = 10;
		$numPageShow = 10;
		$con = 'AND url="'.$_SESSION['cat'].'"';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		if($url)
			$con .= ' AND url="'.$url.'"';
		if($sub_url)
			$con .= ' AND sub_url = "'.$sub_url.'"';

		$totalRows = $database->getNumRows('articles_detail', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `articles_detail` WHERE lang="'.$current_lang.'"'.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
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
				$query = 'UPDATE `articles_detail` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();
				replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `articles_detail` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();
				replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
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
					$query = 'UPDATE `articles_detail` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `articles_detail` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `articles_detail` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_articles_detail::listArticles_detail($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteArticles_detail()
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
					$database->setQuery('select id, image_name from articles_detail where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'articles_detail');
					$database->setQuery('delete from articles_detail where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']), 'curPg');
	}
	function addArticles_detail()
	{
		global $database;
		global $current_lang;
				
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
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			
			$url = $_SESSION['cat'];
			$sub_url = $_SESSION['sub_cat'];
			$title_url = urlSeo($title);
			$image_name = '';
			$database->setQuery('SELECT max(id) as max_id from articles_detail');
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
					upload_image_news(DATA_PATH_ADMIN.'images/articles_detail/', $_FILES['imgfile']['tmp_name'], $image_name);
				}
			}
			if($is_valid)
			{
				$detail_url =  urlSeo($title);
				$articles_url = getParam('articles_url', 'str');
				$url = getParam('url', 'str');
				$sub_url = getParam('sub_url', 'str');
				$region = getParam('region', 'int', 0);
				$publish = getParam('publish', 'int', 0);
				$source = getParam("source", 'str');
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO articles_detail (`id`, `url`, `sub_url`, `title_url`, `title`, `brief`, `content`, `image_name`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `publish`)
				 VALUES('$max_id', '$url', '$sub_url', '$title_url', '$title', '$brief', '$content', '$image_name', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$publish')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat']));
				else
					replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat'], 'task'=>'add'));
			}
		}
		HTML_articles_detail::updateArticles_detail('', $error_array);
	}
	function editArticles_detail()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM articles_detail WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._ARTICLES_NOT_EXISTS.'");
						window.location="'.generate_url('articles_detail_admin', array('url'=>getParam('url', 'str') , 'sub_url'=>getParam('sub_url', 'str'), 'articles_url'=>getParam('articles_url', 'str'), 'curPg')).'";
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
			$url = getParam('url', 'str');
			$sub_url = getParam('sub_url', 'str');
			$title_url =  urlSeo($title);
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			$region = getParam('region', 'int', 0);
			$publish = getParam('publish', 'int', 0);
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
					upload_image_news(DATA_PATH_ADMIN.'images/articles_detail/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						delete_image($row, 'articles_detail');
				}
			}
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE articles_detail SET `url`='$url', `sub_url`='$sub_url', `title_url`='$title_url', `title`='$title', `brief`='$brief', `content` = '$content', `image_name`='$image_name', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `region`='$region', `publish`='$publish' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat'], 'curPg'));
				else
					replace_location('articles_admin', array('url'=>$_SESSION['cat'], 'sub_url'=>$_SESSION['sub_cat'], 'task'=>'add'));
			}
		}
		HTML_articles_detail::updateArticles_detail($row, $error_array);
	}
?>