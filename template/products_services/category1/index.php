<?php
	global $database;
	global $current_lang;
	
	$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND url="'.getParam(1, 'str').'"  AND parent_id=0 ORDER By region';
?>
<div class="rightbls02">
	<div class="nd_l">
<?php 
	$database->setQuery($query);
	$all_news_category = $database->loadResult();
	if($all_news_category)
	{
		foreach($all_news_category as $one)
		{
				if($one['other_link'])
					$link = $one['other_link'];
				else
					$link = generate_url_seo('products_services_cat2', array ('url'=>$one['url'], 'sub_url'=>$one['title_url'])).'.html';
				echo '<div class="cl1"><div class="td_dv2"><a href="'.$link.'">'.$one['title'].'</a></div>';
				
				$image = get_image($one, 'small', 'products_services');
				if($image)
					echo '<div class="nd_dv2"><a href=""><img src="'.$image .'" /></a><ul>';

				echo '</ul></div><div class="bottom_dv"></div></div>';
		}
	}
	
?>    
    <div class="clear"></div>
</div>
<div class="rightbls02">
    <div class="newsbls1">
<?php 
	$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'"  AND url="'.getParam(1, 'str').'"   ORDER By region';
	$database->setQuery($query);
	$products = $database->loadResult();

	if($products)
	{
		$url = getParam(1, 'str');
		$sub_url = getParam(2, 'str');
		foreach($products as $one)
		if($one['publish1']==2)
		{
			foreach($products as $one1)
				if($one['parent_id']==$one1['id'])
				{
					$sub_url = $one1['title_url'];
					break;
				}
			echo '<div class="dvbls">';
			echo '<div class="ct">';
			if($one1['other_link'])
				$link = $one1['other_link'];
			else
				$link = generate_url_seo('products_services_detail', array ('url'=>$url, 'sub_url'=>$sub_url, 'title_url'=>$one['title_url']));
			echo ' <a href="'.$link.'.html">'.$one['title'].'</a>';
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
