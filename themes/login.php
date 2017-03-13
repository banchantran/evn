<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo SITE_PATH;?>themes/style.css" rel="stylesheet" type="text/css" />
<title>ACS Corp</title>
</head>
<body>
	<div id="wrapper">
    	<div id="header">
        	<strong class="logo"><a href="#">ACS Corp</a></strong>
            <strong class="slogan">
				<span class="cufon-alt"><?php require_once ROOT_PATH.'template/slogan/index.php';?></span>
            </strong>
            <?php require_once ROOT_PATH.'template/menu/menu_mid.php';?>
		</div>
<!--Phan nay hien thi noi dung trang trong -->   
<div id="content-holder">				
    <div id="content" style="min-height:400px;">
        <?php echo get_region_content(); ?>
</div>       
<!--Phan nay hien thi noi dung trang trong -->       
        <div id="footer"><ul><li><a href="#"><span>IP camera system</span></a></li><li><a href="#"><span>Analog camera system</span></a></li><li><a href="#"><span>Video Analysis System</span></a></li><li><a href="#"><span>Solutions by industry</span></a></li><li><a href="#"><span>Site Map</span></a></li></ul></div>
	</div>
</body>
</html>