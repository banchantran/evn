<?php
	//List link
	function listLink()
	{
		global $database;
		global $current_lang;	
		$totalRows = 0;
		$itemPerPage = 10;
		$numPageShow = 10;
		$curPg = getParam('curPg', 'int', 1);
		if(getParam('id', 'int', 0))
			$condition = ' and id="'.getParam('id', 'int', 0).'"';
			
		$totalRows = $database->getNumRows('link', ' lang="'.$current_lang.'" '.$condition);		
		$query = 'SELECT * FROM `link` WHERE `lang`="'.$current_lang.'" '.$condition.' ORDER BY region limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		$status = getParam("status", 'str');
		if($status == "publish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{					
				$query = 'UPDATE `link` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('link_admin');
				exit;
			}
		}
		if($status == "unpublish")
		{
			$id = getParam('id', 'int', 0);
			if($id)
			{	
				$query = 'UPDATE `link` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$id.'"';
				$database->setQuery($query);
				$database->query();

				replace_location('link_admin');
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
					$query = 'UPDATE `link` SET `publish`=2 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('link_admin');
			exit;
		}
		if($action == "unpublish")
		{
			foreach($rows as $one)
			{
				if(getParam($one['id'], 'int', 0))
				{	
					$query = 'UPDATE `link` SET `publish`=1 WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('link_admin');
			exit;
		}
		$action = getParam("action", 'str');
		if($action == "save_order")
		{
			foreach($rows as $one)
			{
				if($one['region'] != getParam('region_'.$one['id'], 'int'))
				{
					$query = 'UPDATE `link` SET `region`="'.getParam('region_'.$one['id'], 'int').'" WHERE lang="'.$current_lang.'" and `id`="'.$one['id'].'"';
					$database->setQuery($query);
					$database->query();
				}
			}
			replace_location('link_admin');
			exit;
		}
		
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_link::listLink($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteLink()
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
					$database->setQuery('delete from link where id = "'.$id.'" ');
					$database->query();
				}
			}
		}
		replace_location('link_admin', array('curPg'));
	}
	function addLink()
	{
		global $database;
		global $current_lang;
		$action = getParam("action", 'str');
		$error_array = array();
		if($action == "save" || $action == "apply")
		{
			$region = getParam("region");
			$fullname = getParam("fullname", 'str');
			$link = getParam("link", 'str');
			$publish = getParam('publish', 'int', 0);
			$is_valid = 1;
			if(!$link)
			{
				$error_array['link'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$database->setQuery('SELECT max(id) as max_id from link');
				$row = $database->loadRow();
				$max_id = $row['max_id']+1;
				$query = "INSERT INTO link (`id`, `fullname`, `link`, `region`, `lang`, `publish`)
				 VALUES('$max_id', '$fullname', '$link', '$region', '$current_lang', '$publish')";
				$database->setQuery($query);
				$database->query();
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('link_admin');
				else
					replace_location('link_admin', array('task'=>'add'));
			}
		}
		HTML_link::updateLink('', $error_array);
	}
	function editLink()
	{
		global $database;
		global $current_lang;
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM link WHERE id = '".$id."' ";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._LINK_NOT_EXISTS.'");
						window.location="'.generate_url('link_admin', array('curPg')).'";
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
			$is_valid = 1;
			if(!$link)
			{
				$error_array['link'] = '<span class="require_field">'._REQUIRED_FIELD.'</span>';
				$is_valid = 0;
			}
			if($is_valid)
			{
				$query = "UPDATE link SET `fullname`='$fullname', `region`='$region', `link`='$link', `lang`='$current_lang', `publish`='$publish' WHERE `id`='".$id."'";
				$database->setQuery($query);
				$database->query();
				if($database->getErrorNum()){
					echo $database->stderr();
					return;
				} 
				if($action == "save")
					replace_location('link_admin', array('curPg'));
				else
					replace_location('link_admin', array('task'=>'add'));
			}
		}
		HTML_link::updateLink($row, $error_array);
	}
?>