<div class="boder123">
    <div class="td_left"><div class="td_left_text"><?php echo _STOCK ?></div></div>
    <div style="padding:5px;">
    	 <script type="text/javascript">		
	function ShowStockIndex(i){
		if(i == 0){
			gmobj('HO').className = 'st-li-ho fl';
			gmobj('HA').className = 'st-li-ha2 fl';
			gmobj('oHO').className = 'st-act';
			gmobj('oHA').className = 'st-deact';
			gmobj('ifrmContent').src = 'http://vnexpress.net/User/ck/hcms/HCMStockSmall.asp';
		}
		else{
			gmobj('HO').className = 'st-li-ho2 fl';
			gmobj('HA').className = 'st-li-ha fl';
			gmobj('oHO').className = 'st-deact';
			gmobj('oHA').className = 'st-act';
			gmobj('ifrmContent').src = 'http://vnexpress.net/User/ck/hns/HNStockSmall.asp';
		}
	}
	ShowStockIndex(0);
</script>
<!--        <iframe src="http://vnexpress.net/User/ck/hcms/HCMStockSmall.asp" style="border: 0pt none ; width: 175px; height: 260px;"></iframe>
        
        <div style="padding-top:5px;" align="right">Nguồn: <a href="http://cafef.vn/" target="_blank"><img src="themes/images/img_cafef.gif"></a></div>
        
--> 
	<div class="box-item">
            <ul class="st-ul">                
                <li class="st-li-hd he22 fl">
                    <ul class="st-ul">
                        <li id="HO" class="st-li-ho fl"><p id="oHO" class="st-act" onclick="ShowStockIndex(0);">HOSE</p></li>
                        <li id="HA" class="st-li-ha2 fl"><p id="oHA" class="st-deact" onclick="ShowStockIndex(1);">HASTC</p></li>                    </ul>
                </li>                
                <li class="st-li-hd he191 fl">
                    <ul class="st-ul">
                        <li class="st-cont he191 fl">
                            <iframe id="ifrmContent" name="ifrmContent" src="http://vnexpress.net/User/ck/hcms/HCMStockSmall.asp" noresize="" border="false" scrolling="no" width="100%" frameborder="0" height="230px"></iframe>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
</div>
</div>
