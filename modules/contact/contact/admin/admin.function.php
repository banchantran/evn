<?php
	//List contact
	function listContact()
	{
		global $database;
		
		$totalRows = 0;
		$itemPerPage = 10;
		$numPageShow = 10;
		$curPg = getParam('curPg', 'int', 1);
		
		if(getParam('status', 'int', 1)!=3)
			$condition = ' and status="'.getParam('status', 'int', 1).'"';
		
		$totalRows = $database->getNumRows('contact_us', ' 1 '.$condition);
		if($curPg > ($totalRows/$itemPerPage))
			$curPg = 1;
		$query = 'SELECT * FROM `contact_us` WHERE 1 '.$condition.' ORDER BY id desc limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
		$database->setQuery($query);
		$rows = $database->loadResult();
		
		if($database->getErrorNum()){
			echo $database->stderr();
			return;
		}
		$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
		HTML_contact::listContact($rows, $pagging, ($curPg-1)*$itemPerPage);
	}
	function deleteContact()
	{
		global $database;
		$list_id = getParam('value', 'str');
		$list_id = explode(',', getParam('value', 'str'));
		if(count($list_id)>0)
		{
			foreach($list_id as $id)
			{
				if(isset($id) && $id>0 && is_numeric($id))
				{
					$database->setQuery('delete from contact_us where id = "'.$id.'" ');
					$database->query();
				}
			}
		}
		replace_location('contact_admin', array('curPg'));
	}
	function editContact()
	{
		global $database;
		
		$action = getParam("action", 'str');
		$id = getParam("id", 'int');
		$query = "SELECT * FROM contact_us WHERE id = '".$id."' ";
		$database->setQuery($query);
		$row = $database->loadRow();
		if(!$row)
		{
			echo '	<script>
						alert("'._CONTACT_NOT_EXISTS.'");
						window.location="'.generate_url('contact_admin', array('curPg')).'";
					</script>';
			return;
		}
		$error_array = array();
		if($action == "save")
		{
			$status = getParam("status", 'int');
			$user_update = $_SESSION['user']['user_name'];
			$time_update = time();
			$admin_comment = getParam("admin_comment", 'def');
			
			$query = "UPDATE contact_us SET `admin_comment`='$admin_comment', `status`='$status', `user_update`='$user_update', `time_update`='$time_update' WHERE `id`='".$id."'";
			$database->setQuery($query);
			$database->query();
			
			if($database->getErrorNum()){
				echo $database->stderr();
				return;
			} 
			replace_location('contact_admin', array('curPg'));
		}
		HTML_contact::updateContact($row);
	}
?>