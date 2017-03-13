<?php
	$counter = 0;
	$timeout = 600;
	$user_ar=array(
			'ip'		=> 	ipCheck(),
			'timestamp'	=>	time(),
			'session_id'=>	session_id(),
			'ref_url'	=>	isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
			'user_agent'=>	$_SERVER['HTTP_USER_AGENT'],
			'user_name'	=>	'',
			'user_id'	=>	0,
		) ;
	if(isset($_SESSION['user']))
	{
		$user 					= 	$_SESSION['user'];
		$user_ar['user_name']	=	$user['user_name'];
		$user_ar['user_id']		=	$user['id'];
	}
	$counter = @file_get_contents(DATA_PATH.'statistics.txt');
	global $database;
	$database->setQuery('select id from user_online where ip="'.$user_ar['ip'].'" and timestamp >= '.(time()-$timeout));
	$database->query();
	if(!$database->loadRow())
	{
		@file_put_contents(DATA_PATH.'statistics.txt', $counter + 1);
		$counter += 1;
	}
	$database->setQuery("DELETE FROM `user_online` WHERE `timestamp` < '".(time()-600)."' OR `session_id` ='".$user_ar['session_id']."'");
	$database->query();
	$database->insertObject("user_online", $user_ar);
	$user_online = $database->getNumRows('user_online', ' timestamp > '.(time() - $timeout));

?>
<div class="bodem">
    <img src="<?php echo SITE_PATH;?>themes/images/cter1.gif"/> <?php echo _COUNTER ?>: <strong><?php echo $counter ?></strong> <img src="<?php echo SITE_PATH;?>themes/images/icon_account.gif"/>Online: <strong><?php echo $user_online+30; ?></strong>
</div>