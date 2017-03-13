<ul class="box">
<?php 
		global $database;
		global $current_lang;
		$md = getParam('module', 'str');
		$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" ORDER BY region, id DESC';
		$database->setQuery($query);
		$category_admin = $database->loadResult();
		if($category_admin)
		foreach ($category_admin as $cone)
		{		
			if($cone['type']==2)
			{							
				echo '<li><strong style="margin-left: 5px"><a href="'.generate_url('detail_admin', array('url'=>urlSeo( $cone['title']))).'">'.$cone['title'].'</a></strong></li>';
				
				$query = 'SELECT * FROM `detail` WHERE lang="'.$current_lang.'" AND url = "'.$cone['url'].'" ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				foreach ($mrows as $mone)
					echo '<li><a href="'.generate_url('detail_admin', array('url'=>$mone['url'], 'task'=>'edit', 'id'=>$mone['id'])).'">&nbsp;&laquo;&nbsp;'.$mone['title'].'</a></li>';
			}
			if($cone['type']==3)
			{
				echo '<li><strong style="margin-left: 5px"><a href="'.generate_url('articles_category_admin', array('url'=>$cone['url'])).'">'.$cone['title'].'</a></strong></li>';
				$query = 'SELECT * FROM `articles_category` WHERE lang="'.$current_lang.'" AND url = "'.$cone['url'].'" ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				foreach ($mrows as $mone)
					echo '<li><a href="'.generate_url('articles_category_admin', array('url'=>$mone['url'], 'task'=>'edit', 'id'=>$mone['id'])).'">&nbsp;&laquo;&nbsp;'.$mone['title'].'</a></li>';
			}
			if($cone['type']==4)
			{
				echo '<li><strong style="margin-left: 5px"><a href="'.generate_url('news_category_admin', array('url'=>$cone['url'])).'">'.$cone['title'].'</a></strong></li>';
				$query = 'SELECT * FROM `news_category` WHERE lang="'.$current_lang.'" AND url = "'.$cone['url'].'" ORDER BY region, id DESC';
				$database->setQuery($query);
				$mrows = $database->loadResult();
				if($mrows)
				foreach ($mrows as $mone)
					echo '<li><a href="'.generate_url('news_admin', array('url'=>$mone['url'], 'sub_url'=>$mone['title_url'])).'">&nbsp;&laquo;&nbsp;'.$mone['title'].'</a></li>';
			}
			if($cone['type']==5)
			{
				echo '<li><strong style="margin-left: 5px"><a href="'.generate_url('contact_admin', array('url'=>$cone['url'])).'">'.$cone['title'].'</a></strong></li>';
			}
			if($cone['type']==7)
			{
				echo '<li><strong style="margin-left: 5px"><a href="'.generate_url('products_services_admin', array('url'=>$cone['url'])).'">'.$cone['title'].'</a></strong></li>';
			}
		}	
?>