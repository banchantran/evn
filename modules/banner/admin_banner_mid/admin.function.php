<?php
	//List BannerMid
	function listBannerMid()
	{
		global $database;
		global $current_lang;
		$condition = '';
		$con2 = '';
		if(getParam('publish', 'int', 0))
			$con2 = ' and publish="'.getParam('publish', 'int', 1).'" ';
		$totalRows = 0;
		$itemPerPage = 10;
		$numPageShow = 10;
		$curPg = getParam('curPg', 'int', 1);
		$totalRows = $database->getNumRows('banner_mid', ' lang="'.$current_lang.'"'.$condition.$con2);		
		$query = 'SELECT * FROM `banner_mid` WHERE lang="'.$current_lang.'" '.$condition.$con2.' ORDER BY id desc limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$action = getParam("action", 'str');
		if($action == "publish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `banner_mid` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('banner_mid_admin');
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `banner_mid` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('banner_mid_admin');
			exit;
		}		
		$query = 'SELECT * FROM `banner_mid` WHERE lang="'.$current_lang.'" AND publish=2 ORDER BY id desc';
		$database->setQuery($query);
		$rows_xml = $database->loadResult();
		if($rows_xml)				
			write_xml($rows_xml);
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_banner_mid::listBannerMid($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteBannerMid()
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
					$database->setQuery('select id, image_name from banner_mid where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'banner_mid');
					$database->setQuery('delete from banner_mid where id = "'.$id.'" and lang="'.$current_lang.'"');
					$database->query();
				}
			}
		}
		replace_location('banner_mid_admin', array('curPg'));
	}
	function deleteBannerMidImage()
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
					$database->setQuery('select id, image_name from banner_mid where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'banner_mid');
					$database->setQuery('update banner_mid set `image_name`="", `image_title`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('banner_mid_admin', array('curPg'));
	}
	function addBannerMid()
	{
		global $database;
		global $current_lang;
		
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$link = getParam("link", 'str');
			$publish = getParam("publish", 'int', 1);
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$link)
			{
				$error_array['link'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			$image_name = '';
			$database->setQuery('SELECT max(id) as max_id from banner_mid');
			$row = $database->loadRow();
			$max_id = $row['max_id']+1;
			
			$error_upload = 0;
			if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp', 'swf')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$error_upload = 1;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfile']['name']);
					upload_image_banner(ROOT_PATH.'xml/', $_FILES['imgfile']['tmp_name'], $image_name);
				}
			}
			
			if(!$error_upload && $is_valid)
			{
				$user_create = $_SESSION['user']['user_name'];
				$time_create = time();
				$query = "INSERT INTO banner_mid (`id`, `title`, `link`, `user_create`, `time_create`, `user_update`, `time_update`, `lang`, `image_name`, `publish`)
				 VALUES('$max_id', '$title', '$link', '$user_create', '$time_create', '$user_create', '$time_create', '$current_lang', '$image_name', '$publish')";
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				}   
				
				if($action == "save")
					replace_location('banner_mid_admin');
				else
					replace_location('banner_mid_admin', array('task'=>'add'));
			}
		}
		HTML_banner_mid::updateBannerMid('', $error_array);
	}
	function editBannerMid()
	{
		global $database;
		global $current_lang;
		
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM banner_mid WHERE id = '".$id."' and lang='".$current_lang."'";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("Tin cần sửa không tồn tại");
						window.location="'.generate_url('banner_mid_admin', array('curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$title = getParam("title", 'str');
			$link = getParam("link", 'str');
			$publish = getParam("publish", 'int', 1);
			$is_valid = 1;
			if(!$title)
			{
				$error_array['title'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			if(!$link)
			{
				$error_array['link'] = '<span class="require_field">'._REQUIRED_FILED.'</span>';
				$is_valid = 0;
			}
			$error_upload = 0;
			$image_name = $row['image_name'];
			if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
			{
				if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp', 'swf')))
				{
					$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
					$error_upload = 1;
				}
				else
				{
					$image_name = date('m').'_'.date('Y').'_'.$row['id'].get_file_type($_FILES['imgfile']['name']);					
					upload_image_banner(ROOT_PATH.'xml/', $_FILES['imgfile']['tmp_name'], $image_name);
					if($image_name != $row['image_name'])
						delete_image($row, 'banner_mid');
				}
			}
			if(!$error_upload && $is_valid)
			{				
				$user_update = $_SESSION['user']['user_name'];
				$time_update = time();
				
				$query = "UPDATE banner_mid SET `title`='$title',`link`='$link', `image_name`='$image_name', `user_update`='$user_update', `time_update` = '$time_update', `lang`='$current_lang', `publish`='$publish' WHERE `id`='".$id."'";
				
				$database->setQuery($query);
				$database->query();
				
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('banner_mid_admin', array('curPg'));
				else
					replace_location('banner_mid_admin', array('task'=>'add'));
			}
		}
		HTML_banner_mid::updateBannerMid($row, $error_array);
	}
?>