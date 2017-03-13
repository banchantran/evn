<select name="link"  class="web_link" onchange="window.open(this.value);" id="select2" >
      <option value="0" style="font-size:12px; font-family:arial, Times, serif"><?php echo _LINK;?></option>
   <?php
            global $database;
            global $current_lang;
            $query = "SELECT * from link where lang='".$current_lang."' order by region";
            $database->setQuery($query);
            $database->query();
            $all_quick_link = $database->loadResult();
            if($all_quick_link)
            {
                foreach($all_quick_link as $one)
                {
                    echo '<option value="'.$one['link'].'" style="font-size:12px; font-family:arial, Times, serif">-&nbsp;'.string_strip($one['fullname']).'</option>';
                }
            }
        ?>	
</select>