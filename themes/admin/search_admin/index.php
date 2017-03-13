<?php
	global $database;
	global $current_lang;
	$title = getParam('title', 'int');
	$mid = getParam ('mid', 'int');
	$category = getParam('category', 'int');
	$key_search = urldecode(getParam('key'));	
	$condition = ' and (`title` like "%'.$key_search.'%" or `content` like "%'.$key_search.'%") ';	
	if($mid)
	$condition .= ' and `mid` = '.$mid;
	$query = 'SELECT * FROM `articles` where `lang`= "'.$current_lang.'" '.$condition.' AND publish=2 ORDER BY region';
	$database->setQuery($query);
	$all = $database->loadResult();

	if($all)
	{
			foreach($all as $one)
        	echo '<div><a href="'.generate_url('articles_admin', array('mid'=>$one['mid'], 'cid'=>$one['cid'], 'id'=>$one['id'])).'">'.hightlight_keyword($one['title'], $key_search).'</a>'.hightlight_keyword($one['content'], $key_search).'</div>';
	}
	if($category)
	$condition = ' and (`title` like "%'.$key_search.'%") ';	
	$query = 'SELECT * FROM `category` where `lang`= "'.$current_lang.'" '.$condition.' AND publish=2 ORDER BY region';
	$database->setQuery($query);
	$all = $database->loadResult();
	if($all)
	{
			foreach($all as $one)
        	echo '<div><a href="'.generate_url('categoy_admin', array('mid'=>$one['mid'], 'id'=>$one['id'])).'">'.hightlight_keyword($one['title'], $key_search).'</a>'.hightlight_keyword($one['content'], $key_search).'</div>';
	}
?>
</div>