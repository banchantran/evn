<div class="menu_footer">
<?php
		global $database;
		global $current_lang;
		$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" and publish = 2 AND position =0 order by region, id';
		$database->setQuery($query);
		$nav_rows = $database->loadResult();
?>
			<?php
			if($nav_rows)
			foreach ($nav_rows as $nav_one)
			echo '<a href="'.generate_url_seo('category', array ('url'=>nav_url($nav_one['id']).'.html')).'">'.$nav_one['title'].'</a>|';
			?>
			<a href="http://acs.vn" target="_blank"><?php echo 'ACS'; ?></a>
</div>