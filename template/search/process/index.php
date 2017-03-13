<div class="rightbls02">
    <div class="cdongbls1"> 
<?php		
		global $database;
		global $current_lang;
		
		$search_text = urldecode(getParam('key'));
		$search_text_url = urlSeo($search_text);
		$condition = ' and (`title_url` like "%'.$search_text_url.'%" or `title` like "%'.$search_text.'%" or `content` like "%'.$search_text.'%" or `content` like "%'.$search_text_url.'%") ';
		
		$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" '.$condition.' AND publish =2 GROUP BY url ORDER BY region, id DESC';
		//echo $query;
		$database->setQuery($query);
		$mrows = $database->loadResult();
		if($mrows)
		{
			$url = '';
			foreach($mrows as $mone)
			{
				if($url!=$mone['url'])
				{
					$url = $mone['url'];
					$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" AND url="'.$url.'" AND publish =2';
					$database->setQuery($query);
					$curl = $database->loadRow();
					if($curl)
					{
						if($curl['other_link'])
							$link = $curl['other_link'];
						else
							$link = generate_url_seo('category', array ('url'=>$curl['url'])).'.html';
						echo '<div class="title_s"><a href="'.$link.'">'.$curl['title'].'</a></div>';
					}
					echo '<div class="cdongbls"> <a title="'.$one['title'].'" href="'.generate_url_seo('detail', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></div>';
					
				}
				else
					echo '<div class="cdongbls"> <a title="'.$one['title'].'" href="'.generate_url_seo('detail', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></div>';
			}
		}
		
?>
		<div style="width:20px; margin-top:20px; clear:both;"></div>
<?php		
		$condition = ' and (`title_url` like "%'.$search_text.'%" or `title` like "%'.$search_text.'%" or `brief` like "%'.$search_text.'%" or `content` like "%'.$search_text.'%") ';
		
		$query = 'SELECT * FROM `news_detail` WHERE lang="'.$current_lang.'" '.$condition.' AND publish =2 GROUP BY url ORDER BY region, id DESC';
		$database->setQuery($query);
		$mrows = $database->loadResult();
		if($mrows)
		{
			$url = '';
			foreach($mrows as $mone)
			{
				if($url!=$mone['url'])
				{
					$url = $mone['url'];
					$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" AND url="'.$url.'" AND publish =2';
					$database->setQuery($query);
					$curl = $database->loadRow();
					if($curl)
					{
						if($curl['other_link'])
							$link = $curl['other_link'];
						else
							$link = generate_url_seo('category', array ('url'=>$curl['url'])).'.html';
						//echo '<div class="title_s"><a href="'.$link.'">'.$curl['title'].'</a></div>';
					}
					echo '<div class="cdongbls"> <a title="'.$one['title'].'" href="'.generate_url_seo('detail', array ('url'=>$mone['url'], 'sub_url'=>$mone['sub_url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></div>';
					
				}
				else
					echo '<div class="cdongbls"> <a title="'.$one['title'].'" href="'.generate_url_seo('detail', array ('url'=>$mone['url'], 'sub_url'=>$mone['sub_url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></div>';
			}
		}		
?>
 <div style="width:20px; margin-top:20px; clear:both;"></div>
<?php		
		$condition = ' and (`title_url` like "%'.$search_text_url.'%" or `title` like "%'.$search_text.'%" or `content` like "%'.$search_text.'%" or `content` like "%'.$search_text_url.'%") ';
		
		$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" '.$condition.' ORDER BY region, id DESC';
		$database->setQuery($query);
		$mrows = $database->loadResult();
		if($mrows)
		{
			$url = '';
			foreach($mrows as $curl)
			{
				if($curl['parent_id'])
				{
					$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND id='.$curl['parent_id'];
					$database->setQuery($query);
					$pRow = $database->loadRow();
					if($curl['other_link'])
						$link = $curl['other_link'];
					else
						$link = generate_url_seo('products_services', array ('url'=>$curl['url'], 'sub_url'=>$pRow['title_url'], 'title_url'=>$curl['title_url'])).'.html';	
				}
				else
				{
					if($curl['other_link'])
						$link = $curl['other_link'];
					else
						$link = generate_url_seo('products_services', array ('url'=>$curl['url'], 'sub_url'=>$curl['title_url'])).'.html';	
				}
				echo '<div class="cdongbls"><a href="'.$link.'">'.$curl['title'].'</a></div>';
			}
		}		
?>
<div style="width:20px; margin-top:20px; clear:both;"></div>
<?php		
		$condition = ' and (`title_url` like "%'.$search_text_url.'%" or `title` like "%'.$search_text.'%" or `content` like "%'.$search_text.'%" or `content` like "%'.$search_text_url.'%") ';
		
		$query = 'SELECT * FROM `products_services_detail` WHERE lang="'.$current_lang.'" '.$condition.' ORDER BY region, id DESC';
		$database->setQuery($query);
		$mrows = $database->loadResult();
		if($mrows)
		{
			$url = '';
			foreach($mrows as $curl)
			{
				$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND title_url="'.$curl['sub_url'].'"';
				$database->setQuery($query);
				$cRow = $database->loadRow();
				if($cRow['parent_id'])
				{
					
					$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND id='.$cRow['parent_id'];
					$database->setQuery($query);
					$pRow = $database->loadRow();
					if($curl['other_link'])
						$link = $curl['other_link'];
					else
						$link = generate_url_seo('products_services', array ('url'=>$curl['url'], 'parent_url'=>$pRow['title_url'], 'sub_url'=>$cRow['title_url'], 'title_url'=>$curl['title_url'])).'.html';	
				}
				else
				{
					if($curl['other_link'])
						$link = $curl['other_link'];
					else
						$link = generate_url_seo('products_services', array ('url'=>$curl['url'], 'sub_url'=>$curl['sub_url'], 'title_url'=>$curl['title_url'])).'.html';	
				}
				echo '<div class="cdongbls"><a href="'.$link.'">'.$curl['title'].'</a></div>';
			}
		}		
?>      
     </div>
 </div>