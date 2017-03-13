<?php
	function listBanner_cennter()
	{
		global $database;
		global $current_lang;
		$curPg = getParam('curPg', 'int', 1);
		$publish = getParam('publish', 'int', 0);
		$mid = getParam('mid', 'int', 0);
		$cid = getParam('cid', 'int', 0);
		$itemPerPage = 10;
		$numPageShow = 10;
		$con ='';
		if($publish)
			$con .= ' AND publish="'.$publish.'"';
		if($mid)
			$con .= ' AND mid="'.$mid.'"';
		if($cid)
			$con .= ' AND cid="'.$cid.'"';
		$totalRows = $database->getNumRows('banner_cennter', ' lang="'.$current_lang.'"'.$con);
		$query = 'SELECT * FROM `banner_cennter` WHERE lang="'.$current_lang.'"'.$con.' ORDER BY region, id DESC limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
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
				$query = 'UPDATE `banner_cennter` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `banner_cennter` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
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
					$query = 'UPDATE `banner_cennter` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `banner_cennter` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `banner_cennter` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_banner_cennter::listBanner_cennter($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteBanner_cennter()
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
					$database->setQuery('select id, image_name from banner_cennter where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'banner_cennter');
					$database->setQuery('delete from banner_cennter where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'curPg'));
	}
	function deleteBanner_cennterImage()
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
					$database->setQuery('select id, image_name from banner_cennter where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'banner_cennter');
					$database->setQuery('update banner_cennter set `image_name`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'curPg'));
	}
	function addBanner_cennter()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			$is_valid = 1;	
			$image_name = '';
			$database->setQuery('SELECT max(id) as max_id from banner_cennter');
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
					upload_photo(DATA_PATH_ADMIN.'photo/banner_cennter/', $_FILES['imgfile']['tmp_name'], $image_name);
				}
			}
			
/*			if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfile']['name']);
					upload_image(DATA_PATH_ADMIN.'images/banner_cennter/', $_FILES['imgfile']['tmp_name'], $image_name);
				}
			} */
			if($is_valid)
			{
				$cid = $_SESSION['cid'];
				$category_name = $_SESSION['category_name'];
				$mid = getParam('mid', 'int', 0);
				$cid = getParam('cid', 'int', 0);
				$region = getParam('region', 'int', 0);
				$publish = getParam('publish', 'int', 0);
				$source = getParam("source", 'str');
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO banner_cennter (`id`, `mid`, `cid`, `title`, `brief`, `content`, `image_name`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `region`, `source`, `publish`, `category_name`)
				 VALUES('$max_id', '$mid', '$cid', '$title', '$brief', '$content', '$image_name', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$region', '$source', '$publish', '$category_name')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0)));
				else
					replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'task'=>'add'));
			}
		}
		HTML_banner_cennter::updateBanner_cennter('', $error_array);
	}
	function editBanner_cennter()
	{
		global $database;
		global $current_lang;
				
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM banner_cennter WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._ARTICLES_NOT_EXISTS.'");
						window.location="'.generate_url('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$mid = getParam('mid', 'int', 0);
			$cid = getParam('cid', 'int', 0);
			$title = getParam("title", 'str');
			$brief = getParam("brief", 'def');
			$content = getParam("content", 'def');
			$region = getParam('region', 'int', 0);
			$publish = getParam('publish', 'int', 0);
			$source = getParam("source", 'str');
			$is_valid = 1;
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
					upload_photo(DATA_PATH_ADMIN.'photo/banner_cennter/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						drop_photo($row, 'photo');
				}
			}
			
	/*		if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$is_valid = 0;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$row['id'].get_file_type($_FILES['imgfile']['name']);
					upload_image(DATA_PATH_ADMIN.'images/banner_cennter/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						delete_image($row, 'banner_cennter');
				}
			}
	*/
			if($is_valid)
			{
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				$query = "UPDATE banner_cennter SET `mid`='$mid', `cid`='$cid', `title`='$title', `brief`='$brief', `content` = '$content', `image_name`='$image_name', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `region`='$region', `source`='$source', `publish`='$publish' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'curPg'));
				else
					replace_location('banner_cennter_admin', array('mid'=>getParam('mid', 'int', 0) , 'cid'=>getParam('cid', 'int', 0), 'task'=>'add'));
			}
		}
		HTML_banner_cennter::updateBanner_cennter($row, $error_array);
	}
?>