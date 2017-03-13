<?php
//	Chuc nang chinh  	: 	Cac ham xu ly he thong
	require_once(ROOT_PATH."includes/function.php");
	
function printEditor(){
  	   require_once ROOT_PATH.'fckeditor/fckeditor.php';
}
function getEditor($strName, $strContent,$width='600',$height='300')
{	
	$ctrl_name = $strName;
	$sBasePath = 'fckeditor/';
	$oFCKeditor = new FCKeditor($ctrl_name) ;
	$oFCKeditor->Height = $height;
	$oFCKeditor->Width = $width;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->Value	 = $strContent;
	$oFCKeditor->Create();
}
function getEditorContent($strContent)
{
	return stripslashes($strContent);
}
function initEditor()
{
	echo '
	<script language="javascript" type="text/javascript"> 	
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "style,layer,table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",
		//theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
		//theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_path_location : "bottom",
		//content_css : "example_full.css",
	   // plugin_insertdate_dateFormat : "%Y-%m-%d",
	   // plugin_insertdate_timeFormat : "%H:%M:%S",
		//extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		//external_link_list_url : "example_link_list.js",
		//external_image_list_url : "example_image_list.js",
		//flash_external_list_url : "example_flash_list.js",
		file_browser_callback : "OpenWinMsg",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true
	});</script>
	';
}

function get_layout_file()
{
	global $block_center;
	global $module;
	global $type_module;
	$module = getParam('module', 'str', '');
	
	if(!$module)
	{		
		global $database;
		global $current_lang;
		$fix_module = getParam(1, 'str', '');
		if($fix_module=='sitemap')
		{
			$module='sitemap';
			
		}
		else
		{
			$query = 'SELECT * FROM `category` WHERE lang = "'.$current_lang.'" AND url="'.getParam(1, 'str').'"';
			$database->setQuery($query);
			$row = $database->loadRow();
			$type_module = $row['type'];
			if($type_module==1) //label]
			{
				//$module = 'label';
			}		
			else if($type_module==2) //detail
			{
				$module = 'detail';
			}
			else if($type_module==3) //articles_category
			{
				if(getParam(3, 'str'))
					$module = 'articles_detail';
				else		
					$module = 'articles_category';
			}
			else if($type_module==4) //news_category
			{
				if(getParam(3, 'str'))
					$module = 'news_detail';
				else if(getParam(2, 'str'))
					$module = 'news_sub_category';			
				else		
					$module = 'news_category';
			}
			else if($type_module==5) //contact
			{
				$module = 'contact_us';
			}
			else if($type_module==7) //products_services
			{	
				if(getParam(4, 'str'))
					$module = 'products_services_detail';
				else if(getParam(3, 'str'))
					$module = 'products_services_cat3';
				else if(getParam(2, 'str'))
					$module = 'products_services_cat2';
				else
					$module = 'products_services_cat1';
			}
			else
			{
				$module = 'home';
			}
		}
	}
	if($module==1)
	{
		global $url_array;
		$module = $url_array[1];
	}
	if(!$block_center[$module])
		$module = 'home';
	if(file_exists(ROOT_PATH.'themes/'.$block_center[$module]['layout']))
		require_once ROOT_PATH.'themes/'.$block_center[$module]['layout'];
}

function get_region_content_seo()
{
	global $block_center;
	global $module;
	
	
	if($module==1)
	{
		global $url_array;
		$module = $url_array[1];
	}
	if(!$block_center[$module])
		$module = 'home';
	
	if($block_center[$module]['module'])
		foreach($block_center[$module]['module'] as $k=>$v)
			require_once ROOT_PATH.$v.'index.php';
	
}

function get_region_content()
{
	global $block_center;
	$module = getParam('module', 'str', 'profile');
	if(!$block_center[$module])
		$module = 'profile';
	if($block_center[$module]['module'])
		foreach($block_center[$module]['module'] as $k=>$v)
			require_once ROOT_PATH.$v.'index.php';
}

function generate_url_seo($module=false, $params=false)
{
	if(USE_SEO)
	{
		$request_string = SITE_PATH_SEO;
		if ($params)
		{
			foreach($params as $param=>$value)
			{
				if(is_numeric($param))
				{
					if(getParam($value))
					{
						$request_string .= '/'.urlencode(getParam($value));
					}
				}
				else
				{
					$request_string .= '/'.urlencode($value);
				}
			}
		}
		return $request_string;
	}
	else
	{
		$request_string = '?module='.$module;
		if ($params)
		{
			foreach($params as $param=>$value)
			{
				if(is_numeric($param))
				{
					if(isset($_REQUEST[$value]))
					{
						$request_string .= '&'.$value.'='.urlencode($_REQUEST[$value]);
					}
				}
				else
				{
					$request_string .= '&'.$param.'='.urlencode($value);
				}
			}
		}
		return $request_string;
	}
}
function generate_url($module='home', $params=false)
{
	$request_string = '?module='.$module;
	if ($params)
	{
		foreach($params as $param=>$value)
		{
			if(is_numeric($param))
			{
				if(isset($_REQUEST[$value]))
				{
					$request_string .= '&'.$value.'='.urlencode($_REQUEST[$value]);
				}
			}
			else
			{
				$request_string .= '&'.$param.'='.urlencode($value);
			}
		}
	}
	return $request_string;
}

function generate_url_all_seo($except=array(), $addition=false)
{
	global $url_array;
	$url='';
	if($url_array)
	{
		foreach($url_array as $key=>$value)
		{
			if($value)
			{
				if(!in_array($key, $except))
				{
					if(!$url)
					{
						$url=$value;
					}
					else
					{
						$url.='_'.$value;
					}
				}
			}
		}
	}
	if($addition)
	{
		if($url)
		{
			$url.='/'.$addition;
		}
		else
		{
			$url.=$addition;
		}
	}
	return $url;
}


