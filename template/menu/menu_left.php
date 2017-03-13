<div class="leftmenu"><div class="bor1"><div class="bor2"><div class="bor3"><div class="bor4">
<?php 
	global $database;
	global $current_lang;
	
	global $type_module;
	$url = getParam(1, 'str');
	
	if($url=='sitemap')
	{
			
	}
	else if($type_module==2)
	{
		$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" AND url = "'.$url.'"  AND publish=2  ORDER BY region, id DESC';
		$database->setQuery($query);
		$all_news_category = $database->loadResult();
		if($all_news_category)
		{
			echo '<ul class="lmn">';
			foreach($all_news_category as $one)
				echo '<li><a href="'.generate_url_seo('detail', array ('url'=>$one['url'], 'title_url'=>$one['title_url'])).'.html'.'">'.$one['title'].'</a></li>';
			echo '</ul>';
		}
	}
	else if($type_module==3)
	{
		$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" AND url = "'.$url.'"  AND publish=2  ORDER BY region, id DESC';
		$database->setQuery($query);
		$articles_category = $database->loadResult();
		if($articles_category)
		{
			echo '<ul class="lmn">';
			foreach($articles_category as $one)
				echo '<li><a href="'.generate_url_seo('articles_category', array ('url'=>$one['url'], 'title_url'=>$one['title_url'])).'.html">'.$one['title'].'</a></li>';
			echo '</ul>';
		}
	}
	else if($type_module==4)
	{
		$query = 'SELECT * FROM `news_category` WHERE lang="'.$current_lang.'" AND url = "'.$url.'"  AND publish=2  ORDER BY region, id DESC';
		$database->setQuery($query);
		$news_category = $database->loadResult();
		if($news_category)
		{
			echo '<ul class="lmn">';
			foreach($news_category as $one)
				echo '<li><a href="'.generate_url_seo('news_category', array ('url'=>$one['url'], 'title_url'=>$one['title_url'])).'.html">'.$one['title'].'</a></li>';
			echo '</ul>';
		}
	}	
	else
	{
		$query = 'SELECT * FROM `products_services` WHERE `lang` = "'.$current_lang.'" AND tieubieu=2 AND url="'.$url.'" ORDER BY region, id DESC';
		$database->setQuery($query);
		$all_news_category = $database->loadResult();
		if($all_news_category)
		{
			foreach($all_news_category as $one)
			{
				if(!$one['parent_id'])
				{
					echo '<div class="mn01"><a href="'.generate_url_seo('products_services_cat2', array ('url'=>$one['url'], 'sub_url'=>$one['title_url'])).'.html">'.$one['title'].'</a></div>';
					
					echo '<ul class="lmn">';
						foreach($all_news_category as $one1)
						if($one['id']==$one1['parent_id'])
							echo '<li><a href="'.generate_url_seo('products_services_detail',  array ('url'=>$one['url'], 'sub_url'=>$one['title_url'], 'title_url'=>$one1['title_url'])).'.html">'.$one1['title'].'</a></li>';
							
					echo '</ul>';
				}
			}
		}
	}
?>
    </div></div></div></div></div>