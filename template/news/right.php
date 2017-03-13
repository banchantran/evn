<div class="nd_r">
    <div class="td_r"><?php echo _NEWS ?></div>
    <div class="news_r">
        <ul>
            <marquee height="150" width="235" onMouseOut="this.start()" onMouseOver="this.stop()" direction="up" scrolldelay="30" scrollamount="1" align="middle">
<?php
	global $database;
	global $current_lang;
	$query = "SELECT * from news_detail where lang='".$current_lang."' AND publish=2 AND host_news=2 order by id DESC limit 0,10";
	$database->setQuery($query);
	$database->query();
	$rows = $database->loadResult();
	if($rows)
	{
		$n=0;
		foreach($rows as $one)
		{
			echo '<li><a href="'.generate_url_seo('news_detail', array('url'=>$one['url'], 'sub_url'=>$one['sub_url'], 'title_url'=>$one['title_url'])).'">'.$one['title'];
			if($one['icon']=='news.gif')
				echo '<img src="'.SITE_PATH.'themes/images/news.gif" />';
			else 
			{
				$icon = get_icon($one, 'small', 'news');
				if($icon)
					echo '<img src="'.$icon.'" />';
			}
			echo '</a></li>';				
		}
	}
?>                
            </marquee>
        </ul>
  </div>
  <div class="bottom_r"></div>
</div>