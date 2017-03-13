<div class="boder123">
        <div class="td_left"><div class="td_left_text"><?php echo _MONETERY_EXCHANGE;?></div></div>
        <div style="padding:5px;">
          <div style="font-size: 12px; font-family: Arial,Helvetica,sans-serif; line-height: 20px;">
             <table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
             <tbody><tr><td>
                    <table bgcolor="#cecece" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr bgcolor="#ffffff"><td id="IDM_Forex">
                    <table bgcolor="#cecece" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr bgcolor="#ffffff"><td>
                        <div style="height: 100%; width: 100%;">
                        <table align="center" bgcolor="#cecece" border="0" cellpadding="3" cellspacing="1" width="100%">
                        <tbody>
                        <SCRIPT language=JavaScript src="http://vnexpress.net/Service/Forex_Content.js"></SCRIPT>
						<SCRIPT language="JavaScript"> 
                            function AddCurrencyRate(Currency, Rate)
                            {
                                document.writeln('<tr align="center" bgcolor="#ffffff"><td class="BoxItem">', Currency, '</td><td class="BoxItem" align="center">', Rate ,'</td></tr>');
                            }
                            
                            if (typeof(vForexs[0]) !='undefined' && typeof(vCosts[0]) !='undefined') AddCurrencyRate(vForexs[0], vCosts[0]);
                            if (typeof(vForexs[10]) !='undefined' && typeof(vCosts[10]) !='undefined') AddCurrencyRate(vForexs[10], vCosts[10]);
							if (typeof(vForexs[1]) !='undefined' && typeof(vCosts[1]) !='undefined') AddCurrencyRate(vForexs[1], vCosts[1]);
							if (typeof(vForexs[2]) !='undefined' && typeof(vCosts[2]) !='undefined') AddCurrencyRate(vForexs[2], vCosts[2]);
							if (typeof(vForexs[7]) !='undefined' && typeof(vCosts[7]) !='undefined') AddCurrencyRate(vForexs[7], vCosts[7]);									
							
                        </SCRIPT>
                        </tbody></table>
                        </div>
                        </td></tr>
                        </tbody></table>
                        </td></tr></tbody>
                   	</table>
				</td></tr></tbody>
             </table>

          </div>
            <div align="right" style="padding-top:5px;">Nguồn: <img src="themes/images/logo-EXIM.gif" /></div>
     </div>
</div>