function generate_url_all($except=array(), $addition=false)
{
	$url='';
	foreach($_GET as $key=>$value)
	{
		if(!in_array($key, $except))
		{
			if(!$url)
			{
				$url='?'.urlencode($key).'='.urlencode($value);
			}
			else
			{
				$url.='&'.urlencode($key).'='.urlencode($value);
			}
		}
	}
	foreach($_POST as $key=>$value)
	{
		if(!in_array($key, $except))
		{
			if(!$url)
			{
				$url='?'.urlencode($key).'='.urlencode($value);
			}
			else
			{
				$url.='&'.urlencode($key).'='.urlencode($value);
			}
		}
	}
	if($addition)
	{
		if($url)
		{
			$url.='&'.$addition;
		}
		else
		{
			$url.='?'.$addition;
		}
	}
	return $url;
}
function generate_url_all_wiew($except=array(), $addition=false)
{
	$url='';
	foreach($_GET as $key=>$value)
	{
		if(!in_array($key, $except))
		{
			if(!$url)
			{
				$url='?'.urlencode($key).'='.urlencode($value);
			}
			else
			{
				$url.='&'.urlencode($key).'='.urlencode($value);
			}
		}
	}
	foreach($_POST as $key=>$value)
	{
		if(!in_array($key, $except))
		{
			if(!$url)
			{
				$url='?'.urlencode($key).'='.urlencode($value);
			}
			else
			{
				$url.='&'.urlencode($key).'='.urlencode($value);
			}
		}
	}
	if($addition)
	{
		if($url)
		{
			$url.='&'.$addition;
		}
		else
		{
			$url.='?'.$addition;
		}
	}
	return $url;
}

function replace_location($module='home', $params=false)
{
	$redirect_url = '?module='.$module;
	if ($params)
	{
		foreach($params as $param=>$value)
		{
			if(is_numeric($param))
			{
				if(isset($_REQUEST[$value]))
				{
					$redirect_url .= '&'.$value.'='.urlencode($_REQUEST[$value]);
				}
			}
			else
			{
				$redirect_url .= '&'.$param.'='.urlencode($value);
			}
		}
	}
	//header('Location:'.$redirect_url);
	echo '
		<script>
			window.location = "'.$redirect_url.'";
		</script>
	';
}

function replace_location_seo($module='home', $params=false)
{
	if(USE_SEO)
	{
		$redirect_url = '/'.$module;
		if ($params)
		{
			foreach($params as $param=>$value)
			{
				if(is_numeric($param))
				{
					if(getParam($value))
					{
						$redirect_url .= '/'.urlencode(getParam($value));
					}
				}
				else
				{
					$redirect_url .= '/'.urlencode($value);
				}
			}
		}
	}
	else
	{
		$redirect_url = '?module='.$module;
		if ($params)
		{
			foreach($params as $param=>$value)
			{
				if(is_numeric($param))
				{
					if(isset($_REQUEST[$value]))
					{
						$redirect_url .= '&'.$value.'='.urlencode($_REQUEST[$value]);
					}
				}
				else
				{
					$redirect_url .= '&'.$param.'='.urlencode($value);
				}
			}
		}
	}
	echo '
		<script>
			window.location = "'.$redirect_url.'";
		</script>
	';
	//header('Location:'.$redirect_url);
}

function getParam($name, $type = '', $default = '')
{
	global $url_array;
	$value = '';
	
	if (!empty($_POST[$name]))
		$value = $_POST[$name];
	elseif(!empty($_GET[$name]))
		$value = $_GET[$name];
	elseif(!empty($_REQUEST[$name] ))
		$value = $_REQUEST[$name];
	elseif(!empty($_FILES[$name] ))
		$value = $_FILES[$name];
	elseif(!empty($_COOKIE[$name]))
		$value = $_COOKIE[$name];
		
	elseif(!empty($url_array[$name]))
	{
		$value = $url_array[$name];
		preg_match('([A-Za-z0-9_\-+]+)', $value, $matches);
		$value = $matches['0'];
	}
	switch($type)
	{
		case 'def':
			$value = addslashes($value);
			break;
		case 'int':
			$value = convert_to_int($value);
			break;
		case 'sql':
			$value = convert_to_sql($value);
			break;
		default:
			$value = convert_to_str($value);
	}
	if($value)
		return $value;
	else
		return $default;
}
//Conver to String (Su dung khi get cac gia tri khong su dung Editor)
function convert_to_str($val)
{
	if(get_magic_quotes_gpc() == 0)
		$val = addslashes($val);
	settype($val, 'string');
	$val = htmlspecialchars($val);
	return $val;
}
function convert_to_sql($val)
{
	if(get_magic_quotes_gpc() == 0) $val = addslashes($val);
	return $val;
}
function convert_to_int($val)
{
	$val = (int)$val;
	return $val;
}
function encode_password($password)
{
	return md5($password.'giangnm_acs');
}
function is_admin()
{
	if(!is_login())
		return false;
	if($_SESSION["user"]['usergroup']==3)
		return true;
	return false;
}
function is_content_management()
{
	if(!is_login())
		return false;
	if($_SESSION["user"]['usergroup']==2 || $_SESSION["user"]['usergroup']==3)
		return true;
	return false;
}
function is_internal_admin()
{
	if(!is_login())
		return false;
	if($_SESSION["user"]['usergroup']==4 || $_SESSION["user"]['usergroup']==3)
		return true;
	return false;
}
function is_login(){
	if(isset($_SESSION["user"])){
		return true;
	}
	return false;
}
function paging($totalitem, $itemperpage, $numpageshow=10, $page_name='page_no')
{	
	$content = '';
	
	$totalpage = ceil($totalitem/$itemperpage);
	if ($totalpage<2)
	{
		return 0;
	}
	$currentpage = getParam($page_name, 'int', 1);
	$currentpage = round($currentpage);
	
	if($currentpage<=0 || $currentpage > $totalpage)
	{
		$currentpage = 1;
	}
	
	if($currentpage > ($numpageshow/2))
	{
		$startpage = $currentpage-floor($numpageshow/2);
		if($totalpage-$startpage<$numpageshow)
		{
			$startpage=$totalpage-$numpageshow+1;
		}
	}
	else
	{
		$startpage=1;
	}
	if($startpage<1)
	{
		$startpage=1;
	}
	$content.= '';
	if($currentpage>1)
	{
		$content.= '<a href = "'.generate_url_all(array($page_name), $page_name.'='.($currentpage-1)).'" >'._NEXT_PAGE.'</a>';
	}
	//Danh sach cac trang
	$content.= '&nbsp;';
	if($startpage>1)
	{
		$content.= '<a href= "'.generate_url_all(array($page_name), $page_name.'=1').' ">1</a> ';
		if($startpage>2)
		{
			$content.= '...  ';
		}
	}
	for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++)
	{
		if($i!=$startpage)
		{
			$content.= '  ';
		}
		if($i==$currentpage)
		{
			$content.= '['.$i.']';
		}
		else 
		{
			$content.= '<a href= "'.generate_url_all(array($page_name),$page_name.'='.$i).' ">'.$i.'</a>';
		}
	}
	if($i==$totalpage)
	{
		$content.= '  <a href= "'.generate_url_all(array($page_name),$page_name.'='.$totalpage).' ">'.$totalpage.'</a>';
	}
	else
	if($i<$totalpage)
	{
		$content.= '  ...  <a href= "'.generate_url_all(array($page_name),$page_name.'='.$totalpage).' ">'.$totalpage.'</a>';
	}
	$content.= '&nbsp;';
	//Trang sau
	if($currentpage<$totalpage)
	{
		$content.= '&nbsp;&nbsp;<a href = "'.generate_url_all(array($page_name),$page_name.'='.($currentpage+1)).'">'._PREVIOUS_PAGE.'</a>';
	}
	return '<center>'.$content.'</center><br />';
}

