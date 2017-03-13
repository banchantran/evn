<?php
	global $current_lang;
	global $database;
	$action = getParam("action", 'str');
	$database->setQuery('SELECT max(id) as max_id from email_register');
			$row = $database->loadRow();
			$max_id = $row['max_id']+1;
	if($action == "save")
	{
		if($row['title'])
		{				
				$title = getParam("title", 'str');
		$query = "INSERT INTO email_register (`id`, `title`)
				 VALUES('$max_id', '$title')";
				$database->setQuery($query);
				$database->query();
				if($action == "save")
					replace_location('');
		}
	}
?>
<script>
	function submitbutton(pressbutton)
	{
		document.email_add.action.value=pressbutton;
		try
		{
			document.email_add.onsubmit();
		}
		catch(e)
		{}
		document.email_add.submit();
	}
</script>
<form name="email_add" method="post">
		<input name="title" class="inputbox" style="width:500px;" value="<?php echo getParam('title', 'str', $row['title']);?>" maxlength="255" type="text"><a class="toolbar" href="javascript:submitbutton('save');">
					<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
				</a>
		<input type="hidden" name="action" value="" />
</form>