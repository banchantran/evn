<?php
	global $current_lang;
	if($current_lang=='english')
		$banner_file = SITE_PATH.'themes/images/banner_eg.swf';
	else
		$banner_file = SITE_PATH.'themes/images/banner_vn.swf';
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="422" height="49">
	<param name="movie" value="<?php echo $banner_file;?>">
	<param name="quality" value="high">
	<param name="menu" value="false">
	<param name="WMode" value="Transparent">
	<embed src="<?php echo $banner_file;?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="422" height="49" WMode="Transparent"></embed>
</object>