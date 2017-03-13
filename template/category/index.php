<div class="rightbls02">
	<div class="newslist">
<?php
	global $database;
	global $current_lang;
	$url1 = getParam(1, 'str');
		$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" AND url = "'.$url1.'" AND publish =2 ORDER BY region, id DESC';
		$database->setQuery($query);
		$c_row = $database->loadRow();
		if($c_row)
		{
?>        
        <div class="title"><?php echo $c_row['title'] ?></div>
        <div class="content"><?php echo $c_row['content'];?>  
        </div>
        <div class="sharebl2">
            <a href="<?php echo generate_url('about_us_print', array('id'=>$row['id'])) ?>" class="print">Print</a>
            <a href="http://www.facebook.com/share.php?u=<?php echo generate_url('about_us', array('id'=>$row['id'])) ?>&t=<?php echo $row['title'] ?>" class="faceb1">Facebook</a>
            <a href="http://twitter.com/share?url=<?php echo generate_url('about_us', array('id'=>$row['id'])) ?>&text=<?php echo $row['title'] ?>" class="twitter1">Twitter</a>
            <a href="mailto:?subject=<?php echo $row['title'] ?>" class="email1">Email</a>
            <a href="javascript:bookmarksite('<?php echo $row['title'] ?>', '<?php echo generate_url('about_us', array('id'=>$row['id'])) ?>')" class="add">Bookmarks</a>
        </div>
<?php 
		}
?>        
    </div>
</div>