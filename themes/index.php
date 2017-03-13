<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> EVN Finance </title>
<link rel="shortcut icon" href="<?php echo SITE_PATH;?>themes/images/icon.ico" />
<link rel="stylesheet" href="<?php echo SITE_PATH;?>themes/images/evncss.css" type="text/css" />
<!--Tabs-->
<script src="<?php echo SITE_PATH;?>themes/tabs/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
<script src="<?php echo SITE_PATH;?>themes/tabs/jquery.history_remote.pack.js" type="text/javascript"></script>
<script src="<?php echo SITE_PATH;?>themes/tabs/jquery.tabs.pack.js" type="text/javascript"></script>
<script src="<?php echo SITE_PATH;?>themes/tabs/tabs.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo SITE_PATH;?>themes/tabs/jquery.tabs.css" type="text/css" media="print, projection, screen">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH;?>themes/topmn/pro_dropdown_2.css" />
<script src="<?php echo SITE_PATH;?>themes/topmn/stuHover.js" type="text/javascript"></script>
<!--Tabs-->
</head>
<body>
<!--Top Blocks-->
<center>
	<div id="top">
    	<div class="top" align="center">
            <div class="logo">
                <div class="logoimg"><a href="<?php echo generate_url('home'); ?>"><img src="<?php echo SITE_PATH;?>themes/images/logo.jpg" /></a></div>
                <div style="height:40px;">
                    <?php require_once ROOT_PATH.'template/menu/menu_top.php';?>
                    <?php require_once ROOT_PATH.'template/search/index.php';?>
                </div>
            </div>
        </div>

        <!--  Menu top Start -->
        	<?php require_once ROOT_PATH.'template/menu/menu_mid.php';?>
        <div class="clear"></div>
    </div>
</center>
<!--Top Blocks END-->

<!-- Center Blocks -->
<center>
	<div id="centerct">
    	<!-- Left block -->
    	<div class="leftbls">
            <?php require_once ROOT_PATH.'template/banner/index.php';?>
            <?php require_once ROOT_PATH.'template/products_services/home.php';?>
        </div>
        <!-- Left block END -->
        <!-- Right block -->
    	<div class="rightbls">
            <?php require_once ROOT_PATH.'template/news/right.php';?>
        	<?php require_once ROOT_PATH.'template/other/thongtinbotro.php';?>
        </div>
        <!-- Right block END -->
        <div class="clear"></div>
    </div>
</center>
<!-- Center Blocks END -->
<center>
<div id="footer">
    <?php require_once ROOT_PATH.'template/footer/index.php';?>
    <div class="counter">
        <div class="ft3">
           <?php require_once ROOT_PATH.'template/links/index.php';?>
          <div class="ft2"><a href=""><?php echo _BOOK_MARK ?></a></div>
            <div class="clear"></div>
        </div>
        	<?php require_once ROOT_PATH.'template/counter/index.php';?>
    </div>
    <div class="clear"></div>
</div>
</center>
</body>
</html>
