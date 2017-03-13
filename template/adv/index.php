<div class="url"><img src="../../modules/adv/view/themes/images/icon_home.gif" /><a href="<?php echo generate_url("home"); ?>"><b><?php echo _HOME ?></b></a>/ <?php echo _ADV ?></div>
<div class="nd_tin">
<?php 
	global $database;
	global $current_lang;	
	$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" AND id="'.getParam('id', 'int').'"';
	$database->setQuery($query);
	$row = $database->loadRow();
	if($row)
	{
		echo '<div class="news_td">'.$row['title'].'</div>';
		if($row['content'])
			echo string_strip($row['content']);
	}
?>
</div>
