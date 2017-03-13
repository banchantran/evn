<div class="main-content">
<?php
	global $database;
	global $current_lang;
	$url1 = getParam(1, 'str');
	$url2 = getParam(2, 'str');
	$url4 = getParam(4, 'str');
	$query = 'SELECT * FROM `product` WHERE lang="'.$current_lang.'" AND url = "'.$url1.'"  AND sub_url = "'.$url2.'" AND product_url = "'.$url4.'" AND publish =2 ORDER BY region, id DESC';
			$database->setQuery($query);
			$one = $database->loadRow();
			if($one){
?>
        <h1><?php echo $one['title']; ?></h1>
        <br />
        <div class="product-box">
            <div class="box main-box">
                <div class="box-left">
                    <div class="box-right">
                        <div class="box-top">
                            <div class="box-bot">
                                <div class="box-tl">
                                    <div class="box-br">
                                        <div class="title">
                                        <h2 class="product-logo"><?php echo $one['model']; ?></h2>                        
                                        <?php
                                        $image_file = get_image($one, 'large', 'product');
                                    if($image_file)
                                        echo '<img align="left" style="margin:20px; max-width:200px" height="150px" src="'.$image_file.'" alt="'.$one['title'].'">';
                                        ?>
                                        </div>
                                        <br>
                                        <p><?php echo $one['brief']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="prod-description">
    <ul class="tabset">
        <li>
            <a class="tab   " href="#tab1">
                <span class="tab-left">
                    <span class="tab-right">Key technical features</span>
    
                </span>
            </a>
        </li>
        <li>
            <a class="tab  " href="#tab2">
                <span class="tab-left">
                    <span class="tab-right">Applications</span>
                </span>
    
            </a>
        </li>
        <li>
            <a class="tab  " href="#tab3">
                <span class="tab-left">
                    <span class="tab-right">Product codes</span>
                </span>
            </a>
    
        </li>
        <li>
            <a class="tab  active" href="#tab4">
                <span class="tab-left">
                    <span class="tab-right">Documentation</span>
                </span>
            </a>
        </li>
    
    </ul>
    <div class="tabs-content">
        <div class="tab" id="tab1" style="display: none;">
            <div class="prod-specification">
            Hien thi noi dung
            </div> 
        </div>
        <div class="tab" id="tab2" style="display: none;">
            <?php echo $one['brief']; ?>
        </div>
        <div class="tab" id="tab3" style="display: none;">
            <?php echo $one['content']; ?>
        </div>
        <div class="tab" id="tab4" style="display: none;">
            Noi dung 4
        </div>
    </div>						
    <?php } ?>
</div>
</div>