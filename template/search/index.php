<script type="text/javascript" language="javascript">
	function searchs()
	{
		var value = document.getElementById("search").value;
		if(value == "<?php echo _KEY_WORD ?>" || value == "")
			alert('<?php echo _INPUT_KEY_WORD ?>');
		else
		{
			document.location.href= "<?php echo generate_url('search'); ?>&key="+value;
		}
	}
	
</script>
<div style="margin-top:5px; height:25px; clear:both; padding-right:10px;">
    <form method="get" action=""  style="width:250px; float:right;">
      <div>
        <input type="button" name="sa" onclick="searchs();" class="sbt" />
        <input name="search" onfocus="javascript:if(this.value=='<?php echo _KEY_WORD ?>'){this.value='';};" onblur="javascript:if(this.value==''){this.value='<?php echo _KEY_WORD ?>';};" id="search" name="search" type="text" class="form" value="<?php echo getParam('key', 'str', _KEY_WORD); ?>"/>
        
      </div>
</form></div>