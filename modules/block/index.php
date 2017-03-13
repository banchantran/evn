<div><h1><?php echo _BLOCK_ADMIN; ?></h1></div>
<!--<div><h4><a href="<?php echo generate_url('footer_admin');?>"><?php echo _FOOTER_ADMIN;?></a></h4></div>
<div><h4><a href="<?php echo generate_url('link_admin');?>"><?php echo _LINK_ADMIN;?></a></h4></div>
<div><h4><a href="<?php echo generate_url('contact_info_admin');?>"><?php echo _CONTACT_INFO_ADMIN;?></a></h4></div>
<div><h4><a href="<?php echo generate_url('banner_mid_admin');?>"><?php echo _BANNER_MID_ADMIN;?></a></h4></div>
<div><h4><a href="<?php echo generate_url('adv_admin');?>"><?php echo _ADV_ADMIN;?></a></h4></div>
<div><h4><a href="<?php echo generate_url('slogan_admin');?>"><?php echo _SLOGAN.' '._ADMIN;?></a></h4></div>
-->
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo SITE_PATH;?>themes/admin/css/template_css.css" />
<table class="adminform">
    <tbody>
        <tr>
            <td valign="top" width="100%">
                <div id="cpanel">
                    <?php
                        //if(is_admin())
                        if(is_content_management())
                        {
							echo '
                    <div style="float: left;">
                        <div class="icon">
                            <a href="'.generate_url('footer_admin').'">
                                <img src="'.SITE_PATH.'themes/admin/images/profile.png" alt="'._FOOTER_ADMIN.'" align="middle" border="0">
                                <span>'._FOOTER_ADMIN.'</span>
                            </a>
                        </div>
                    </div>';
							echo '
                    <div style="float: left;">
                        <div class="icon">
                            <a href="'.generate_url('link_admin').'">
                                <img src="'.SITE_PATH.'themes/admin/images/user_002.png" alt="'._LINK_ADMIN.'" align="middle" border="0">
                                <span>'._LINK_ADMIN.'</span>
                            </a>
                        </div>
                    </div>';
							echo '
                    <div style="float: left;">
                        <div class="icon">
                            <a href="'.generate_url('contact_info_admin').'">
                                <img src="'.SITE_PATH.'themes/admin/images/contact_info_admin.png" alt="'._CONTACT_INFO_ADMIN.'" align="middle" border="0">
                                <span>'._CONTACT_INFO_ADMIN.'</span>
                            </a>
                        </div>
                    </div>';
                            echo '
                    <div style="float: left;">
                        <div class="icon">
                            <a href="'.generate_url('banner_mid_admin').'">
                                <img src="'.SITE_PATH.'themes/admin/images/about_us_admin.png" alt="'._BANNER_MID_ADMIN.'" align="middle" border="0">
                                <span>'._BANNER_MID_ADMIN.'</span>
                            </a>
                        </div>
                    </div>';
                    		echo '
                    <div style="float: left;">
                        <div class="icon">
                            <a href="'.generate_url('adv_admin').'">
                                <img src="'.SITE_PATH.'themes/admin/images/home_admin.png" alt="'._ADV_ADMIN.'" align="middle" border="0">
                                <span>'._ADV_ADMIN.'</span>
                            </a>
                        </div>
                    </div>';
							
	                   }
                    ?>				
                    <div style="clear: both;"></div>
                </div>
            </td>
        </tr>
    </tbody>
</table>