<script language="JavaScript" src="<?php echo SITE_PATH ?>themes/tree.js"></script>
<script language="JavaScript" src="<?php echo SITE_PATH ?>themes/tree_items.js"></script>
<script language="JavaScript" src="<?php echo SITE_PATH ?>themes/tree_tpl.js"></script>
<div class="rightbls02">
	<div class="newslist" style="text-align:left;">

	<script language="JavaScript">
	var TREE_ITEMS = [	
	<?php 
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" AND publish =2 ORDER BY region, id DESC';
		$database->setQuery($query);
		$category = $database->loadResult();
		
		echo "['"._HOME."', '".generate_url_seo('home')."'";
			if($category)
			foreach($category as $one)
			{
				if($one['other_link'])
					$link = $one['other_link'];
				else
					$link = generate_url_seo('category', array('url'=>$one['url'])).'.html';
				if($one['type']==1)// la nhan
				{
					echo ",['".$one['title']."', '".$link."']";
				}
				else if($one['type']==2)
				{
					echo ",['".$one['title']."', '".$link."'";
					$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" AND url = "'.$one['url'].'" AND publish =2 ORDER BY region, id DESC';
					$database->setQuery($query);
					$mrows = $database->loadResult();
					if($mrows)
					{
						foreach ($mrows as $mone)
						{
							echo ", ['".$mone['title']."', '".generate_url_seo('detail', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'."']";
						}
					}
					echo ']';
				}
				else if($one['type']==3)
				{
					echo ",['".$one['title']."', '".$link."'";
					$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" AND url = "'.$one['url'].'" AND publish =2 ORDER BY region, id DESC';
					$database->setQuery($query);
					$mrows = $database->loadResult();
					if($mrows)
					{
						foreach ($mrows as $mone)
						{
							echo ", ['".$mone['title']."', '".generate_url_seo('articles_category', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'."']";
						}
					}
					echo ']';
				}
				else if($one['type']==4)
				{
					echo ",['".$one['title']."', '".$link."'";
					$query = 'SELECT * FROM `news_category` WHERE lang="'.$current_lang.'" AND url = "'.$one['url'].'" AND publish =2 ORDER BY region, id DESC';
					$database->setQuery($query);
					$mrows = $database->loadResult();
					if($mrows)
					{
						foreach ($mrows as $mone)
						{
							echo ", ['".$mone['title']."', '".generate_url_seo('articles_category', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'."']";
						}
					}
					echo ']';
				}
				else if($one['type']==5)
				{
					echo ",['".$one['title']."', '".$link."']";
				}
				else if($one['type']==7)
				{
					echo ",['".$one['title']."', '".$link."'";
					$query = 'SELECT * FROM `products_services` WHERE lang="'.$current_lang.'" AND url = "'.$one['url'].'" ORDER BY region, id DESC';
					$database->setQuery($query);
					$mrows = $database->loadResult();
					if($mrows)
					{
						foreach ($mrows as $mone)
						{
							if(!$mone['parent_id'])
                    		{
								echo ", ['".$mone['title']."', '".generate_url_seo('articles_category', array ('url'=>$mone['url'], 'title_url'=>$mone['title_url'])).'.html'."'";
								foreach($mrows as $mone1)
								if($mone1['parent_id']==$mone['id'])
								{
									echo ", ['".$mone1['title']."', '".generate_url_seo('products_services_detail', array ('url'=>$mone['url'], 'sub_url'=>$mone['title_url'], 'title_url'=>$mone1['title_url'])).'.html'."'";
								
									$query = 'SELECT * FROM `products_services_detail` WHERE lang="'.$current_lang.'" AND url = "'.$one['url'].'" AND sub_url="'.$mone1['title_url'].'" ORDER BY region, id DESC';

									$database->setQuery($query);
									$mrowsp = $database->loadResult();
									
									if($mrowsp)
									foreach($mrowsp as $onep)
									 	echo ", ['".$onep['title']."', '".generate_url_seo('products_services_detail', array ('url'=>$mone['url'], 'sub_url'=>$mone['title_url'], 'title_url'=>$mone1['title_url'])).'.html'."']"; 
									
									
									echo "]";
								}
								echo "]";
							
							}
						}
					}
					echo ']';
				}
		}
		echo "]";//COLOSE HOME
		 ?>
	];
	<!--//
		new tree (TREE_ITEMS, TREE_TPL);
	//-->
	</script>
	</div>
</div>