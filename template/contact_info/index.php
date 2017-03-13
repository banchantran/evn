<div class="contactbls">
    <div class="td_r"><?php echo _CONTACT_US ?></div>
    <div class="ctactbls">
        <?php
			global $current_lang;
			$file_name= DATA_PATH.'html/contact_info/contact_info_'.$current_lang.'.html';
			echo get_file_content($file_name);
		?>
    </div>
</div>