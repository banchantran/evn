<div class="boder123">
    <div class="td_left"><div class="td_left_text"><?php echo _GOLD_EXCHANGE;?></div></div>
    <div style="padding:5px;">
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
</div>