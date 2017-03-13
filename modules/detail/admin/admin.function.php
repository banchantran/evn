<?php
	function listdetail()
	{
		global $database;
		global $current_lang;
		$curPg = getParam('curPg', 'int', 1);

		$publish = getParam('publish', 'int', 0);
		$url = getParam('url', 'str');
		$itemPerPage = 10;
		$numPageShow = 10;
		$con = 'AND url="'.$_SESSION['cat'].'"';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		if($url)
			$con .= ' AND url="'.$url.'"';
		
		$totalRows = $database->getNumRows('detail', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'"'.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
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
				$query = 'UPDATE `detail` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('detail_admin', array('url'=>$_SESSION['cat']));
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `detail` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('detail_admin', array('url'=>$_SESSION['cat']));
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
					$query = 'UPDATE `detail` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('detail_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `detail` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('detail_admin', array('url'=>$_SESSION['cat']));
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `detail` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('detail_admin', array('url'=>$_SESSION['cat']));
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_detail::listdetail($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deletedetail()
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
					$database->setQuery('delete from detail where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('detail_admin', array('url'=>$_SESSION['cat']));
	}
	function adddetail()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$content = getParam("content", 'def');
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			
			$image_name = '';
			$database->setQuery('SELECT max(id) as max_id from detail');
			$row = $database->loadRow();
			$max_id = $row['max_id']+1;
			if($is_valid)
			{
				$url = getParam('url', 'str');
				$title_url = urlSeo($title);
				$region = getParam('region', 'int', 0);
				$publish = getParam('publish', 'int', 0);
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO detail (`id`, `url`, `title_url`, `title`, `content`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `publish`)
				 VALUES('$max_id', '$url', '$title_url', '$title', '$content', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$publish')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('detail_admin', array('url'=>$_SESSION['cat']));
				else
					replace_location('detail_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_detail::updatedetail('', $error_array);
	}
	function editdetail()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM detail WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._ARTICLES_NOT_EXISTS.'");
						window.location="'.generate_url('detail_admin', array('url'=>getParam('url', 'str') , 'sub_url'=>getParam('sub_url', 'str'), 'articles_url'=>getParam('articles_url', 'str'), 'curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$url = getParam('url', 'str');
			$title = getParam("title", 'str');
			$title_url =  urlSeo($title);
			$content = getParam("content", 'def');
			$region = getParam('region', 'int', 0);
			$publish = getParam('publish', 'int', 0);
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
				$query = "UPDATE detail SET `url`='$url', `title_url`='$title_url', `title`='$title', `content` = '$content', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `region`='$region', `publish`='$publish' WHERE `id`='".$id."'";				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('detail_admin', array('url'=>$_SESSION['cat']));
				else
					replace_location('detail_admin', array('url'=>$_SESSION['cat'], 'task'=>'add'));
			}
		}
		HTML_detail::updatedetail($row, $error_array);
	}
?>