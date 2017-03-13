<?php 
	global $database;
	global $current_lang;	
	$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" AND publish=2 AND position=4 ORDER BY region';
	$database->setQuery($query);
	$rows = $database->loadResult();
	if($rows)
	{
		echo '<div class="boder_logo">
    <marquee style="width: 100%;" scrolldelay="70" scrollamount="1" direction="left" onmouseout="this.start()" onmouseover="this.stop()">';
		foreach($rows as $one)
		{
			if($row['other_link'])
				$link = $one['other_link'];
			else
				$link = generate_url('adv', array('id'=>$one['id']));
			$image_file = get_image($one, 'large', 'adv');
			if($image_file)
				echo '<div class="logo_img_qc"><a href="'.$link.'" target="_blank"> <img src="'.$image_file.'" /></a></center></div>';
		}
		echo '</marquee>
 <div style="clear: both;"/>
</div>
';
	}
?>
