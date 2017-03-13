<?php 
	global $database;
	global $current_lang;	
	$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" AND publish=2 ORDER BY region, id DESC ';
	$database->setQuery($query);
	$rows = $database->loadResult();
	if($rows)
	{
		$content = '';
		$title = '';
		foreach($rows as $one)
		{
			if(!$title)
				$title = $one['fullname'];
			if($row['link'])
				$link = $row['link'];
			else
				$link = generate_url('adv', array('id'=>$one['id']));
			$image_file = get_image($one, 'small', 'adv');
			if($image_file)
				$content .=  '<div><center><a href="'.$link.'" target="_blank"> <img src="'.$image_file.'" /></a></center></div><div style="clear:both; height:10px;"></div>';
		}
?>
<div class="contactbls">
    <div class="td_r"><?php if($title) echo $title; else echo _ADV; ?></div>
    <div class="ctactbls">
 <?php 
 		echo $content;
 ?>   
    </div>
</div>    
<?php 
	}
?>