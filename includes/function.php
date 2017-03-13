<?php
function menu_option(){ 
			global $current_lang;
			global $database;
			$query = 'SELECT * FROM `menu` WHERE lang="'.$current_lang.'"  AND publish="2"';
					$database->setQuery($query);
					$all = $database->loadResult();
					if($all)
					{
						$menu_id[0] = 'Top Menu';
						foreach($all as $one)
						{
							$menu_id[$one['id']] = $one['title'];
						}
					}			
					echo get_option($menu_id, getParam('menu_id', 'int', $one['menu_id']));		
				return $menu_id;
}

function nav_option(){ 
			global $current_lang;
			global $database;
			$query = 'SELECT * FROM `category` WHERE lang="'.$current_lang.'"  AND publish="2"';
					$database->setQuery($query);
					$all = $database->loadResult();
					if($all)
					{
						foreach($all as $one)
						{
							$nav_id[$one['id']] = $one['title'];
						}
					}					
				return $nav_id;
}

function module_option(){ 
			global $current_lang;
			global $database;
			$query = 'SELECT * FROM `module_manager` WHERE lang="'.$current_lang.'"  AND publish="2"';
					$database->setQuery($query);
					$all = $database->loadResult();
					if($all)
					{
						foreach($all as $one)
						{
							$module_id[$one['id']] = $one['title'];
						}
					}
					echo get_option($module_id, getParam('module_id', 'int', $one['module_id']));
				return 1;
}

function module_type($m_url)
{
			global $current_lang;
			global $database;
			$query = 'SELECT type FROM `module_manager` WHERE lang="'.$current_lang.'"  AND data_name = "'.$m_url.'"';
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['type'];
}

function category_type($c_url)
{
			global $current_lang;
			global $database;
			$query = 'SELECT type FROM `category` WHERE lang="'.$current_lang.'"  AND title_seo = "'.$c_url.'"';
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['type'];
}

function module_id($c_url)
{
			global $current_lang;
			global $database;
			$query = 'SELECT id FROM `category` WHERE lang="'.$current_lang.'"  AND title_seo = "'.$c_url.'"';
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['id'];
}


function module_mid($c_url)
{
			global $current_lang;
			global $database;
			$query = 'SELECT id FROM `module_manager` WHERE lang="'.$current_lang.'"  AND data_name = "'.$c_url.'"';
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['id'];
}

function get_mid($m_url)
{
			global $current_lang;
			global $database;
			$query = 'SELECT id FROM `module_manager` WHERE lang="'.$current_lang.'"  AND data_name = "'.$m_url.'"';
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['id'];
}

function module_title($uid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `module_manager` WHERE lang="'.$current_lang.'"  AND id='.$uid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['title'];
}

function articles_url($aid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `articles` WHERE lang="'.$current_lang.'"  AND id='.$aid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return urlSeo($one['title']);
}

function module_url($mid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `module_manager` WHERE lang="'.$current_lang.'"  AND id='.$mid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return urlSeo($one['title']);
}

function nav_url($cid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `category` WHERE lang="'.$current_lang.'"  AND id='.$cid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return urlSeo($one['title']);
}

function product_url($pid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `product` WHERE lang="'.$current_lang.'"  AND id='.$pid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return urlSeo($one['title']);
}

function topic_url($tid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT title FROM `topic` WHERE lang="'.$current_lang.'"  AND id='.$tid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return urlSeo($one['title']);
}

function check_permission($mid)
{
			global $current_lang;
			global $database;
			$uid = $_SESSION['user']['id'];
			if($uid ==1) return true;
			else{
			$query = 'SELECT * FROM `permission` WHERE uid='.$uid.' AND mid='.$mid;
					$database->setQuery($query);
					$one = $database->loadRow();
			if($one)
			return true;
			else 
			return false;
	}
}

function user_d($uid)
{
			global $current_lang;
			global $database;
			$query = 'SELECT * FROM `user` WHERE id='.$uid;
					$database->setQuery($query);
					$one = $database->loadRow();
			return 'User: '.$one['full_name'].' - '._USER_NAME.': '.$one['user_name'];
}

function category_description()
{
			global $current_lang;
			global $database;
			$con = ' AND title_seo = "'.getParam(1, 'str').'"';
			$query = 'SELECT title, description FROM `category` WHERE lang="'.$current_lang.'"'.$con;
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['title'].' - '.get_word(unhtmlspecialchars(removeHTML($one['description'])));
}

function category_title()
{
			global $current_lang;
			global $database;
			$con = ' AND title_seo = "'.getParam(1, 'str').'"';
			$query = 'SELECT title FROM `category` WHERE lang="'.$current_lang.'"'.$con;
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['title'];
}

function product_title()
{
			global $current_lang;
			global $database;
			if(getParam(3, 'int'))
			$con = ' AND id = "'.getParam(3, 'int').'"';
			else
			$con = ' AND mid = "'.module_mid(getParam(2, 'str')).'"';
			$query = 'SELECT title FROM `product` WHERE lang="'.$current_lang.'"'.$con;
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['title'];
}

function product_description()
{
			global $current_lang;
			global $database;
			if(getParam(3, 'int'))
			$con = ' AND id = "'.getParam(3, 'str').'"';
			else
			$con = ' AND mid = "'.module_mid(getParam(2, 'str')).'"';
			$query = 'SELECT title, content FROM `product` WHERE lang="'.$current_lang.'"'.$con;
					$database->setQuery($query);
					$one = $database->loadRow();
			return $one['title'].' '.get_word(unhtmlspecialchars(removeHTML($one['content'])));
}

?>