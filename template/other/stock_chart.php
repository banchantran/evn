<script language="javascript">
	function clear_class_tool(tab)
	{		
		if(tab==1)
		{
			gmobj('tienich1').className='tien_ich';
			gmobj('tienich11').className='tien_ich_left2';
			gmobj('tienich12').className='tien_ich_text2';
			gmobj('tienich13').className='tien_ich_right2';
			
			gmobj('tienich2').className='tien_ich_022';
			gmobj('tienich21').className='tien_ich_left_022';
			gmobj('tienich22').className='tien_ich_text_022';
			gmobj('tienich23').className='tien_ich_right_022';
		}
		else{
			gmobj('tienich2').className='tien_ich';
			gmobj('tienich21').className='tien_ich_left2';
			gmobj('tienich22').className='tien_ich_text2';
			gmobj('tienich23').className='tien_ich_right2';
			
			gmobj('tienich1').className='tien_ich_022';
			gmobj('tienich11').className='tien_ich_left_022';
			gmobj('tienich12').className='tien_ich_text_022';
			gmobj('tienich13').className='tien_ich_right_022';
		}
	}
	function clear_display_tool()
	{
		document.getElementById('tab_content_1').style.display='none';
		document.getElementById('tab_content_2').style.display='none';
	}
</script>
<div class="td01"><div class="td01_text"><?php echo _TOOL ?></div></div>

    <div  class="tien_ich1" style="margin-top:3px; clear:both;">
    
           <div id="tienich1" class="tien_ich"  onclick="clear_class_tool(1); clear_display_tool(); gmobj('tab_content_1').style.display='';" onmouseover="this.style.cursor='pointer';">
            	<div id="tienich11" class="tien_ich_left2"></div>
                <div id="tienich12" class="tien_ich_text2"><a><?php echo _STOCK ?></a></div>
                <div id="tienich13" class="tien_ich_right2"></div>
           </div>
       
        <div id="tienich2" class="tien_ich_022" onclick="clear_class_tool(2); clear_display_tool(); gmobj('tab_content_2').style.display='';" onmouseover="this.style.cursor='pointer';"><div id="tienich21" class="tien_ich_left_022"></div><div id="tienich22" class="tien_ich_text_022"><a><?php echo _MONETERY_EXCHANGE ?></a></div><div  id="tienich23" class="tien_ich_right_022"></div></div>

    </div>
    
    <div id="tab_content_1" class="chung_khoan_boder">
        <span class="chung_khoan_text1"><?php echo get_day(); ?></span><br />
        
        
        
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
        <script type="text/javascript" language="JavaScript">ShowLogoLeft(4)</script>
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
    
    <div id="tab_content_2" class="chung_khoan_boder" style="display:none">
        <span class="chung_khoan_text1"><?php echo get_day(); ?></span><br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:2px">
            <tr>
                <td align="center">
                    <div style="font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:20px">
                        <SCRIPT language=JavaScript src="http://vnexpress.net/Service/Forex_Content.js"></SCRIPT>
                        <SCRIPT language=JavaScript src="<?php echo SITE_PATH;?>themes/Forex.js"></SCRIPT>
                    </div>
                    <div style="padding:2px; margin-top:5px; text-align:left">
                    <span class="chung_khoan_text1"><?php echo _GOLD_EXCHANGE ?></span><br />
                            <table align="center" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" width="100%">                            
                                 <SCRIPT language=JavaScript src="http://vnexpress.net/Service/Gold_Content.js"></SCRIPT>
                                <SCRIPT language="JavaScript"> 
                                    function AddGoldPrice(Currency, Rate)
                                    {
                                        document.writeln('<tr><td align="left">', Currency, '</td><td align="right">', Rate ,'</td></tr>');
                                    }
                                    
                                    if (typeof(vGoldBuy) !='undefined') AddGoldPrice('<?php echo _BUY; ?>', vGoldBuy);
                                    if (typeof(vGoldSell)!='undefined') AddGoldPrice('<?php echo _SELL; ?>', vGoldSell);
                                </SCRIPT>
                                <tr>
                                    <td colspan="2" align="center"><i>(Nguồn: SJC Ha Noi)</i></td>
                                </tr>
                            </tbody>
                            </table>
                     </div>
                </td>
            </tr>
        </table>
	</div>