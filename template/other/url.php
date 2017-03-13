<div class="url">
    <a class="selected" href="<?php echo generate_url_seo('home') ?>"><?php echo _HOME ?></a> &raquo;
	<?php 
	global $database;
	global $current_lang;
	if(getParam('module', 'str', '')=='search')
	{
		echo '<a class="selected" href="#">'._SEARCH.'</a>';
	}
	else
	{
		$url = getParam(1, 'str');
		if($url=='sitemap')
		{
			echo '<a class="selected" href="'.generate_url_seo('', array('url'=>'stitemap')).'.html">Site map</a>';
		}
		else
		{
			$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" AND url = "'.$url.'"  AND publish=2 ';
			$database->setQuery($query);
			$cat = $database->loadRow();
			echo '<a class="selected" href="'.generate_url_seo('', array('url'=>$cat['url'])).'.html">'.$cat['title'].'</a>';
		
			global $type_module;
			if($type_module==3)
			{
				$sub_url = getParam(2, 'str');
				if($sub_url)
				{
					$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" AND url = "'.$url.'" AND title_url="'.$sub_url.'" AND publish=2';
					$database->setQuery($query);
					$sub_cat = $database->loadRow();
					if($sub_cat)
						echo ' &raquo; <a class="selected" href="'.generate_url_seo('', array('url'=>$cat['url'], 'sub_cat'=>$sub_cat['title_url'])).'.html">'.$sub_cat['title'].'</a>';
				}
			}
			if($type_module==4)
			{
				$sub_url = getParam(2, 'str');
				if($sub_url)
				{
					$query = 'SELECT * FROM `news_category` WHERE lang="'.$current_lang.'" AND url = "'.$url.'" AND title_url="'.$sub_url.'" AND publish=2';
					$database->setQuery($query);
					$sub_cat = $database->loadRow();
					if($sub_cat)
						echo ' &raquo; <a class="selected" href="'.generate_url_seo('', array('url'=>$cat['url'], 'sub_cat'=>$sub_cat['title_url'])).'.html">'.$sub_cat['title'].'</a>';
				}
			}
			if($type_module==7)
			{
				$title_url = getParam(3, 'str');
				$sub_url = getParam(2, 'str');
				if($sub_url)
				{
					$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND url = "'.$url.'" AND title_url="'.$sub_url.'"';
					$database->setQuery($query);
					$sub_cat = $database->loadRow();
					if($sub_cat)
						echo ' &raquo; <a class="selected" href="'.generate_url_seo('', array('url'=>$cat['url'], 'sub_cat'=>$sub_cat['title_url'])).'.html">'.$sub_cat['title'].'</a>';
					
					$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND url = "'.$url.'" AND title_url="'.$title_url.'"';
					$database->setQuery($query);
					$sub_cat = $database->loadRow();
					if($sub_cat)
						echo ' &raquo; <a class="selected" href="'.generate_url_seo('', array('url'=>$cat['url'], 'sub_cat'=>$sub_cat['title_url'])).'.html">'.$sub_cat['title'].'</a>';
				}
			}
		}
	}
?>	    
</div>