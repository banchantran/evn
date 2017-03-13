<?php	
	session_start(1);
	header("Content-Type: text/html; charset=utf-8");
	if($_SERVER['HTTP_HOST'] != 'evn.dev')
		echo '<script>window.location = "http://evn.dev";</script>';
	define('ROOT_PATH', '');
	define('DATA_PATH', 'data/');
	define('DATA_PATH_ADMIN', 'data/');
	define('DATA_PATH1', 'http://evn.dev/data/');
	
	define('SITE_PATH', 'http://evn.dev/');
	define('SITE_PATH_SEO', 'http://evn.dev');
	define('PUBLISH_PATH', 'http://evn.dev/');
	define('HTTPHOST', 'http://evn.dev/');
	define('USE_SEO', 1);
	
	if(USE_SEO)
	{
		global $url_array;
		$url_array =  split('/', $_SERVER['REQUEST_URI']);
	}
	global $current_lang;
	$current_lang = 'vietnam';
	
	if(!empty($url_array['lang']))
	{
		$_REQUEST['lang'] = $url_array['lang'];
	}
	elseif(!empty($_POST['lang']))
	{
		$_REQUEST['lang'] = $_POST['lang'];
	}
	elseif(!empty( $_GET['lang'] ) )
	{
		$_REQUEST['lang'] = $_GET['lang'];
	}
	elseif(!empty($_SESSION['lang']))
	{
		$_REQUEST['lang'] = $_SESSION['lang'];
	}
	if(isset($_REQUEST['lang']))
	{
		if (!isset($_SESSION['lang']) && ($_REQUEST['lang'] != $current_lang))
		{	 
			$_SESSION['lang'] = $_REQUEST['lang'];
		}
		if(isset($_SESSION['lang']) && ($_REQUEST['lang'] != $_SESSION['lang']))
		{
			$_SESSION['lang'] = $_REQUEST['lang'];
		}
		$current_lang = $_REQUEST['lang'];
	}
	if(!file_exists(ROOT_PATH.'languages/'.$current_lang.'.php'))
		$current_lang = 'english';
	
	include ROOT_PATH.'languages/'.$current_lang.'.php';
	
	if(file_exists(ROOT_PATH."includes/configuration.php"))
		require_once(ROOT_PATH."includes/configuration.php");
	else
	{
		echo _CANNOT_FIND_CONFIGURATION;
		exit();
	}
?>