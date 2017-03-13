<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Website admin</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/reset.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/main.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/2col.css" title="2col" />
<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/1col.css" title="1col" />
<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="<?php echo SITE_PATH;?>themes/admin/text/css" href="css/main-ie6.css" /><![endif]-->
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/style2.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/mystyle.css" />
<link rel="stylesheet" href="<?php echo SITE_PATH;?>themes/admin/css/admin.css" type="text/css">
<script language="JavaScript" src="<?php echo SITE_PATH;?>themes/admin/js/milonic_src.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo SITE_PATH;?>themes/admin/js/mmenudom.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SITE_PATH;?>themes/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_PATH;?>themes/admin/js/switcher.js"></script>
<script type="text/javascript" src="<?php echo SITE_PATH;?>themes/admin/js/toggle.js"></script>
<script type="text/javascript" src="<?php echo SITE_PATH;?>themes/admin/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo SITE_PATH;?>themes/admin/js/ui.tabs.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	</script>
</head>
<body>
<div id="main">
  <!-- Tray -->
  <div id="tray" class="box">
  <p align="left">
  <?php 
  require_once ROOT_PATH.'themes/admin/current.php';
  ?> 
  </p>
    <p class="f-left box"> 
	  <span class="f-left" id="switcher"> <a href="javascript:void(0);" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="<?php echo SITE_PATH;?>themes/admin/design/switcher-1col.gif" alt="1 Column" /></a> <a href="javascript:void(0)" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="<?php echo SITE_PATH;?>themes/admin/design/switcher-2col.gif" alt="" /></a> </span></p>
    <p class="f-right">
	      <?php
	global $current_lang;
	if ($current_lang=='vietnam')
	{
	echo '<a href="'.generate_url_all(array('lang'), 'lang=english').'"><strong>English</strong></a>';
	}
	else
	echo '<a href="'.generate_url_all(array('lang'), 'lang=vietnam').'"><strong>Vietnamese</strong></a>';
	?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<?php echo _USER_NAME; ?>: <strong><a href="<?php echo generate_url('profile'); ?>"><?php echo $_SESSION['user']['full_name']; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="<?php echo generate_url('sign_out');?>" id="logout"><?php echo _LOGOUT;?></a></strong></p>
  </div>
  <!--  /tray -->
  <hr class="noscreen" />
  <!-- Menu -->
  <div id="menu" class="box">
    <ul class="box f-right">
      <li><a href="<?php echo generate_url('home');?>"><span><strong><?php echo _HOME;?></strong></span></a></li>
    </ul>
<?php require_once ROOT_PATH.'themes/admin/menu_admin.php';?> 
  </div>
  <hr class="noscreen" />
  <div id="cols" class="box">
    <div id="aside" class="box">
      	<div class="padding box">
			<h2><strong><?php echo _WEBSITE_ADMIN;?></strong></h2>
      	</div>
     		<?php require_once ROOT_PATH.'themes/admin/left.php';?> 
    	</div>
    <hr class="noscreen" />
		<div id="content" class="box" style="min-height:400px">
			<?php get_region_content();?>
		</div>
  	</div>
  <hr class="noscreen" />
  <div id="footer" class="box">
    <p class="f-left">Copyright &copy; 2010 <a href="http://www.acs.vn/" target="_blank">ACS Corp</a>, All Rights Reserved &reg;</p>
  </div>
</div>
</body>
</html>
