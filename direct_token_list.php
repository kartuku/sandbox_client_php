<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php include_once './KartukuDirectAPI.php'; ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html, charset=ISO-8859-1">
        <style type="text/css"></style><style id="holderjs-style" type="text/css"></style></head>
    </head>
    <body>
        <form action="process_token_list.php" method="post" accept-charset="ISO-8859-1">
            <table>
                <tbody><tr>
                        Direct token list
                    </tr>
                    <tr>
                        <td>merchantToken</td>
                        <td><input type="text" name="merchantToken" id="merchantToken" value="<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>" size="75"></td>
                    </tr>
                    <tr>
                        <td>merchantUserCode</td>
                        <td><input type="text" name="merchantUserCode" id="merchantUserCode" value="mdoohan" size="75"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Submit"></td>
                    </tr>
                </tbody></table>
        </form>
    </body>
</html>
