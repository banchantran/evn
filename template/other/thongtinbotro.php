
<div class="tygia">
    <div id="container-1">
        <div id="fragment-1">
            <table class="determinative-table" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
              <tr bgcolor="#ee1c25" style="color:#fff;font-weight:bold; text-align:center;">
                <td rowspan="2" width="80" style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _DETERMINATIVE ?></strong></td>
                <td style="border-right:1px #fff solid; border-bottom:1px #fff solid; font-weight:bold;"><strong>VND</strong></td>
                <td style="border-bottom:1px #fff solid; font-weight:bold;"><strong>USD</strong></td>
              </tr>
              <tr bgcolor="#ee1c25" style="color:#fff; font-weight:bold; text-align:center;">
                <td style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _PER_MONTH ?></strong></td>
                <td style="font-weight:bold;"><strong><?php echo _PER_MONTH ?></strong></td>
              </tr>
                </thead>
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
    <p style="text-align: left; padding: 0 3px;"><strong>Ngày hiệu lực:</strong> Kể từ ngày 15/03/2017 cho đến khi có thông báo mới.</p>
</div>
<div class="tygia" style="margin-top: 20px;">
    <div id="container-1">
        <div id="fragment-1" class="tabs-container">
            <table class="determinative-table" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr bgcolor="#ee1c25" style="color:#fff;font-weight:bold; text-align:center;">
                    <td rowspan="2" width="50" style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _TYPE ?></strong></td>
                    <td colspan="2" style="border-right:1px #fff solid; border-bottom:1px #fff solid; font-weight:bold;"><strong><?php echo _BUY ?></strong></td>
                    <td rowspan="2" style="border-left:1px #fff solid; border-bottom:1px #fff solid; font-weight:bold;"><strong><?php echo _SELL ?></strong></td>
                </tr>
                <tr bgcolor="#ee1c25" style="color:#fff; font-weight:bold; text-align:center;">
                    <td style="border-right:1px #fff solid; font-weight:bold;"><strong><?php echo _CASH ?></strong></td>
                    <td style="font-weight:bold;"><strong><?php echo _TRANSFER ?></strong></td>
                </tr>
                </thead>
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
    <p style="text-align: left; padding: 0 3px;"><strong>Ghi chú:</strong> Tỷ giá có thể thay đổi mà không cần báo trước</p>
</div>