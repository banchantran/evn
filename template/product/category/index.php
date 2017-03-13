<?php
	global $database;
	global $current_lang;
	$url1 = getParam(1, 'str');
	$url2 = getParam(2, 'str');
	$url4 = getParam(4, 'str');
	$query = 'SELECT title FROM `product2_cat` WHERE lang="'.$current_lang.'" AND url = "'.$url1.'"  AND sub_url = "'.$url2.'"  AND product_url = "'.$url4.'" AND publish =2 ORDER BY region, id DESC';
			$database->setQuery($query);
			$row = $database->loadRow();
	echo '<div class="main-content_pro"><h1  title="'.$row['title'].'">'.$row['title'].'</h1><br>';	
	echo '<div class="products-acs">';
			$query = 'SELECT * FROM `product2_detail` WHERE lang="'.$current_lang.'" AND url = "'.$url1.'"  AND sub_url = "'.$url2.'"  AND product_url = "'.$url4.'" AND publish =2 ORDER BY region, id DESC';
			$database->setQuery($query);
			$p_rows = $database->loadResult();
			if($p_rows)
				foreach ($p_rows as $one)
				{					
					echo '<div class="product-center"><div class="title"><div class="hd">';
					echo '<div class="row"><h3 title="'.$one['title'].'">'.$one['title'].'</h3></div>';
					echo '<br />';
					$image_file = get_image($one, 'small', 'product2_detail');
					if($image_file)
					echo '<div class="image"><a href="'.generate_url_seo('product', array ('url'=>$url1, 'sub_url'=>$url2, 'module'=>'product2_detail', 'product_url'=>$one['detail_url'].'.html')).'"><center><img width="145px" src="'.$image_file.'" alt="'.$one['title'].'"></center></a></div>';
					echo '<br />';
					echo '<span class="word-wrap">&nbsp;'.$one['brief'].'</span>';
					echo '<div class="msgPrice">U.S. List Price</div>';
					echo '<div class="footer" style="display:block;">
							<div class="price">'.$one['price'].'</div>
							<a class="viewDetails" href="'.generate_url_seo('product', array ('url'=>$url1, 'sub_url'=>$url2, 'module'=>'product2_detail', 'product_url'=>$one['detail_url'].'.html')).'">'._DETAIL.'</a>
					</div></div></div></div>';
				}
				echo '</div><div style="clear:both"></div><br /></div>';
?>				