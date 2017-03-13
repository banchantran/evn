
<div class="tygia">
    <div id="container-1">
        <ul id="ttbt">
            <li><a href="#fragment-1"><span><?php echo _RATES ?></span></a></li>
            <li><a href="#fragment-2"><span><?php echo _GOLD_PRICES ?></span></a></li>
            <li><a href="#fragment-3"><span><?php echo _SECURITIES ?></span></a></li>
            <!--<li><a href="#fragment-4"><span>Công bố lãi suất</span></a></li>-->
        </ul>
        <div id="fragment-1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#ee1c25" style="color:#fff;font-weight:bold; text-align:center;">
                <td rowspan="2" width="80" style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _CURRENCY ?>/VNĐ</strong></td>
                <td colspan="2" style="border-bottom:1px #fff solid; font-weight:bold;"><strong><?php echo _OFFER ?></strong></td>
              </tr>
              <tr bgcolor="#ee1c25" style="color:#fff; font-weight:bold; text-align:center;">
                <td style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _BUY ?></strong></td>
                <td style="font-weight:bold;"><strong><?php echo _SELL ?></strong></td>
              </tr>

                <?php
                $url = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";
                $codes = array('AUD', 'EUR', 'GBP', 'JPY', 'USD');
                $data = simplexml_load_file($url);
                $exchangerate = $data->Exrate;
                $index = 0;
                foreach ($exchangerate as $item) {
                    if (!in_array($item['CurrencyCode'], $codes)) {
                        continue;
                    }
                    ?>

                    <tr style=" background:<?php echo $index++ % 2 == 0 ? '#fff' : '#fcf2f1'; ?>; color:#000; text-align:center; padding:5px 0;">
                        <td><strong><?php echo $item['CurrencyCode']; ?></strong></td>
                        <td>
                            <?php echo $item['Buy']; ?>
                        </td>
                        <td>
                            <?php echo $item['Sell']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        
  <!--<div id="fragment-4">
            Nội dung Công bố lãi xuất đang được cập nhật
        </div>-->
    </div>
</div>