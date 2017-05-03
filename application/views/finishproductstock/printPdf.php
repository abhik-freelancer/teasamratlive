<html>
    <body>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-ir9v{font-size:13px;font-family:"Courier New", Courier, monospace !important;;vertical-align:top}
.tg .tg-b5xw{font-size:13px;font-family:"Courier New", Courier, monospace !important;;color:#efefef;vertical-align:top;text-align: left}
.tg .tg-yw4l{font-size:10px;vertical-align:top;font-family:"Courier New", Courier, monospace !important; }
</style>


<table width="100%" align="center" style="margin-top:0;">
    <tr>
        <td align="center" style="font-size:12px;font-weight:bold;font-family:verdana;"><?php echo($company); ?><br>Finish product stock for period <?php echo($for_period); ?></td>
    </tr>
   
</table>
<div style="padding-top:10px;"></div>
        <table class="tg" width="100%">
            <tr>
                <th class="tg-ir9v" align="left">Product</th>
                <th class="tg-ir9v" align="right">Stock-In</th>
                <th class="tg-ir9v" align="right">Stock-Out</th>
                <th class="tg-ir9v" align="right">Balance</th>
            </tr>
            <?php
            foreach ($finishProdStock as $content) {
                ?>
                <tr>
                    <td class="tg-yw4l"><?php echo($content["finishProduct"]); ?></td>
                    <td class="tg-yw4l" style="text-align: right;" ><?php echo($content["stockIn"]); ?></td>
                    <td class="tg-yw4l" style="text-align: right;"><?php echo($content["stockOut"]); ?></td>
                    <td class="tg-yw4l" style="text-align: right;"><?php echo($content["balance"]); ?></td>
                </tr>
                <?php
            }
            ?>

        </table>
    </body>

</html>