<?php
	global $database;
	global $current_lang;
	$query = 'SELECT * FROM `products_services_detail` WHERE  url="'.getParam(1, 'str').'" AND title_url="'.getParam(4, 'str').'" AND publish=2 ORDER BY region, id DESC';
	$database->setQuery($query);
	$row = $database->loadRow();
	if($database->getErrorNum()){
		echo $database->stderr();
		return;
	}
	$query = 'SELECT * FROM `products_services_detail` WHERE lang="'.$current_lang.'" and id<>"'.$row['id'].'" and url="'.getParam(1, 'str').'" AND sub_url="'.getParam(3, 'str').'" AND publish=2 order by region, id DESC';
	$database->setQuery($query);
	$other_product = $database->loadResult();
	$other_product_html = '';
	if($other_product)
		foreach($other_product as $one)
		{
			$other_product_html .= '<li><a href="'.generate_url_seo('products_services_detail',  array ('url'=>getParam(1, 'str'), 'parent_url'=>getParam(2, 'str'), 'sub_url'=>getParam(3, 'str'), 'title_url'=>$one['title_url'])).'.html">'.string_strip($one['title']).'</a></li>';
		}
?>

<div class="rightbls02">
        
<div class="newslist">
        <div class="title">
             <?php echo $row['title'] ?>
        </div>
        <div class="content">
            	<?php 
					//$image = get_image($row, 'small', 'products_services_detail');
//					if($image)
//						echo '<div class="img2"><img class="img" src="'.$image.'" /><!-- <span>Ảnh minh hoạ (Nguồn: internet)</span>--> </div>';
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
    
    <div class="otherblocks">                    
        <div class="tinkhac"><?php echo _RELATED_PRODUCTS ?></div>
        <ul class="newsother">
            <?php echo $other_product_html ?>
        </ul>
    </div>
    
</div>