function paging_home($totalitem, $itemperpage, $numpageshow=10, $page_name='page_no')
{	
	$content = '';
	
	$totalpage = ceil($totalitem/$itemperpage);
	if ($totalpage<2)
	{
		return 0;
	}
	$currentpage = getParam($page_name, 'int', 1);
	$currentpage = round($currentpage);
	
	if($currentpage<=0 || $currentpage > $totalpage)
	{
		$currentpage = 1;
	}
	
	if($currentpage > ($numpageshow/2))
	{
		$startpage = $currentpage-floor($numpageshow/2);
		if($totalpage-$startpage<$numpageshow)
		{
			$startpage=$totalpage-$numpageshow+1;
		}
	}
	else
	{
		$startpage=1;
	}
	if($startpage<1)
	{
		$startpage=1;
	}
	$content.= '';
	if($currentpage>1)
	{
		$content.= '<a href = "'.generate_url('home', array($page_name =>($currentpage-1))).'" >'._NEXT_PAGE.'</a>';
	}
	//Danh sach cac trang
	$content.= '&nbsp;';
	if($startpage>1)
	{
		$content.= '<a href= "'.generate_url('home', array($page_name=>'1')).' ">1</a> ';
		if($startpage>2)
		{
			$content.= '...  ';
		}
	}
	for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++)
	{
		if($i!=$startpage)
		{
			$content.= '  ';
		}
		if($i==$currentpage)
		{
			$content.= '['.$i.']';
		}
		else 
		{
			$content.= '<a href= "'.generate_url('home', array($page_name => $i)).' ">'.$i.'</a>';
		}
	}
	if($i==$totalpage)
	{
		$content.= '  <a href= "'.generate_url('home', array($page_name => $totalpage)).' ">'.$totalpage.'</a>';
	}
	else
	if($i<$totalpage)
	{
		$content.= '  ...  <a href= "'.generate_url('home',array($page_name => $totalpage)).' ">'.$totalpage.'</a>';
	}
	$content.= '&nbsp;';
	//Trang sau
	if($currentpage<$totalpage)
	{
		$content.= '&nbsp;&nbsp;<a href = "'.generate_url('home', array($page_name => ($currentpage+1))).'">'._PREVIOUS_PAGE.'</a>';
	}
	return '<center>'.$content.'</center><br />';
}

function paging_category($mid, $totalitem, $itemperpage, $numpageshow=10, $page_name='page_no')
{	
	$content = '';
	
	$totalpage = ceil($totalitem/$itemperpage);
	if ($totalpage<2)
	{
		return 0;
	}
	$currentpage = getParam($page_name, 'int', 1);
	$currentpage = round($currentpage);
	
	if($currentpage<=0 || $currentpage > $totalpage)
	{
		$currentpage = 1;
	}
	
	if($currentpage > ($numpageshow/2))
	{
		$startpage = $currentpage-floor($numpageshow/2);
		if($totalpage-$startpage<$numpageshow)
		{
			$startpage=$totalpage-$numpageshow+1;
		}
	}
	else
	{
		$startpage=1;
	}
	if($startpage<1)
	{
		$startpage=1;
	}
	$content.= '';
	if($currentpage>1)
	{
		$content.= '<a href = "'.generate_url('category', array('mid'=> $mid, $page_name =>($currentpage-1))).'" >'._NEXT_PAGE.'</a>';
	}
	//Danh sach cac trang
	$content.= '&nbsp;';
	if($startpage>1)
	{
		$content.= '<a href= "'.generate_url('category', array('mid'=> $mid, $page_name=>'1')).' ">1</a> ';
		if($startpage>2)
		{
			$content.= '...  ';
		}
	}
	for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++)
	{
		if($i!=$startpage)
		{
			$content.= '  ';
		}
		if($i==$currentpage)
		{
			$content.= '['.$i.']';
		}
		else 
		{
			$content.= '<a href= "'.generate_url('category', array('mid'=> $mid, $page_name => $i)).' ">'.$i.'</a>';
		}
	}
	if($i==$totalpage)
	{
		$content.= '  <a href= "'.generate_url('category', array('mid'=> $mid, $page_name => $totalpage)).' ">'.$totalpage.'</a>';
	}
	else
	if($i<$totalpage)
	{
		$content.= '  ...  <a href= "'.generate_url('category',array('mid'=> $mid, $page_name => $totalpage)).' ">'.$totalpage.'</a>';
	}
	$content.= '&nbsp;';
	//Trang sau
	if($currentpage<$totalpage)
	{
		$content.= '&nbsp;&nbsp;<a href = "'.generate_url('category', array('mid'=> $mid, $page_name => ($currentpage+1))).'">'._PREVIOUS_PAGE.'</a>';
	}
	return '<center>'.$content.'</center><br />';
}

