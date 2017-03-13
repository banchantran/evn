<ul class="box">
  <li <?php if(getParam('module')=='profile') echo 'id="menu-active"'; ?>><a href="<?php echo generate_url('profile');?>"><span><?php echo _PROFILE;?></span></a></li>
   <?php 
  if(is_admin()){
  ?>
  <li <?php if(getParam('module')=='user_admin') echo 'id="menu-active"'; ?>><a href="<?php echo generate_url('user_admin');?>"><span><?php echo _USER_ADMIN;?></span></a></li>
  <?php
  }
  if(is_admin()){
  ?>
  <li <?php if(getParam('module')=='category_admin') echo 'id="menu-active"'; ?>><a href="<?php echo generate_url('category_admin');?>"><span><?php echo _CATEGORY_ADMIN;?></span></a></li>
  <?php
  }
  ?>
   <li <?php if(getParam('module')=='block_admin') echo 'id="menu-active"'; ?>><a href="<?php echo generate_url('block_admin');?>"><span><?php echo _BLOCK_ADMIN;?></span></a></li>
  <li <?php if(getParam('module')=='contact_admin') echo 'id="menu-active"'; ?>><a href="<?php echo generate_url('contact_admin');?>"><span><?php echo _CONTACT_ADMIN;?></span></a></li>	  
</ul>
