<?php
	global $database;
	global $current_lang;
	$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'"  AND title_url="'.getParam(3, 'str').'" ORDER By region';
	$database->setQuery($query);
	$cur = $database->loadRow();
	$query = 'SELECT * FROM `products_services_detail` WHERE lang="'.$current_lang.'" AND url="'.getParam(1, 'str').'" AND sub_url="'.getParam(3, 'str').'" and publish=2 ORDER By region, id DESC';
	$database->setQuery($query);
	$products = $database->loadResult();
?>
<div class="rightbls02">
		<?php
			$image_file = get_image_banner($cur, 'banner', 'products_services');
			//if($image_file)
				echo '<div class="banner"><img src="'.$image_file.'" /></div>';
		?>
    <div class="newsbls1">
<?php 
	if($products)
	{
		$url = getParam(1, 'str');
		$parent_url = getParam(2, 'str');
		$sub_url = getParam(3, 'str');
		foreach($products as $one)
		{
			echo '<div class="dvbls">';
			echo '<div class="ct">';
			$link = generate_url_seo('products_services_detail', array ('url'=>$url, 'parent_url'=>$parent_url, 'sub_url'=>$sub_url, 'title_url'=>$one['title_url']));
			echo ' <a href="'.$link.'.html">'.$one['title'];
			if($one['icon']=='news.gif')
				echo '<img src="'.SITE_PATH.'themes/images/news.gif" />';
			else 
			{
				$icon = get_icon($one, 'small', 'products_services_detail');
				if($icon)
					echo '<img src="'.$icon.'" />';
			}
			echo '</a>';
			$image = get_image($one, 'small', 'products_services_detail');
				if($image)
					echo '<img class="img" src="'.$image.'" />';
			//echo '<div style="clear:both"></div>';
			//echo ' <a href="'.$link.'.html"><img src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a>';
			echo $one['brief'];
			//echo '<div style="clear:both"></div>';
			echo ' <a style="float:left" href="'.$link.'.html"><img style="float:left" src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a>';
			echo '</div></div>';
		}
	}
?>      
    </div>
</div>