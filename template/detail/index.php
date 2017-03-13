<?php
	global $database;
	global $current_lang;
	$title_url = getParam(2, 'str');
	$url = getParam(1, 'str');
	if($title_url)
		$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" AND title_url="'.$title_url.'" AND url="'.$url.'"';
	else
		$query = 'SELECT * FROM `detail` WHERE  lang="'.$current_lang.'"  AND url="'.$url.'" ORDER BY region, id DESC limit 0,1';
	$database->setQuery($query);
	$row = $database->loadRow();
	if($database->getErrorNum()){
		echo $database->stderr();
		return;
	}
	/*$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" and id<>"'.$row['id'].'" AND url="'.$url.'"';
	$database->setQuery($query);
	$other_detail = $database->loadResult();
	$other_detail_html = '';
	if($other_detail)
		foreach($other_detail as $one)
		{
			$other_detail_html .= '<li><a href="'.generate_url_seo('detail', array ('url'=>$one['url'], 'title_url'=>$one['title_url'])).'.html'.'">'.string_strip($one['title']).'</a></li>';
		}*/
?>
<div class="rightbls02">
	<div class="newslist">
        <div class="title">
             <?php echo $row['title'] ?>
        </div>
        <div class="content">
            	<?php 
					$image = get_image($one, 'large', 'news');
					if($image)
						echo '<div class="img2"><img class="img" src="'.$image.'" /><!-- <span>Ảnh minh hoạ (Nguồn: internet)</span>--> </div>';
					 echo string_strip($row['content']);
				?>   
                <div class="author"><?php echo $row['source'] ?></div>
        </div>
        <div class="sharebl2">
            <a href="<?php echo generate_url('product_print', array('id'=>$row['id'])) ?>" class="print">Print</a>
            <a href="http://www.facebook.com/share.php?u=<?php echo generate_url('product_detail', array('id'=>$row['id'])) ?>&t=<?php echo $row['title'] ?>" class="faceb1">Facebook</a>
            <a href="http://twitter.com/share?url=<?php echo generate_url('product_detail', array('id'=>$row['id'])) ?>&text=<?php echo $row['title'] ?>" class="twitter1">Twitter</a>
            <a href="mailto:?subject=<?php echo $row['title'] ?>" class="email1">Email</a>
            <a href="javascript:bookmarksite('<?php echo $row['title'] ?>', '<?php echo generate_url('product_detail', array('id'=>$row['id'])) ?>')" class="add">Bookmarks</a>
        </div>
    </div>
   <!-- <div class="otherblocks">                    
        <div class="tinkhac">Các tin liên quan</div>
        <ul class="newsother">
            <?php //echo $other_detail_html ?>
        </ul>
    </div>-->
</div>