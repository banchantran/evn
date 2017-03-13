<?php
	global $database;
	global $current_lang;

	$url = getParam(1, 'str');
	$query = 'SELECT * FROM `news_category` where `lang`= "'.$current_lang.'" AND url="'.$url.'" AND publish=2  ORDER BY region, id DESC';
	$database->setQuery($query);
	$category = $database->loadResult();
	if($database->getErrorNum()){
		echo $database->stderr();
		return;
	}
?>
<div class="rightbls02">
    <div class="newsbls1">
<?php 
	foreach($category as $one)
	{
?>        
        <div class="newsbls">
            <div class="title"><a href="<?php echo generate_url_seo('news_category', array ('url'=>$one['url'], 'title_url'=>$one['title_url'])).'.html'; ?>"><?php echo $one['title'];?>
			</a></div>
<?php
		$query = 'SELECT * FROM `news_detail` where `lang`= "'.$current_lang.'" AND url="'.$url.'" AND sub_url="'.$one['title_url'].'"  AND publish=2  ORDER BY region, id desc limit 0,4';
		$n=0;
		$str = '';
		$database->setQuery($query);
		$all_news = $database->loadResult();
		if($all_news)
		foreach($all_news as $row)
		{
			$link = generate_url_seo('news_detail',array('url'=>$row['url'], 'sub_url'=>$row['sub_url'], 'title_url'=>$row['title_url'])).'.html';
			if($n==0)
			{
				$n++;
				$image = get_image($row, 'large', 'news');
				if($image)
					echo '<img class="img" src="'.$image.'" />';
				echo '<div class="ct"> <a href="'.$link.'">'.$row['title'];
				if($row['icon']=='news.gif')
					echo '<img src="'.SITE_PATH.'themes/images/news.gif" />';
				else 
				{
					$icon = get_icon($row, 'small', 'news');
					if($icon)
						echo '<img src="'.$icon.'" />';
				}
				
				echo '</a>'.$row['brief'].' <a href="'.$link.'"><img src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a>'.'</div>';
			}
			else
			{
				$str .= ' <li><a href="'.$link.'">'.$row['title'];
				if($row['icon']=='news.gif')
					$str .= '<img src="'.SITE_PATH.'themes/images/news.gif" />';
				else 
				{
					$icon = get_icon($row, 'small', 'news');
					if($icon)
						$str .= '<img src="'.$icon.'" />';
				}
				
				$str .= '</a>&nbsp;'.date('d/m/Y', $row['time_create']).'</li>';
				
				
			}
		}             
?>            
        <ul class="newsother02">
               <?php echo $str ?>
        </ul>
        </div>
<?php 
	}
?>        
    </div>
</div>