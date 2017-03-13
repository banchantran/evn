<?php
	global $database;
	global $current_lang;
	$sub_url = getParam(2, 'str');
	$url = getParam(1, 'str');
	if($sub_url)
		$con = ' AND sub_url="'.$sub_url.'" ';
	
	//$totalRows = 0;
	//$itemPerPage = 2;
	//$numPageShow = 2;
	
	//$totalRows = $database->getNumRows('news_detail', ' `lang`= "'.$current_lang.'" '.$con);
	
	//$curPg = getParam('curPg', 'int', 1);
	
	//$query = 'SELECT * FROM `news_detail` where `lang`= "'.$current_lang.'"'.$con.' ORDER BY id desc limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
	
	
	$query = 'SELECT * FROM `news_detail` where `lang`= "'.$current_lang.'"'.$con.' ORDER BY region, id desc limit 10';
	//hien thi tu do 
	//$query = 'SELECT * FROM `news_detail` where `lang`= "'.$current_lang.'"'.$con.' ORDER BY RAND(), id desc limit 10';
	$database->setQuery($query);
	$articles_category = $database->loadResult();
	
	if($database->getErrorNum()){
		echo $database->stderr();
		return;
	}
?>
<div class="rightbls02">
    <div class="newsbls1"> 
        <?php 
			if($articles_category)
			{
				$other_detail_html = '';
				$i=1;
				foreach($articles_category as $one)
				{
					$link = generate_url_seo('news_detail',array('url'=>$one['url'], 'sub_url'=>$one['sub_url'], 'title_url'=>$one['title_url'])).'.html';
					if($i<5)
					{
						echo '<div class="cdongbls"><a href="'.$link.'">'.$one['title'];
						if($one['icon']=='news.gif')
							echo '<img src="'.SITE_PATH.'themes/images/news.gif" />';
						else 
						{
							$icon = get_icon($one, 'small', 'news');
							if($icon)
								echo '<img src="'.$icon.'" />';
						}
						echo '</a>';
						$image = get_image($one, 'small', 'news');
						if($image)
							echo '<img class="img" src="'.$image.'" />';
						//echo '<div class="news_content">'.$image_src.$one['brief'].' <a href="'.$link.'"><img src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a></div>';
						echo '<div style="float:left;" class="news_content">'.$image_src.$one['brief'].' <a href="'.$link.'"><img src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a></div>';
						echo '<div style="clear:both"></div>';
					}
					else
					{
						$other_detail_html .= '<li><a href="'.$link.'">'.string_strip($one['title']).'</a></li>';
					}
					$i++;
				}
				
			
				/*if($itemPerPage < $totalRows)
				{
					$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
					echo '<div class="pagging" style="text-align:center; padding-top:10px; clear:both">'.$pagging.'</div>';
				}*/
			}
		?>
     </div>
<?php 
	if($other_detail_html)
	{
?>     
     <div class="otherblocks">
        <div class="tinkhac">Các tin liên quan</div>
        <ul class="newsother">
            <?php echo $other_detail_html; ?>
        </ul>
    </div>
<?php 
	}
?>   
</div>