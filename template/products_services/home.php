<div class="nd_l">
<?php 
	$query = 'SELECT * FROM `products_services` WHERE `lang` = "'.$current_lang.'" AND tieubieu=2 ORDER BY region';
	$database->setQuery($query);
	$all_news_category = $database->loadResult();
	if($all_news_category)
	{
		$i=1;
		foreach($all_news_category as $one)
		{
			if(!$one['parent_id'])
			{
				echo '<div class="cl1"><div class="td_dv"><a href="'.generate_url_seo('products_services_cat2', array ('url'=>$one['url'], 'sub_url'=>$one['title_url'])).'.html">'.$one['title'].'</a></div>';
				echo '<div class="nd_dv">';
				$image = get_image_home($one, 'home', 'products_services');
				if($image)
					echo '<a href=""><img src="'.$image .'" /></a>';
				echo '<ul>';
				foreach($all_news_category as $one1)
					if($one['id']==$one1['parent_id'])
					echo '<li><a href="'.generate_url_seo('products_services_detail', array ('url'=>$one['url'], 'sub_url'=>$one['title_url'], 'title_url'=>$one1['title_url'])).'.html">'.$one1['title'].'</a></li>';	
				echo '</ul></div><div class="bottom_dv"></div></div>';
				$i++;
			}
		}
	}
	
?>    
    <div class="clear"></div>
</div>