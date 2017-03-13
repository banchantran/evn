<?php 
	global $database;
	global $current_lang;	
	$query = 'SELECT * FROM `adv` WHERE lang="'.$current_lang.'" AND publish=2 AND position=2 ORDER BY region';
	$database->setQuery($query);
	$row = $database->loadRow();
	$image_file = get_image($row, 'large', 'adv');
	if($image_file)											
	{
		if($row['link'])
			$link = $row['link'];
		else
			$link = generate_url('adv', array('id'=>$row['id']));
		list($width, $height) = getimagesize($image_file);

?>
<div id="divPage" align="center">
        <div style="z-index: 100; position: absolute; left: 137px; top: 59px;" id="ADV_OverTop">
          <table width="<?php echo $width + 30 ?>" align="left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="1">
            <tbody>
              <tr>
                <td style="padding: 5px;" align="left">
                  <b>
                  <a class="close_div"></a>
                  <font style="font-size: 14pt;" color="#3229C9">
                  <span class="close_div" onClick="ADV_OverTopArea.HideAllProtect();">[ X ] 
                </span></font></b></td>
			  </tr>
              <tr>
	              <td bgcolor="#ffffff" align="center">
	               <a href="<?php echo $link ?>" style="text-decoration: none;"><?php echo '<img src="'.$image_file.'" />'; ?></a>
		      	 </td></tr>
            <input value="" id="cover_url" type="hidden">
            <tr>
              <td style="padding: 5px;" align="center">
                <font face="Arial">            </font><p align="right"><font face="Arial">       
                <script>
						document.getElementById('cover_url').value=document.getElementById('url_root').href;
						
				   </script> 
              <!--<b>&gt;&gt;&gt;&nbsp;<a href="<?php echo $link ?>" style="text-decoration: none;"><font color="#ffff00">Bấm vào đây để xem chi tiết chương trình</font> </a>&gt;&gt;&gt;</b></font></p>--></td>
		    </tr>
            </tbody>
          </table>
		  </div>
	    <script language="javascript" type="text/javascript" src="<?php echo SITE_PATH;?>themes/adv_cover_top.js"></script>
        <script>
			ADV_OverTopArea.writeComponent();
		</script>
		<div style="display: none; position: absolute; left: 0px; top: -50px; background-color: rgb(0, 0, 0); opacity: 0.8; width: 1008px; height: 1526px;" id="ADV_OverTop_Background"></div><div id="ADV_OverTop"></div>
</div>
<?php 
	}
?>