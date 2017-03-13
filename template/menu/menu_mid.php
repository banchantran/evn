<ul id="nav">
<?php		
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" AND publish =2 ORDER BY region, id DESC';
		$database->setQuery($query);
		$rows = $database->loadResult();
		if($rows)
		foreach ($rows as $row)
		{
			if($row['type']==1)// la nhan
			{
				if($row['other_link'])
					$link = $row['other_link'];
				else
					$link = generate_url_seo('category', array ('url'=>$row['url'])).'.html';
				
				echo '<li  class="top01" title="'.$row['title'].'"><a class="top_link" href="'.$link.'"><span>'.$row['title'].'</span></a></li>';
			}
			else if($row['type']==2)// la chi tiet tung bai viet
			{	
				echo '<li class="top01" title="'.$row['title'].'"><a class="top_link" href="'.generate_url_seo('category', array ('url'=>$row['url'])).'.html'.'"><span>'.$row['title'].'</span></a>';
				$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" AND url = "'.$row['url'].'" AND publish =2 ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				{
					echo  '<ul class="sub">';
					foreach ($mrows as $mone)
					{
						echo '<li><a title="'.$one['title'].'" href="'.generate_url_seo('detail', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></li>';
					}
					echo '</ul>';
				}
				echo '</li>';
			}
			else if($row['type']==3)// danh muc bai viet
			{	
				echo '<li class="top01" title="'.$row['title'].'"><a class="top_link" href="'.generate_url_seo('category', array ('url'=>$row['url'])).'.html'.'"><span>'.$row['title'].'</span></a>';
				$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" AND url = "'.$row['url'].'" AND publish =2 ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				{
					echo  '<ul class="sub">';
					foreach ($mrows as $mone)
					{
						echo '<li><a title="'.$one['title'].'" href="'.generate_url_seo('articles_category', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></li>';
					}
					echo '</ul>';
				}
				echo '</li>';
			}
			else if($row['type']==4)// danh muc tin tuc
			{	
				echo '<li class="top01" title="'.$row['title'].'"><a class="top_link" href="'.generate_url_seo('news_category', array ('url'=>$row['url'])).'.html'.'"><span>'.$row['title'].'</span></a>';
				$query = 'SELECT * FROM `news_category` WHERE lang="'.$current_lang.'" AND url = "'.$row['url'].'"  AND publish=2  ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				{
					echo  '<ul class="sub">';
					foreach ($mrows as $mone)
					{
						echo '<li><a title="'.$one['title'].'" href="'.generate_url_seo('news_category', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'.'">'.$mone['title'].'</a></li>';
					}
					echo '</ul>';
				}
				echo '</li>';
			}
			else if($row['type']==5)// lien he
			{	
				echo '<li class="top01" title="'.$row['title'].'"><a class="top_link" href="'.generate_url_seo('news_category', array ('url'=>$row['url'])).'.html'.'"><span>'.$row['title'].'</span></a></li>';
			}
			else if($row['type']==7)// la san pham dich vu
			{
				echo '<li class="top01" title="'.$row['title'].'"><a class="top_link" href="'.generate_url_seo('products_services_cat1', array('url'=>$row['url'])).'.html"><span>'.$row['title'].'</span></a>';
				$query = 'SELECT * FROM `products_services` WHERE `lang` = "'.$current_lang.'"  AND url = "'.$row['url'].'" ORDER BY region';
				//echo $query;
				$database->setQuery($query);
				$all_p = $database->loadResult();
				if($all_p)
				{
					echo  '<ul class="sub">';
					$clas ='';
					foreach($all_p as $one_p)
					{
						if($one_p['parent_id']==0)
						{
							echo '<li '.$clas.'><a class="fly" href="'.generate_url_seo('products_services_cat2', array ('url'=>$row['url'], 'sub_url'=>$one_p['title_url'])).'.html">'.$one_p['title'].'</a>';
							$sub = "<ul>";
							foreach($all_p as $one_p1)
							{
								if($one_p1['parent_id']== $one_p['id'])
									$sub .= '<li><a href="'.generate_url_seo('products_services_detail',  array ('url'=>$row['url'], 'sub_url'=>$one_p['title_url'], 'sub_url1'=>$one_p1['title_url'])).'.html">'.$one_p1['title'].'</a></li>';
							}
							if($sub != '<ul>')
								echo $sub.'</ul>';
							echo '</li>';
							$clas = ' class="mid"';
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			}
		}
?>                
    </ul>