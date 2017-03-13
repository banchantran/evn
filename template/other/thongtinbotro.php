<div class="tygia">
    <div id="container-1">
        <ul id="ttbt">
            <li><a href="#fragment-1"><span><?php echo _RATES ?></span></a></li>
            <li><a href="#fragment-2"><span><?php echo _GOLD_PRICES ?></span></a></li>
            <li><a href="#fragment-3"><span><?php echo _SECURITIES ?></span></a></li>
            <!--<li><a href="#fragment-4"><span>Công bố lãi suất</span></a></li>-->
        </ul>
        <div id="fragment-1">
            <SCRIPT language=JavaScript src="http://vnexpress.net/Service/Forex_Content.js"></SCRIPT>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#ee1c25" style="color:#fff;font-weight:bold; text-align:center;">
                <td rowspan="2" width="80" style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _CURRENCY ?>/VNĐ</strong></td>
                <td colspan="2" style="border-bottom:1px #fff solid; font-weight:bold;"><strong><?php echo _OFFER ?></strong></td>
              </tr>
              <tr bgcolor="#ee1c25" style="color:#fff; font-weight:bold; text-align:center;">
                <td style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _BUY ?></strong></td>
                <td style="font-weight:bold;"><strong><?php echo _SELL ?></strong></td>
              </tr>
              <tr style=" background:#fff; color:#000; text-align:center; padding:5px 0;">
                <td><strong>USD</strong></td>
                <td><script language="javascript">document.writeln(vCosts[0]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[0]);</script></td>
              </tr>
              <tr style=" background:#fcf2f1; color:#000; text-align:center; padding:5px 0;">
                <td><strong>GBP</strong></td>
                <td><script language="javascript">document.writeln(vCosts[1]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[1]);</script></td>
              </tr>
              <tr style=" background:#fff; color:#000; text-align:center; padding:5px 0;">
                <td><strong>HKD</strong></td>
                <td><script language="javascript">document.writeln(vCosts[2]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[2]);</script></td>
              </tr>
              <tr style=" background:#fcf2f1; color:#000; text-align:center; padding:5px 0;">
                <td><strong>FRF</strong></td>
                <td><script language="javascript">document.writeln(vCosts[3]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[3]);</script></td>
              </tr><tr style=" background:#fff; color:#000; text-align:center; padding:5px 0;">
                <td><strong>CHF</strong></td>
                <td><script language="javascript">document.writeln(vCosts[4]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[4]);</script></td>
              </tr>
              <tr style=" background:#fcf2f1; color:#000; text-align:center; padding:5px 0;">
                <td><strong>JPY</strong></td>
                <td><script language="javascript">document.writeln(vCosts[6]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[6]);</script></td>
              </tr>
              <tr style=" background:#fff; color:#000; text-align:center; padding:5px 0;">
                <td><strong>AUD</strong></td>
                <td><script language="javascript">document.writeln(vCosts[7]);</script></td>
                <td><script language="javascript">document.writeln(vCosts[7]);</script></td>
              </tr>
            </table>
        </div>
        
        <div id="fragment-2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#ee1c25" style="color:#fff;font-weight:bold; text-align:center;">
                <td rowspan="2" width="80" style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _GOLD ?></strong></td>
                <td colspan="2" style="border-bottom:1px #fff solid; font-weight:bold;"><strong><?php echo _OFFER ?></strong></td>
              </tr>
              <tr bgcolor="#ee1c25" style="color:#fff; font-weight:bold; text-align:center;">
                <td style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _BUY ?></strong></td>
                <td style="font-weight:bold;"><strong><?php echo _SELL ?></strong></td>
              </tr>
              
              <SCRIPT language=JavaScript src="http://vnexpress.net/Service/Gold_Content.js"></SCRIPT>
				<SCRIPT language="JavaScript"> 
                    
                    
                    if (typeof(vGoldBuy) !='undefined') AddGoldPrice('<?php echo _BUY; ?>', vGoldBuy);
                    if (typeof(vGoldSell)!='undefined') AddGoldPrice('<?php echo _SELL; ?>', vGoldSell);
                </SCRIPT>
              
              <tr style=" background:#fcf2f1; color:#000; text-align:center; padding:5px 0;">
                <td><strong>SBJ</strong></td>
                <td>
                	<SCRIPT language="JavaScript"> 
                    	document.writeln(vGoldSbjBuy);
                    </SCRIPT>                </td>
                <td>
                	<SCRIPT language="JavaScript"> 
                    	document.writeln(vGoldSbjSell);
                    </SCRIPT>                </td>
              </tr>
              <tr style=" background:#fff; color:#000; text-align:center; padding:5px 0;">
                <td><strong>SJC</strong></td>
                <td>
                	<SCRIPT language="JavaScript"> 
                    	document.writeln(vGoldSjcBuy);
                    </SCRIPT>                </td>
                <td>
                	<SCRIPT language="JavaScript"> 
                    	document.writeln(vGoldSjcSell);
                    </SCRIPT>                </td>
               </tr>
            </table>
      </div>
        
        <div id="fragment-3">
          
          
          
          <script type="text/javascript">		
                function gmobj(o){
					if(document.getElementById){ m=document.getElementById(o); }
					else if(document.all){ m=document.all[o]; }
					else if(document.layers){ m=document[o]; }
					return m;
				}
				
				function ShowStock(i){
					/*if(i==0){
						gmobj('VnIndex-Left').className = 'activetab-left fl';
						gmobj('VnIndex-Center').className = 'activetab-center fl';
						gmobj('VnIndex-Right').className = 'activetab-right fl';
						gmobj('HaIndex-Left').className = 'deactivetab-left2 fl';
						gmobj('HaIndex-Center').className = 'deactivetab-center fl';
						gmobj('HaIndex-Right').className = 'deactivetab-right2 fl';
						gmobj('HOSE').style.display = '';		
						gmobj('HASTC').style.display = 'none';						
					}
					else{
						gmobj('VnIndex-Left').className = 'deactivetab-left1 fl';
						gmobj('VnIndex-Center').className = 'deactivetab-center fl';
						gmobj('VnIndex-Right').className = 'deactivetab-right1 fl';
						gmobj('HaIndex-Left').className = 'activetab-left fl';
						gmobj('HaIndex-Center').className = 'activetab-center fl';
						gmobj('HaIndex-Right').className = 'activetab-right fl';
						gmobj('HOSE').style.display = 'none';		
						gmobj('HASTC').style.display = '';					
					}*/
					if(i == 0){
						gmobj('HO2').className = 'st-li-ho fl';
						gmobj('HA2').className = 'st-li-ha2 fl';
						gmobj('oHO2').className = 'st-act';
						gmobj('oHA2').className = 'st-deact';							
						gmobj('CONT').innerHTML = gmobj('HOSE').innerHTML;
					}
					else{				
						gmobj('HO2').className = 'st-li-ho2 fl';
						gmobj('HA2').className = 'st-li-ha fl';
						gmobj('oHO2').className = 'st-deact';
						gmobj('oHA2').className = 'st-act';	
						gmobj('CONT').innerHTML = gmobj('HASTC').innerHTML;
					}
				}
				
				function ShowTopStock(i){   
					if(i == 0){
						gmobj('top5-hose').className = 'st-act';
						gmobj('top5-hastc').className = 'st-deact';
						gmobj('TOP5CONT').innerHTML = gmobj('TOP5HOSE').innerHTML;
					}
					else{						
						gmobj('top5-hose').className = 'st-deact';
						gmobj('top5-hastc').className = 'st-act';
						gmobj('TOP5CONT').innerHTML = gmobj('TOP5HASTC').innerHTML;
					}
				}
				
				function ShowFlashObject(objName, objFileName, objWidth, objHeight) {
					var sHTML = '';
					sHTML = sHTML.concat('<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="').concat(objWidth).concat('" HEIGHT="').concat(objHeight).concat('">');	
					sHTML = sHTML.concat('	<PARAM NAME=movie VALUE="../').concat('/Images/AdWord/').concat(objFileName).concat('">');
					sHTML = sHTML.concat('	<PARAM NAME=quality VALUE=high>');
					sHTML = sHTML.concat('	<PARAM NAME=bgcolor VALUE=#FFFFFF>');	
					sHTML = sHTML.concat('	<EMBED src="../').concat('/Images/AdWord/').concat(objFileName).concat('" quality=high bgcolor=#FFFFFF WIDTH="').concat(objWidth).concat('" HEIGHT="').concat(objHeight).concat('" NAME="').concat(objName).concat('" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">');
					sHTML = sHTML.concat('</OBJECT>');
					return sHTML;		
				}


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
                      <!--<iframe scrolling="no" height="250" frameborder="0" width="240" border="false" noresize="" src="http://vnexpress.net/User/ck/hcms/HCMStockSmall.asp" name="ifrmContent" id="ifrmContent"></iframe>-->
          <!--Nội dung Chứng khoán đang được cập nhật-->
        </div>
  <!--<div id="fragment-4">
            Nội dung Công bố lãi xuất đang được cập nhật
        </div>-->
    </div>
</div>