<?php
	//List adv
	function listAdv()
	{
		global $database;
		global $current_lang;	
		$totalRows = 0;
		$itemPerPage = 10;
		$numPageShow = 10;
		$curPg = getParam('curPg', 'int', 1);
		if(getParam('type_id', 'int', 0))
			$condition = ' and type_id="'.getParam('type_id', 'int', 0).'"';
			
		$totalRows = $database->getNumRows('adv', ' 1 '.$condition);
		
		$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" '.$condition.' ORDER BY region limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$query = 'UPDATE `adv` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('adv_admin');
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `adv` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('adv_admin');
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
					$query = 'UPDATE `adv` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('adv_admin');
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `adv` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('adv_admin');
			exit;
		}
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `adv` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('adv_admin');
			exit;
		}
		
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_adv::listAdv($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteAdv()
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
					$database->setQuery('select id, image_name from adv where id = "'.$id.'"');
					$row = $database->loadRow();
					deleteAdvImage($row);
					$database->setQuery('delete from adv where id = "'.$id.'" ');
					$database->query();
				}
			}
		}
		replace_location('adv_admin', array('curPg'));
	}
	function deleteAdvImage()
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
					$database->setQuery('select * from adv where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->loadRow();
					delete_image($row, 'adv');
					$database->setQuery('update adv set `image_name`="" where id = "'.$id.'" and lang="'.$current_lang.'"');
					$row = $database->query();
				}
			}
		}
		replace_location('adv_admin', array('curPg'));
	}
	function addAdv()
	{
		global $database;
		global $current_lang;
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$region = getParam("region");
			$fullname = getParam("fullname", 'str');
			$content = getParam("content", 'def');
			$publish = getParam('publish', 'int', 0);
			$position = getParam('position', 'int', 0);
			$adv = getParam('adv', 'int', 0);
			$link = getParam("link", 'str');
			$is_valid = 1;
			if($is_valid)
			{
				$image_name = '';
				$database->setQuery('SELECT max(id) as max_id from adv');
				$row = $database->loadRow();
				$max_id = $row['max_id']+1;
				
				$error_upload = 0;
				if(isset($_FILES['imgfile']) and $_FILES['imgfile']['error']==0)
				{
					if(!check_type_file($_FILES['imgfile']['name'], array('jpg','gif','jpeg','png', 'bmp')))
					{
						$error_array['imagefile'] = '<span class="require_field">'._FILE_TYPE_NOT_VALID.'</span>';
						$error_upload = 1;
					}
					else
					{
						$image_name = date('m').'_'.date('Y').'_'.$max_id.get_file_type($_FILES['imgfile']['name']);
						upload_image_adv(DATA_PATH.'images/adv/', $_FILES['imgfile']['tmp_name'], $image_name, array('0'=>165, '1'=>138));
					}
				}
				if(!$error_upload)
				{
					$query = "INSERT INTO adv (`id`, `fullname`, `content`, `link`, `image_name`, `region`, `lang`, `publish`, `position`)
					 VALUES('$max_id', '$fullname', '$content', '$link', '$image_name', '$region', '$current_lang', '$publish', '$position')";
					$database->setQuery($query);
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					}
					if($action == "save")
						replace_location('adv_admin');
					else
						replace_location('adv_admin', array('task'=>'add'));
				}
			}
		}
		HTML_adv::updateAdv('', $error_array);
	}
	function editAdv()
	{
		global $database;
		global $current_lang;
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM adv WHERE id = '".$id."' ";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._ADV_NOT_EXISTS.'");
						window.location="'.generate_url('adv_admin', array('curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$fullname = getParam("fullname", 'str');
			$type_id = getParam("type_id");
			$region = getParam("region");
			$content = getParam("content", 'def');
			$link = getParam("link", 'str');
			$publish = getParam('publish', 'int', 0);
			$position = getParam('position', 'int', 0);
			$adv = getParam('adv', 'int', 0);
			
			$is_valid = 1;
			if($is_valid)
			{
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
						upload_image_adv(DATA_PATH.'images/adv/', $_FILES['imgfile']['tmp_name'], $image_name, array('0'=>165, '1'=>138));
						//if($image_name != $row['image_name'])
							//delete_adv($row);
					}
				}
				if(!$error_upload)
				{
					$query = "UPDATE `adv` SET `fullname`='$fullname', `content`='$content', `region`='$region', `link`='$link', `image_name`='$image_name', `lang`='$current_lang', `region`='$region', `publish`='$publish', `position`='$position' WHERE `id`='".$id."'";
					$database->setQuery($query);
					$database->query();
					if($database->getErrorNum()){
						echo $database->stderr();
						return;
					} 
					if($action == "save")
						replace_location('adv_admin', array('curPg'));
					else
						replace_location('adv_admin', array('task'=>'add'));
				}
			}
		}
		HTML_adv::updateAdv($row, $error_array);
	}
?>