<?php
//	Project            	:  	EPAGE
//	Nguoi tao          	:   GiangNM (01/09/2008)
//	Sua doi            	:   
//	Chuc nang chinh  	: 	Quan tri thong tin lien he

	//Kiem tra quyen
	if(!is_content_management())
		replace_location('sign_in');

	global $current_lang;
	$content = string_strip(getParam("content", 'def'));
	$file_name= DATA_PATH_ADMIN.'html/contact_info/contact_info_'.$current_lang.'.html';
		
	$action = getParam("action", 'str');
	if($action == "save")
	{
		create_file($file_name, $content);
		echo '
			<script>
				alert("'._UPDATE_SUCCESS.'!");
				window.location = \''.generate_url('contact_admin').'\';
			</script>';
		exit;
	}
?>
<form name="FormContactInfoAdmin" method="post">
<script>
	function submitbutton(pressbutton)
	{
		document.FormContactInfoAdmin.action.value=pressbutton;
		try
		{
			document.FormContactInfoAdmin.onsubmit();
		}
		catch(e)
		{}
		document.FormContactInfoAdmin.submit();
	}
</script>
<table class="nostyle" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td align="left"><h2><?php echo _CONTACT_INFO_ADMIN;?></h2></td>
			<td align="right">
				<a class="toolbar" href="javascript:submitbutton('save');">
					<img src="<?php echo SITE_PATH;?>themes/admin/images/save.png" alt="<?php echo _SAVE;?>" name="<?php echo _SAVE;?>" title="<?php echo _SAVE;?>" align="middle" border="0">
				</a>
				<a class="toolbar" href="<?php echo generate_url('contact_admin'); ?>">
					<img src="<?php echo SITE_PATH;?>themes/admin/images/cancel.png" alt="<?php echo _CANCEL;?>" name="<?php echo _CANCEL;?>" title="<?php echo _CANCEL;?>" align="middle" border="0">
				</a>
			</td>
		</tr>
	</tbody>
</table>
<div class="centermain" align="center">
	<div class="main">
		<table class="adminform" width="100%">
			<tbody>
				<tr>
					<th>
						<?php echo _CONTACT_INFO_ADMIN;?>
					</th>
				</tr>
				<tr>
					<td width="100%">
						<?php 
							printEditor(); 
							getEditor('content', get_file_content($file_name), 800, 300);
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<input type="hidden" name="action" value="" />
</form>