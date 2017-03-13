<?php global $current_lang;?>
<div class="banner">
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="728" height="200" id="tech" align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="<?php echo SITE_PATH ?>myalbum.swf?xml_path=<?php echo SITE_PATH ?>imgage_<?php echo $current_lang ?>.xml" />
        <param name="quality" value="high" />
        <param name="wmode" value="transparent" />
        <embed src="<?php echo SITE_PATH ?>myalbum.swf?xml_path=<?php echo SITE_PATH ?>imgage_<?php echo $current_lang ?>.xml" quality="high" wmode="transparent" width="728" height="200" name="tech" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />        
    </object>
</div>