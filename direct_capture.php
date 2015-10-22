<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
                        <td><input type="text" name="merchantToken" id="merchantToken" value="3ed76d63779e450fb62d08c30fc7963a" size="75"></td>
                    </tr>
                    <tr>
                        <td>ipgGateway</td>
                        <td><input type="text" name="ipgGateway" id="ipgGateway" value="" size="75"></td>
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
                        <td><input type="text" name="txnCurrency" id="txnCurrency" value="IDR" size="75"></td>
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