function paging_view($totalitem, $itemperpage, $numpageshow=10, $page_name='p')
{	
	$content = '';
	
	$totalpage = ceil($totalitem/$itemperpage);
	if ($totalpage<2)
	{
		return 0;
	}
	$currentpage = getParam($page_name, 'int', 1);
	$currentpage = round($currentpage);
	
	if($currentpage<=0 || $currentpage > $totalpage)
	{
		$currentpage = 1;
	}
	
	if($currentpage > ($numpageshow/2))
	{
		$startpage = $currentpage-floor($numpageshow/2);
		if($totalpage-$startpage<$numpageshow)
		{
			$startpage=$totalpage-$numpageshow+1;
		}
	}
	else
	{
		$startpage=1;
	}
	if($startpage<1)
	{
		$startpage=1;
	}
	$content.= '<B>'._TOTAL.'</B> '.$totalitem.'. ';
	if($currentpage>1)
	{
		$content.= '<a href = "'.generate_url_all(array($page_name), $page_name.'='.($currentpage-1)).'" >'._NEXT_PAGE.'</a>';
	}
	//Danh sach cac trang
	$content.= '&nbsp;';
	if($startpage>1)
	{
		$content.= '<a href= "'.generate_url_all(array($page_name), $page_name.'=1').' ">1</a> | ';
		if($startpage>2)
		{
			$content.= '... | ';
		}
	}
	for($i=$startpage; $i<=$startpage+$numpageshow-1&&$i<=$totalpage; $i++)
	{
		if($i!=$startpage)
		{
			$content.= ' | ';
		}
		if($i==$currentpage)
		{
			$content.= '['.$i.']';
		}
		else 
		{
			$content.= '<a href= "'.generate_url_all(array($page_name),$page_name.'='.$i).' ">'.$i.'</a>';
		}
	}
	if($i==$totalpage)
	{
		$content.= ' | <a href= "'.generate_url_all(array($page_name),$page_name.'='.$totalpage).' ">'.$totalpage.'</a>';
	}
	else
	if($i<$totalpage)
	{
		$content.= ' | ... | <a href= "'.generate_url_all(array($page_name),$page_name.'='.$totalpage).' ">'.$totalpage.'</a>';
	}
	$content.= '&nbsp;';
	//Trang sau
	if($currentpage<$totalpage)
	{
		$content.= '&nbsp;&nbsp;<a href = "'.generate_url_all(array($page_name),$page_name.'='.($currentpage+1)).'">'._PREVIOUS_PAGE.'</a>';
	}
	return $content;
}
function get_end_word($str) 
{
	$str = trim($str);
	$str_arr = explode(' ',$str);
	return strtolower($str_arr[count($str_arr)-1]);
}
function get_option($options, $selected)
{
	if ($options)
	foreach($options as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if($key==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}
function get_option_year($selected)
{
	$start_year = 1900;
	$end_year = date('Y', time()) + 50;
	for($i = $start_year; $i<=$end_year; $i++)
	{
		$input .= '<option value="'.$i.'"';
		if($i==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$i.'</option>';
	}
	return $input;
}
function get_option_month($selected)
{
	$month_arr = array(1=>_MONTH_1, 2=>_MONTH_2, 3=>_MONTH_3, 4=>_MONTH_4, 5=>_MONTH_5, 6=>_MONTH_6, 6=>_MONTH_6, 7=>_MONTH_7, 8=>_MONTH_8, 9=>_MONTH_9, 10=>_MONTH_10, 11=>_MONTH_11, 12=>_MONTH_12);
	
	foreach($month_arr as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if($key==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}
function get_option_months($selected)
{
	$month_arr = array('01'=>'01', '02'=>'02', '03'=>'03', '04'=>'04', '05'=>'05', '06'=>'06', '07'=>'07', '08'=>'08', '09'=>'09', '10'=>'10', '11'=>'11', '12'=>'12');
	
	foreach($month_arr as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if($key==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}
function get_option_month_digit($selected)
{
	$month_arr = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12);
	
	foreach($month_arr as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if($key==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}
function get_option_day($selected)
{
	$start_day = 1;
	$end_day = 31;
	for($i = $start_day; $i<=$end_day; $i++)
	{
		$input .= '<option value="'.$i.'"';
		if($i==$selected )
		{
			$input .=  ' selected="selected" ';
		}
		$input .= '>'.$i.'</option>';
	}
	return $input;
}	
function get_option_multi($options, $select_array)
{
	if ($options)
	foreach($options as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if(in_array($key, $select_array))
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}
function to_time($day, $month, $year)
{
	if(checkdate($month, $day, $year))
	{
	
		return strtotime($month.'/'.$day.'/'.$year);
	}
	else
	{
		return false;
	}		
}
function create_file($filename, $content)
{
	$fr = fopen($filename,'w+');
	fwrite ($fr,$content);
	fclose($fr);
}
function get_file_content($filename)
{
	if (file_exists($filename))
	{
		$fr = fopen($filename, 'r');
		$content = @fread($fr, filesize($filename));
		fclose($fr);
		return $content;
	}
	else
	{	
		return false;
	}
}
function delete_file($filename)
{
	if(file_exists($filename))
		@unlink($filename);
}
function string_strip($text)
{
	return stripslashes(stripslashes(stripslashes($text)));
}
function makeimage($filename,$newfilename,$path,$newwidth,$newheight, $watermark=false) {

	//SEARCHES IMAGE NAME STRING TO SELECT EXTENSION (EVERYTHING AFTER . )
	$image_type = strstr($filename, '.');

	//SWITCHES THE IMAGE CREATE FUNCTION BASED ON FILE EXTENSION
		switch($image_type) {
			case '.jpg':
				$source = imagecreatefromjpeg($path.$filename);
				break;		
			case '.JPG':
				$source = imagecreatefromjpeg($path.$filename);
				break;	
			case '.jpeg':
				$source = imagecreatefromjpeg($path.$filename);
				break;	
			case '.pjpeg':
				$source = imagecreatefromjpeg($path.$filename);
				break;		
			case '.png':
				$source = imagecreatefrompng($path.$filename);
				break;
			case '.gif':
				$source = imagecreatefromgif($path.$filename);
				break;
			case '.GIF':
				$source = imagecreatefromgif($path.$filename);
				break;
			case '.bmp':
				$source = imagecreatefromgif($path.$filename);
				break;
			case '.BMP':
				$source = imagecreatefromgif($path.$filename);
				break;
			default:
				echo("Error Invalid Image Type");
				die;
				break;
			}
	
	//CREATES THE NAME OF THE SAVED FILE
	$file = $newfilename . $filename;
	
	//CREATES THE PATH TO THE SAVED FILE
	$fullpath = $path . $file;

	//FINDS SIZE OF THE OLD FILE
	list($width, $height) = getimagesize($path.$filename);
	if(!$watermark)
	{
		//CREATES IMAGE WITH NEW SIZES
		$thumb = imagecreatetruecolor($newwidth, $newheight);

		//RESIZES OLD IMAGE TO NEW SIZES
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	}
	else
	{
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		for($i=0;$i<$newheight;$i+=100)
		{
			$color=imagecolorallocate($thumb,intval(rand(160,224)),intval(rand(160,224)),intval(rand(160,224)));
			imageline($thumb,0,$i,$newwidth,$i,$color);
		}
		$black = imagecolorallocate($thumb, intval(rand(160,224)), intval(rand(160,224)), intval(rand(160,224)));
		$font = 'arial.ttf';
		$font_size = 14;
		imagettftext($thumb, $font_size, 0, 10, 20, $black, $font, $watermark);
	}

	//SAVES IMAGE AND SETS QUALITY || NUMERICAL VALUE = QUALITY ON SCALE OF 1-100
	imagejpeg($thumb, $fullpath, 100);

	//CREATING FILENAME TO WRITE TO DATABSE
	$filepath = $fullpath;
	
	//RETURNS FULL FILEPATH OF IMAGE ENDS FUNCTION
	return $filepath;
}

function upload_image($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 250;
		$small_height = 250;
		$large_width = 450;
		$large_height = 400;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
		$large_width = $image_size['2'];
		$large_height = $image_size['3'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if($width > $large_width)
	{ 		
		$height = (int)($height/$width*$large_width);
		$width = $large_width;
	}
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		makeimage($imgname, 'large_', $dir, $width, $height);
		unlink($dir.$imgname);
	}
}

function upload_one_image($dir, $imgtmp, $imgname, $image_size='')
{	
	$small_width = $image_size[0];
	$small_height = $image_size[1];
	list($width, $height) = getimagesize($imgtmp);
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}			
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		unlink($dir.$imgname);
	}
}


function upload_image_news($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 193;
		$small_height = 113;
		$large_width = 250;
		$large_height = 150;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
		$large_width = $image_size['2'];
		$large_height = $image_size['3'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if($width > $large_width)
	{ 		
		$height = (int)($height/$width*$large_width);
		$width = $large_width;
	}
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		makeimage($imgname, 'large_', $dir, $width, $height);
		unlink($dir.$imgname);
	}
}
function upload_image_ps($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 193;
		$small_height = 113;
		$large_width = 250;
		$large_height = 150;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
		$large_width = $image_size['2'];
		$large_height = $image_size['3'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if($width > $large_width)
	{ 		
		$height = (int)($height/$width*$large_width);
		$width = $large_width;
	}
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		unlink($dir.$imgname);
	}
}

function upload_image_ps_home($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 223;
		$small_height = 120;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'home_', $dir, $small_width, $small_height);
		unlink($dir.$imgname);
	}
}
function upload_image_ps_banner($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 728;
		$small_height = 200;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'banner_', $dir, $small_width, $small_height);
		unlink($dir.$imgname);
	}
}


function upload_image_adv($dir, $imgtmp, $imgname, $image_size='')
{	
	$small_width = $image_size[0];
	$small_height = $image_size[1];
	list($width, $height) = getimagesize($imgtmp);
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}			
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		makeimage($imgname, 'large_', $dir, $width, $height);
		unlink($dir.$imgname);
	}
}
function upload_icon($dir, $imgtmp, $imgname, $image_size='')
{	
	$small_width = 22;
	$small_height = 12;
	list($width, $height) = getimagesize($imgtmp);
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}			
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		unlink($dir.$imgname);
	}
}
function upload_document($dir, $doctmp, $docname)
{	
	if(copy($doctmp, $dir.$docname))
	{					
		return true;
	}
	return false;
}
function check_type_file($file_name, $type=array())
{
	if(!$type)	return false;
	if(
		!in_array(strtolower(substr($file_name, -3)), $type) && 
		!in_array(strtolower(substr($file_name, -4)), $type)
	) return false;
	else return true;
}
function get_file_type($file_name)
{
	return strrchr($file_name, '.');
}
function get_image($row, $type, $where = 'news')
{
	$image_file = DATA_PATH_ADMIN.'images/'.$where.'/'.$type.'_'.$row['image_name'];
	if(file_exists($image_file) and $row['image_name'])
		return SITE_PATH.'data/images/'.$where.'/'.$type.'_'.$row['image_name'];
	else
		return 	false;
}
function get_image_home($row, $type, $where = 'products_services')
{
	$image_file = DATA_PATH_ADMIN.'images/'.$where.'/'.$type.'_'.$row['image_name_home'];
	if(file_exists($image_file) and $row['image_name_home'])
		return SITE_PATH.'data/images/'.$where.'/'.$type.'_'.$row['image_name_home'];
	else
		return 	false;
}
function get_image_banner($row, $type, $where = 'products_services')
{
	$image_file = DATA_PATH_ADMIN.'images/'.$where.'/'.$type.'_'.$row['image_name_banner'];
	if(file_exists($image_file) and $row['image_name_banner'])
		return SITE_PATH.'data/images/'.$where.'/'.$type.'_'.$row['image_name_banner'];
	else
		return 	false;
}
function get_icon($row, $type, $where = 'news')
{
	$image_file = DATA_PATH_ADMIN.'images/'.$where.'/'.$type.'_'.$row['icon'];
	if(file_exists($image_file) and $row['icon'])
		return SITE_PATH.'data/images/'.$where.'/'.$type.'_'.$row['icon'];
	else
		return 	false;
}


