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
        <script src="<?php echo KartukuDirectAPI::getIPGUrl();?>js/kartuku-ott.js"></script>
        <style type="text/css"></style><style id="holderjs-style" type="text/css"></style></head>
    </head>
    <body>
        <form action="process_token_store.php" method="post" id="kartuku-form" accept-charset="ISO-8859-1">
            <table>
                <tbody><tr>
                        Direct token store
                    </tr>
                    <tr>
                        <td>merchantToken</td>
                        <td><input type="text" kartuku-data-id="merchantToken" name="merchantToken" id="merchantToken" value="<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>" size="75"></td>
                    </tr>
                    <tr>
                        <td>merchantUserCode</td>
                        <td><input type="text" kartuku-data-id="merchantUserCode" name="merchantUserCode" id="merchantUserCode" value="mdoohan" size="75"></td>
                    </tr>
                    <tr>
                        <td>cardToken</td>
                        <td><input type="text" kartuku-data-id="cardToken" name="cardToken" id="cardToken" value="" size="75"></td>
                    </tr>

                    <tr>
                        <td>cardNumber</td>
                        <td><input type="text" kartuku-data-id="cardNumber" value="4011111111111112" size="75"></td>
                    </tr>

                    <tr>
                        <td>cardExpMonth</td>
                        <td><input type="text" kartuku-data-id="cardExpMonth" value="01" placeholder="MM" size="2"></td>
                    </tr>

                    <tr>
                        <td>cardExpYear</td>
                        <td><input type="text" kartuku-data-id="cardExpYear" value="20" placeholder="YY" size="2"></td>
                    </tr>
                    <tr>
                        <td>cardCVV</td>
                        <td><input type="text" kartuku-data-id="cardCvv" name="cardCVV" value="000" size="75"></td>
                    </tr>

                    <tr>
                        <!-- submit button is disabled until document is ready (completely loaded) -->
                        <td colspan="2"><input type="submit" id="submit-button" value="Submit"></td>
                    </tr>
                </tbody></table>
        </form>
        <script>
            // pure JS implementation to retrieve token

            // wait for document is ready and completely loaded
            window.onload = function () {
                var form = document.getElementById('kartuku-form');
                var submitButton = document.getElementById('submit-button');
                // enable the submit button
                submitButton.disabled = false;

                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    // instantiate the KartukuOtt object
                    var kartukuOtt = new KartukuOtt();
					// sandbox = false
                    // production = true
                    kartukuOtt.setProduction(false);
                    // put your merchant token
                    // tips, it can be found in form
                    kartukuOtt.setMerchantToken("<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>");

                    // define the function for success result
                    var successCallback = function (result) {
                        // no need to check 3ds on token store
                        // put the token to the form
                        document.getElementById("cardToken").value = result.cardToken;
                        // submit the form
                        form.submit();
                    };
                    // define the function for error result
                    var errorCallback = function (error) {
                        // handle error while getting the token
                        alert(error.message + "\n" + error.status);
                    };
                    // get the token
                    kartukuOtt.getToken(form, "store", successCallback, errorCallback);
                });
            };
        </script>
    </body>
</html>
