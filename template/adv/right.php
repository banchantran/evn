<?php 
	global $database;
	global $current_lang;	
	$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" AND publish=2 ORDER BY region';
	$database->setQuery($query);
	$rows = $database->loadResult();
	if($rows)
	{
		foreach($rows as $one)
		{
			if($row['link'])
				$link = $row['link'];
			else
				$link = generate_url('adv', array('id'=>$one['id']));
			$image_file = get_image($row, 'small', 'adv');
			if($image_file)
				echo '<div class="dang_nhap1"><center><a href="'.$link.'" target="_blank"> <img src="'.$image_file.'" /></a></center></div><div style="clear:both; height:5px;"></div>';
		}
	}
?>
