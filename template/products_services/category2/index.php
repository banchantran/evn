<?php
	global $database;
	global $current_lang;
	$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'"  AND title_url="'.getParam(2, 'str').'" ORDER By region';
	$database->setQuery($query);
	$cur = $database->loadRow();
	if($cur)
	$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'"  AND parent_id='.$cur['id'].' ORDER By region';
	$database->setQuery($query);
	$products = $database->loadResult();
?>
<div class="rightbls02">
	
		<?php
			$image_file = get_image_banner($cur, 'banner', 'products_services');
			if($image_file)
				echo '<div class="banner"><img src="'.$image_file.'" /></div>';
		?>
    <div class="newsbls1">
<?php 
	if($products)
	{
		$url = getParam(1, 'str');
		$sub_url = getParam(2, 'str');
		foreach($products as $one)
		{
			echo '<div class="dvbls">';
			echo '<div class="ct">';
			if($one['other_link'])
				$link = $one['other_link'];
			else
				$link = generate_url_seo('products_services_detail', array ('url'=>$url, 'sub_url'=>$sub_url, 'title_url'=>$one['title_url'])).'.html';
			echo ' <a href="'.$link.'">'.$one['title'].'</a>';
			$image = get_image($one, 'small', 'products_services');
				if($image)
					echo '<img class="img" src="'.$image.'" />';
			echo $one['content'];
			echo '<div style="clear:both"></div>';
			
			echo '</div></div>';
		}
	}
?>      
    </div>
</div>
