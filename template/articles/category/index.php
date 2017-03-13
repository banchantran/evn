<?php
	global $database;
	global $current_lang;
	$con = ' AND publish=2 ';
	$url = getParam(1, 'str');
	if($url)
		$con .= ' AND url="'.$url.'" ';

	$sub_url = getParam(2, 'str');
	if($sub_url)
		$con .= ' AND sub_url="'.$sub_url.'" ';
	
	$totalRows = 0;
	$itemPerPage = 5;
	$numPageShow = 10;
	
	$totalRows = $database->getNumRows('articles_detail', ' `lang`= "'.$current_lang.'" '.$con);
	
	$curPg = getParam('curPg', 'int', 1);
	
	$query = 'SELECT * FROM `articles_detail` where `lang`= "'.$current_lang.'"'.$con.'  ORDER BY id desc limit '.(($curPg-1)*$itemPerPage).','.$itemPerPage;
	$database->setQuery($query);
	$articles_category = $database->loadResult();
	
	if($database->getErrorNum()){
		echo $database->stderr();
		return;
	}
?>
<div class="rightbls02">
    <div class="banner"><img src="<?php echo SITE_PATH ?>themes/banner/b10.jpg" /></div>
    <div class="cdongbls1"> 
        <?php 
			if($articles_category)
			{
				foreach($articles_category as $one)
				{
					$link = generate_url_seo('articles_detail',array('url'=>$one['url'], 'sub_url'=>$one['sub_url'], 'title_url'=>$one['title_url'])).'.html';
					echo '<div class="cdongbls"><a href="'.$link.'">'.$one['title'].'</a>';
					echo '<div class="news_content">'.$image_src.$one['brief'].' <a href="'.$link.'"><img src="'.SITE_PATH.'themes/images/more_'.$current_lang.'.jpg" /></a></div>';
					echo '<div style="clear:both"></div></div>';
				}
				
				if($itemPerPage < $totalRows)
				{
					$pagging = paging($totalRows, $itemPerPage, $numPageShow, 'curPg');
					echo '<div class="pagging" style="text-align:center; padding-top:10px; clear:both">'.$pagging.'</div>';
				}
			}
		?>
     </div>
</div>