function delete_image($row, $where = 'news')
{
	if($row['image_name'])
	{
		@unlink(DATA_PATH_ADMIN.'images/'.$where.'/small_'.$row['image_name']);
		@unlink(DATA_PATH_ADMIN.'images/'.$where.'/large_'.$row['image_name']);
	}
}
function delete_image_banner($row, $where = 'news')
{
	if($row['image_name_banner'])
	{
		@unlink(DATA_PATH_ADMIN.'images/'.$where.'/banner_'.$row['image_name_banner']);
	}
}
function delete_image_home($row, $where = 'news')
{
	if($row['image_name_home'])
	{
		@unlink(DATA_PATH_ADMIN.'images/'.$where.'/home_'.$row['image_name_home']);
	}
}
function delete_photo($row)
{
	if($row['image_name'])
	{
		@unlink(DATA_PATH_ADMIN.'images/photo/size1_'.$row['image_name']);
		@unlink(DATA_PATH_ADMIN.'images/photo/size2_'.$row['image_name']);
		@unlink(DATA_PATH_ADMIN.'images/photo/size3_'.$row['image_name']);
		@unlink(DATA_PATH_ADMIN.'images/photo/size4_'.$row['image_name']);
		@unlink(DATA_PATH_ADMIN.'images/photo/large_'.$row['image_name']);
	}
}
function get_document($row, $where = 'download')
{
	$document_file = DATA_PATH_ADMIN.'document/'.$where.'/'.$row['document_name'];
	if(file_exists($document_file) and $row['document_name'])
		return SITE_PATH.'data/document/'.$where.'/'.$row['document_name'];
	else
		return 	false;
}
function delete_document($row, $where = 'download')
{
	if($row['document_name'])
	{
		@unlink(DATA_PATH_ADMIN.'document/'.$where.'/'.$row['document_name']);
	}
}
function ipCheck()
{
	if (getenv('HTTP_CLIENT_IP'))
	{
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('HTTP_X_FORWARDED_FOR'))
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_X_FORWARDED'))
	{
		$ip = getenv('HTTP_X_FORWARDED');
	}
	elseif (getenv('HTTP_FORWARDED_FOR'))
	{
		$ip = getenv('HTTP_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_FORWARDED'))
	{
		$ip = getenv('HTTP_FORWARDED');
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function get_day_of_week($time, $lang)
{
	$array_date = array(
		'0'=>_SUNDAY,
		'1'=>_MONDAY,
		'2'=>_TUESDAY,
		'3'=>_WEDNESDAY,
		'4'=>_THURSDAY,
		'5'=>_FRIDAY,
		'6'=>_SATURDAY,
	);
	if($lang=='vietnam')
	{
		$html = $array_date[date('w', $time)].', ';
		$html .= date('d/m/Y', $time).' , ';
		$html .= date('H:i', $time);
	}
	else
	{
		$html = date('H:i', $time).' ';
		$html .= $array_date[date('w', $time)].', ';
		$html .= date("j F Y", $time);
	}
	return $html;
}
function hightlight_keyword($source, $keywords)
{
/*
	foreach($keywords as $key=>$value)
	{
		$source=preg_replace(array("/^($keywords)([^\w])/i","/([^\w])($keywords)([^\w])/i"), array("<strong><font style='background-color:yellow' color=black>\\1</font></strong>\\2","\\1<strong><font style='background-color:yellow' color=black>\\2</font></strong>\\3"), $source);
	}
*/	
	//$source = str_replace($keywords, "<font style='background-color:yellow' color=black>".$keywords."</font>", $source);
	if($keywords)
		$source=preg_replace(array("/^($keywords)([^\w])/i","/([^\w])($keywords)([^\w])/i"), array("<strong><font style='background-color:yellow' color=black>\\1</font></strong>\\2","\\1<strong><font style='background-color:yellow' color=black>\\2</font></strong>\\3"), $source);
	return $source;
}
function check_date($date)
{
	if($date)
	{
		$day = substr($date, 0, 2);
		$slat1 = substr($date, 2, 1);
		$month = substr($date, 3, 2);
		$slat2 = substr($date, 5, 1);
		$year = substr($date, 6, 4);
		if((int)$day && $day >0 && $day<32 && $slat1=='/' && (int)$month && $month >0 && $month<13 && $slat2=='/' && (int)$year && $year >0)
			return 1;
		else
			return 0;
	}
	else
		return 1;
}
function convert_time($date)
{
	if(!$date)
		$date = date('d/m/Y', time());

	$day = substr($date, 0, 2);
	$month = substr($date, 3, 2);
	$year = substr($date, 6, 4);

	return strtotime($month.'/'.$day.'/'.$year);
}

function title2_data($str) {
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/( )/", '-', $str);
	$str = preg_replace('/\s\s+/', ' ', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	return $str;
}
	
function cv2dataname($str) {	
	$str = preg_replace("/(A)/", 'a', $str);
	$str = preg_replace("/(B)/", 'b', $str);
	$str = preg_replace("/(C)/", 'c', $str);
	$str = preg_replace("/(D)/", 'd', $str);
	$str = preg_replace("/(E)/", 'e', $str);
	$str = preg_replace("/(F)/", 'f', $str);
	$str = preg_replace("/(G)/", 'g', $str);
	$str = preg_replace("/(H)/", 'h', $str);
	$str = preg_replace("/(I)/", 'i', $str);
	$str = preg_replace("/(J)/", 'j', $str);
	$str = preg_replace("/(K)/", 'k', $str);
	$str = preg_replace("/(L)/", 'l', $str);
	$str = preg_replace("/(M)/", 'm', $str);
	$str = preg_replace("/(N)/", 'n', $str);
	$str = preg_replace("/(O)/", 'o', $str);
	$str = preg_replace("/(P)/", 'p', $str);
	$str = preg_replace("/(Q)/", 'q', $str);
	$str = preg_replace("/(R)/", 'r', $str);
	$str = preg_replace("/(S)/", 's', $str);
	$str = preg_replace("/(T)/", 't', $str);
	$str = preg_replace("/(U)/", 'u', $str);
	$str = preg_replace("/(V)/", 'v', $str);
	$str = preg_replace("/(W)/", 'w', $str);
	$str = preg_replace("/(X)/", 'x', $str);
	$str = preg_replace("/(Y)/", 'y', $str);
	$str = preg_replace("/(Z)/", 'z', $str);		
	return $str;
}

function get_option_c($options, $selected)
{
	if ($options)
	foreach($options as $key=>$text)
	{
		$input .= '<option value="'.$key.'"';
		if($key==$selected )
		{
			$input .=  ' selected';
		}
		$input .= '>'.$text.'</option>';
	}
	return $input;
}



function upload_gallery($dir, $imgtmp, $imgname, $image_size='')
{	
	if(!$image_size)
	{
		$small_width = 135;
		$small_height = 113;
		$large_width = 1024;
		$large_height = 780;
		$none_width = 270;
		$none_height = 226;
	}
	else
	{
		$small_width = $image_size['0'];
		$small_height = $image_size['1'];
		$large_width = $image_size['2'];
		$large_height = $image_size['3'];
		$none_width = $image_size['4'];
		$none_height = $image_size['5'];
	}
	list($width, $height) = getimagesize($imgtmp);	
	if($width> $small_width)
		$small_height = (int)($height/$width*$small_width);
	else
	{
		$small_width = $width;
		$small_height = $height;
	}
	
	if($width > $large_width)
	{ 		
		$height = (int)($height/$width*$large_width);
		$width = $large_width;
	}
	if(copy($imgtmp, $dir.$imgname))
	{					
		makeimage($imgname, 'small_', $dir, $small_width, $small_height);
		makeimage($imgname, 'none_', $dir, $none_width, $none_height);
		makeimage($imgname, 'large_', $dir, $width, $height);
		unlink($dir.$imgname);
	}
}

function upload_video($dir, $videotmp, $videoname)
{ 
 if(copy($videotmp, $dir.$videoname))
 {     
  return true;
 }
 return false;
}


function get_video($row, $where = 'video')
{
 $video_file = DATA_PATH_ADMIN.'videos/'.$row['video_name'];
 if(file_exists($video_file) and $row['video_name'])
  return SITE_PATH.'data/videos/'.$row['video_name'];
 else
  return  false;
}


function delete_video($row, $where = 'video')
{
 if($row['video_name'])
 {
  @unlink(DATA_PATH_ADMIN.'videos/'.$row['video_name']);
 }
}

/*function write_xml($rows)
{
 // create doctype
 $dom = new DOMDocument("1.0");
 
 // create root element
 $root = $dom->createElement("flash_parameters");
 $dom->appendChild($root);
 $preferences = $dom->createElement("preferences");
 $root->appendChild($preferences);
 
 $global = $dom->createElement("global");
 $preferences->appendChild($global);
//st 
 $basic_property = $dom->createElement("basic_property");
 $global->appendChild($basic_property);
 
 $att = $dom->createAttribute("movieWidth");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("978");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("movieHeight");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("203");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("html_title");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("Title");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("loadStyle");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("Bar");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("startAutoPlay");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("continuum");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("hideAdobeMenu");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("false");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("photoDynamicShow");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("enableURL");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("transitionArray");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("");
 $att->appendChild($Value);
 
 //2
 $title_property = $dom->createElement("title_property");
 $global->appendChild($title_property);
 
 $att = $dom->createAttribute("showTitle");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("photoTitleColor");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("alpha");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("50");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("autoHide");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 //3
 $music_property = $dom->createElement("music_property");
 $global->appendChild($music_property);
 
 $att = $dom->createAttribute("path");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("stream");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("loop");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 
 //4
 $photo_property = $dom->createElement("photo_property");
 $global->appendChild($photo_property);
 
 $att = $dom->createAttribute("topPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("bottomPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("leftPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("rightPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 //5
 $properties = $dom->createElement("properties");
 $global->appendChild($properties);
 
 $att = $dom->createAttribute("enable");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundAlpha");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("30");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("cssText");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("a:link{text-decoration: underline;} a:hover{color:#FF6600; text-decoration: none;} a:active{color:#FF6600;text-decoration: none;} .blue {color:#FF6600; font-size:15px; font-style:italic; text-decoration: underline;} .body{color:#FF6600;font-size:20px;}");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("align");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("top");
 $att->appendChild($Value);
 
 
 $thumbnail = $dom->createElement("thumbnail");
 $preferences->appendChild($thumbnail);
//st 
 $basic_property = $dom->createElement("basic_property");
 $thumbnail->appendChild($basic_property);
 
 $att = $dom->createAttribute("backgroundColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0x787878");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundAlpha");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("70");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("buttonColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0xfffbf0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("numberColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("currentNumberColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0xfffbf0");
 $att->appendChild($Value);
 
 
 $album = $dom->createElement("album");
 $root->appendChild($album);
 
 
 foreach($rows as $one)
 {
  $image_file = "";
  $image_file = get_image_banner_mid($one, 'small', 'xml');
  //if($image_file)
  {
   $slide = $dom->createElement("slide");
   $album->appendChild($slide);

   $att = $dom->createAttribute("d_URL");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("xml/small_".$one['image_name']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("transition");
   $slide->appendChild($att);
   $Value = $dom->createTextNode($one['id']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("URLTarget");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("0");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("URLTphototimearget");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("4");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("phototime");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("10");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("url");
   $slide->appendChild($att);
   $Value = $dom->createTextNode($one['link']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("title");
   $slide->appendChild($att);
   $Value = $dom->createTextNode($one['title']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("width");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("978");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("height");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("203");
   $att->appendChild($Value);
   
  }
 }   
 // save and display tree
 echo $dom->saveXML();
 global $current_lang;
 $dom->save("imgage_".$current_lang.".xml");
}

function get_image_banner_mid($row, $type)
{
 $image_file = ROOT_PATH.'xml/'.$type.'_'.$row['image_name'];
 if(file_exists($image_file) and $row['image_name'])
  return SITE_PATH.'xml/'.$type.'_'.$row['image_name'];
 else
  return  false;
}

function upload_image_banner($dir, $imgtmp, $imgname)
{	
	$imgname = 'small_'.$imgname;
	if(copy($imgtmp, $dir.$imgname))
		return true;
	return fall;
}*/

function write_xml($rows)
{
 // create doctype
 $dom = new DOMDocument("1.0");
 
 // create root element
 $root = $dom->createElement("flash_parameters");
 $dom->appendChild($root);
 $preferences = $dom->createElement("preferences");
 $root->appendChild($preferences);
 
 $global = $dom->createElement("global");
 $preferences->appendChild($global);
//st 
 $basic_property = $dom->createElement("basic_property");
 $global->appendChild($basic_property);
 
 $att = $dom->createAttribute("movieWidth");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("728");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("movieHeight");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("250");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("html_title");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("Title");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("loadStyle");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("Bar");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("startAutoPlay");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("continuum");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0xffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("hideAdobeMenu");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("false");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("photoDynamicShow");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("enableURL");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("transitionArray");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("");
 $att->appendChild($Value);
 
 //2
 $title_property = $dom->createElement("title_property");
 $global->appendChild($title_property);
 
 $att = $dom->createAttribute("showTitle");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("photoTitleColor");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("0x000080");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("0xffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("alpha");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("30");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("autoHide");
 $title_property->appendChild($att);
 $Value = $dom->createTextNode("false");
 $att->appendChild($Value);
 
 //3
 $music_property = $dom->createElement("music_property");
 $global->appendChild($music_property);
 
 $att = $dom->createAttribute("path");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("stream");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("loop");
 $music_property->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 
 //4
 $photo_property = $dom->createElement("photo_property");
 $global->appendChild($photo_property);
 
 $att = $dom->createAttribute("topPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("bottomPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("leftPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("rightPadding");
 $photo_property->appendChild($att);
 $Value = $dom->createTextNode("0");
 $att->appendChild($Value);
 
 //5
 $properties = $dom->createElement("properties");
 $global->appendChild($properties);
 
 $att = $dom->createAttribute("enable");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("true");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundColor");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("0xffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundAlpha");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("30");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("cssText");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("a:link{text-decoration: underline;} a:hover{color:#ff0000; text-decoration: none;} a:active{color:#0000ff;text-decoration: none;} .blue {color:#0000ff; font-size:10px; font-style: normal; text-decoration: underline;} .body{color:#ff5500;font-size:10px;}");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("align");
 $properties->appendChild($att);
 $Value = $dom->createTextNode("top");
 $att->appendChild($Value);
 
 
 $thumbnail = $dom->createElement("thumbnail");
 $preferences->appendChild($thumbnail);
//st 
 $basic_property = $dom->createElement("basic_property");
 $thumbnail->appendChild($basic_property);
 
 $att = $dom->createAttribute("backgroundColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0x787878");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("backgroundAlpha");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("70");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("buttonColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0xfffbf0");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("numberColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("00ffffff");
 $att->appendChild($Value);
 
 $att = $dom->createAttribute("currentNumberColor");
 $basic_property->appendChild($att);
 $Value = $dom->createTextNode("0xfffbf0");
 $att->appendChild($Value);
 
 
 $album = $dom->createElement("album");
 $root->appendChild($album);
 
 
 foreach($rows as $one)
 {
  $image_file = "";
  $image_file = get_image_banner_mid($one, 'small', 'xml');
  if($image_file)
  {
   $slide = $dom->createElement("slide");
   $album->appendChild($slide);

   $att = $dom->createAttribute("d_URL");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("xml/small_".$one['image_name']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("transition");
   $slide->appendChild($att);
   $Value = $dom->createTextNode($one['id']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("URLTarget");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("0");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("URLTphototimearget");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("4");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("phototime");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("2");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("url");
   $slide->appendChild($att);
   $Value = $dom->createTextNode($one['link']);
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("title");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("width");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("728");
   $att->appendChild($Value);
   
   $att = $dom->createAttribute("height");
   $slide->appendChild($att);
   $Value = $dom->createTextNode("200");
   $att->appendChild($Value);
   
  }
 }   
 // save and display tree
 echo $dom->saveXML();
 global $current_lang;
 $dom->save("imgage_".$current_lang.".xml");
}

function get_image_banner_mid($row, $type)
{
 $image_file = ROOT_PATH.'xml/'.$type.'_'.$row['image_name'];
 if(file_exists($image_file) and $row['image_name'])
  return SITE_PATH.'xml/'.$type.'_'.$row['image_name'];
 else
  return  false;
}

function upload_image_banner($dir, $imgtmp, $imgname)
{	
	$imgname = 'small_'.$imgname;
	if(copy($imgtmp, $dir.$imgname))
		return true;
	return fall;
}
function removeHTML($str)
{
    return preg_replace('/<([\/\w]+)[^>]*>/si', '', $str);
}

function get_word($str) 
{
	$str = preg_replace("/(\n)/", '', $str);
	$str = preg_replace("/(\r)/", '', $str); 
	$str = preg_replace("/(  )/", '', $str);
 if(strlen($str)>350)
 {
 $str=substr($str,0,350); 
 }
 return $str;
}

function get_string($str) 
{
	$str = wordwrap ($str ,75,".");
 	return $str;
}

function urlSeo( $Raw ){ 
    $Raw = trim($Raw);
	$Raw = title2_data($Raw);
	$Raw = cv2dataname($Raw);
    $RemoveChars  = array( "([\40])" , "([^a-zA-Z0-9-])", "(-{2,})", "(')" ); 
    $ReplaceWith = array("-", "", "-"); 
    return preg_replace($RemoveChars, $ReplaceWith, $Raw); 
} 

function upload_photo($dir, $phototmp, $photoname)
{ 
 if(copy($phototmp, $dir.$photoname))
 {     
  return true;
 }
 return false;
}


function get_photo($row, $where = 'photo')
{
 $photo_file = DATA_PATH_ADMIN.'photo/'.$where.'/'.$row['image_name'];
 if(file_exists($photo_file) and $row['image_name'])
  return SITE_PATH.'data/photo/'.$where.'/'.$row['image_name'];
 else
  return  false;
}


function drop_photo($row, $where = 'photo')
{
 if($row['image_name'])
 {
  @unlink(DATA_PATH_ADMIN.'photo/'.$where.'/'.$row['image_name']);
 }
}

function unhtmlspecialchars( $string )
{
  $string = str_replace ( '&amp;', '&', $string );
  $string = str_replace ( '&#039;', '\'', $string );
  $string = str_replace ( '&quot;', '"', $string );
  $string = str_replace ( '&lt;', '<', $string );
  $string = str_replace ( '&gt;', '>', $string );
  $string = str_replace ( '&uuml;', ' ', $string );
  $string = str_replace ( '&Uuml;', ' ', $string );
  $string = str_replace ( '&auml;', ' ', $string );
  $string = str_replace ( '&Auml;', ' ', $string );
  $string = str_replace ( '&ouml;', ' ', $string );
  $string = str_replace ( '&Ouml;',' ' , $string );  
  $string = str_replace ( '&nbsp;', ' ', $string );  
  $string = preg_replace("/(&nbsp;)/", ' ', $string); 
  return $string;
} 
function getCheckbox($name)
{
	if(getParam($name, 'str'))
		return true;
	return  false;
}
function setCheckbox($value)
{
	if($value)
		return 'checked="checked" ';
	return  false;
}
?>