<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once './KartukuDirectAPI.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="process_capture.php" method="post" accept-charset="ISO-8859-1">
            <table>
                <tbody>
                    <tr>
                        Direct Capture
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                        <td>merchantToken</td>
                        <td><input type="text" name="merchantToken" id="merchantToken" value="<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>" size="75"></td>
                    </tr>
					<!-- Deprecated -->
                    <!--<tr>
                        <td>ipgGateway (deprecated)</td>
                        <td><input type="text" name="ipgGateway" id="ipgGateway" value="" size="75"></td>
                    </tr>-->
					<tr>
                        <td>ipgAcquirer</td>
                        <td><input type="text" kartuku-data-id="ipgAcquirer" name="ipgAcquirer" id="ipgAcquirer" value="" size="75"></td>
                    </tr>
                    <tr>
                        <td>txnReference</td>
                        <td><input type="text" name="txnReference" id="txnReference" value="1422861297434" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnAmount</td>
                        <td><input type="text" name="txnAmount" id="txnAmount" value="100" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnCurrency</td>
                        <td><input type="text" kartuku-data-id="txnCurrency" name="txnCurrency" id="txnCurrency" value="IDR" size="75"></td>
                    </tr>

                    <tr>
                        <td>authTxnReference</td>
                        <td><input type="text" name="authTxnReference" id="authTxnReference" value="" size="75"></td>
                    </tr>

                    <tr>
                        <td>authIpgTxnReference</td>
                        <td><input type="text" name="authIpgTxnReference" id="authIpgTxnReference" value="" size="75"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Submit"></td>
                    </tr>
                </tbody></table>
        </form>
    </body>
</html>
