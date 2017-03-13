<?php
		global $database;
		global $current_lang;
		$mid = getParam('mid', 'int', 0);
			$query = 'SELECT * FROM `module_manager` WHERE lang="'.$current_lang.'" AND id='.$mid.'  AND publish="2" ORDER BY region';
					$database->setQuery($query);
					$one = $database->loadRow();
		if($one)
		echo 'Module: <strong>'.$one['title'].'</strong>';

?>
...
<?php
		global $database;
		global $current_lang;
		$cid = getParam('cid', 'int', 0);
			$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'" AND id='.$cid.'  AND publish="2" ORDER BY region';
					$database->setQuery($query);
					$one = $database->loadRow();
		if($one)
		echo _CATEGORY.': <strong>'.$one['title'].'</strong>';

?>