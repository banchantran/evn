<?php
//	Chuc nang chinh  	: 	Quan tri thong tin lien he

	//Kiem tra quyen
	if(!is_content_management())
		replace_location('home');
	global $database;
	global $current_lang;
	$content ='<div class="products"><div class="products-inner">';
	$query = 'SELECT * FROM `art` WHERE lang="'.$current_lang.'" AND publish =2 ORDER BY region, id DESC limit 0,5';
			$database->setQuery($query);
			$row = $database->loadResult();
			if($row){
				foreach ($row as $one)
				{
				$image_file = get_image($one, 'large', 'art');
                $content .= '<div class="product"><h2><a title="'.$one['title'].'" href="'.$one['source'].'">'.$one['title'].'</a></h2> 
                  <div style="height: 108px;" class="image"><a href="'.$one['source'].'"><img height="108px" src="'.$image_file.'" alt="'.$one['title'].'"></a></div><br /><p style="height: 60px;">'.removeHTML($one['brief']).'&nbsp;<a href="'.$one['source'].'" class="more">'._DETAIL.'</a><br /></p></div>';					
				}
			}

	$content .= '</div></div>';
		$file_name = DATA_PATH_ADMIN.'html/home/cache_'.$current_lang.'.html';
	$action = getParam("action", 'str');
	if($action == "cache")
	{
		create_file($file_name, $content);
		echo '
			<script>
				alert("'._UPDATE_SUCCESS.'!");
				window.location = \''.generate_url('profile').'\';
			</script>';
		exit;
	}
?>
<form name="FormCacheAdmin" method="post">
<script>
	function submitbutton(pressbutton)
	{
		document.FormCacheAdmin.action.value=pressbutton;
		try
		{
			document.FormCacheAdmin.onsubmit();
		}
		catch(e)
		{}
		document.FormCacheAdmin.submit();
	}
</script>
<table class="nostyle"  border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td align="left">
				<a class="toolbar" href="javascript:submitbutton('cache');"><strong>Cache</strong></a>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="action" value="" />
</form>

<a href="<?php echo generate_url('banner_mid_admin');?>"><strong><?php echo _BANNER_MID_ADMIN;?></strong></a>
<div class="banner">
	  <?php require_once ROOT_PATH.'template/banner/index.php';?>
</div>
<br />
<a href="<?php echo generate_url('banner_cennter_admin');?>"><strong><?php echo _BANNER_CENTER_ADMIN;?></strong></a>
<div class="slide">
	<?php require_once ROOT_PATH.'template/banner/home.php';?>	
</div>