<?php
	global $current_lang;
	$action = getParam("action", 'str');
	if($action == "send_contact")
	{
		$fullname = getParam('fullname');
		$address = getParam('address');
		$email = getParam('email');
		$phone = getParam('phone');
		$content = getParam('content', 'def');
		$time_create = time();
		$is_valid = 1;
		if(!$fullname)
		{
			$fullname_error = '<br /><font color=RED>'._REQUIRED_FILED.'</font>';
			$is_valid = 0;
		}
		if(!$email)
		{
			$email_error = '<br /><font color=RED>'._REQUIRED_FILED.'</font>';
			$is_valid = 0;
		}
		if(!$content)
		{
			$content_error = '<br /><font color=RED>'._REQUIRED_FILED.'</font>';
			$is_valid = 0;
		}
		if($is_valid)
		{
			global $database;
			$query = "INSERT INTO contact_us (`fullname`, `address`, `email`, `phone`, `content`, `time_create`, `status`)
				 VALUES('$fullname', '$address', '$email', '$phone', '$content', '$time_create', '1')";
			$database->setQuery($query);
			$database->query();
			echo '
				<script>
					alert("'._THANK_FOR_CONTACT.'");
					window.location = "'.generate_url_seo('contact_us', array ('url'=>getParam(1, 'str'))).'.html'.'";
				</script>
			';
		}
	}
?>
<div class="rightbls02">
	<div class="newslist" align="left">
	<div>
    	<?php
			global $current_lang;
			$file_name= DATA_PATH.'html/contact_info/contact_info_'.$current_lang.'.html';
			echo get_file_content($file_name);
		?>
    </div>
    <table cellspacing="0" cellpadding="0">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td valign="top" align="left">          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                 <form name="FormContactUs" method="post">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                      <td width="20%" align="left" valign="top"><?php echo _FULL_NAME;?> <font color="#FF0000">(*)</font>:</td>
                        <td align="left" valign="top">
                            <input name="fullname" value="<?php echo getParam('fullname', 'str');?>" type="text" size="30" class="input_box" />&nbsp;<?php echo $fullname_error;?>                                      </td>
                      </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                      <td align="left" valign="top"><?php echo _ADDRESS;?>:</td>
                        <td align="left" valign="top">
                            <input name="address" value="<?php echo getParam('address', 'str');?>" type="text" size="30" class="input_box" />                                      </td>
                      </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                      <td align="left" valign="top"><?php echo _EMAIL;?> <font color="#FF0000">(*)</font>:</td>
                        <td align="left" valign="top">
                            <input name="email" value="<?php echo getParam('email', 'str');?>" type="text" size="30" class="input_box"  />&nbsp;<?php echo $email_error;?>                                      </td>
                      </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                      <td align="left" valign="top"><?php echo _PHONE;?>:</td>
                        <td align="left" valign="top"><input name="phone" value="<?php echo getParam('phone', 'str');?>" type="text" size="30" class="input_box" /></td>
                      </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                      <td align="left" valign="middle"><?php echo _CONTENT;?> <font color="#FF0000">(*)</font>:</td>
                        <td align="left" valign="top">
                            <textarea id="content" name="content" style="width:300px; height:100px;"><?php echo getParam('content', 'str');?></textarea><br /><?php echo $content_error;?>                                      </td>
                      </tr>
                    <tr><td colspan="2" height="4px;"></td></tr>
                    <tr>
                      <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><input type="submit" value="<?php echo _SEND_CONTACT;?>" /></td>
                      </tr>
                    </table>
                      <input type="hidden" name="action" value="send_contact" />
                </form>                </td>
              </tr>
          </table></td></tr>
</table>
	</div>
 </div>