<?php 
	global $current_lang;
	if($current_lang=='vietnam')
	{
		$lang = 'english';
		$langguage = 'English';
	}
	else
	{
		$lang = 'vietnam';
		$langguage = 'Tiếng việt';
	}
?>
<div class="top_right_menu">
    <ul>
        <li style="background:url(themes/images/flag_vn.gif) top center no-repeat;"><a href="?lang=<?php echo $lang; ?>"><?php echo $langguage; ?></a></li>
        <li style="background:url(themes/images/login_icon.gif) top center no-repeat;"><a href="http://mail.evnfc.vn" target="_blank"><?php echo _EMAIL ?></a></li>
        <li style="background:url(themes/images/sitemap_icon.gif) top center no-repeat;"><a href="<?php echo generate_url_seo('sitemap', array('sitemap'=>'sitemap.html')) ?>">Site map</a></li>
        <li style="background:url(themes/images/home_icon.gif) top center no-repeat;"><a href="<?php echo generate_url_seo('home') ?>"><?php echo _HOME ?></a></li>
    </ul>
</div>