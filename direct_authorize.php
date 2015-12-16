<?php include_once './KartukuDirectAPI.php'; ?>
<html><head>
        <meta http-equiv="Content-Type" content="text/html, charset=ISO-8859-1">
        <script src="<?php echo KartukuDirectAPI::getIPGUrl();?>js/kartuku-ott.js"></script>
        <style type="text/css"></style><style id="holderjs-style" type="text/css"></style>
        <link href="css/kartuku-style.css" rel="stylesheet" />
    </head>
    <body class=" __plain_text_READY__">
        <form action="process_authorize.php" method="POST" id="kartuku-form" accept-charset="ISO-8859-1">
            <table>
                <tbody>
                    <tr>
                        <td>Direct Authorize</td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                        <td>merchantToken</td>
                        <td><input type="text" kartuku-data-id="merchantToken" name="merchantToken" id="merchantToken" value="<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>" size="75"></td>
                    </tr>

                    <tr>
                        <td>filterBin</td>
                        <td><input type="text" name="filterBin" id="filterBin" value="" size="75"></td>
                    </tr>

                    <tr>
                        <td>filterCard</td>
                        <td><input type="text" name="filterCard" id="filterCard" value="" size="75"></td>
                    </tr>

                    <tr>
                        <td>merchantUserCode</td>
                        <td><input type="text" kartuku-data-id="merchantUserCode" name="merchantUserCode" id="merchantUserCode" value="mdoohan" size="75"></td>
                    </tr>

                    <tr>
                        <td>cardTokenize</td>
                        <td><input type="text" name="cardTokenize" id="cardTokenize" value="false" size="75"></td>
                    </tr>

                    <tr>
                        <td>cardToken</td>
                        <td><input type="text" kartuku-data-id="cardToken" name="cardToken" id="cardToken" value="" size="75"></td>
                    </tr>

                    <tr>
                        <td>cardNumber</td>
                        <td><input type="text" kartuku-data-id="cardNumber" value="4811111111111114" size="75"></td>
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
                        <td><input type="text" kartuku-data-id="cardCvv" name="cardCVV" value="123" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnTradingDate</td>
                        <td><input type="text" name="txnTradingDate" id="txnTradingDate" value="2015-04-24 09:46:13" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnStoreCode</td>
                        <td><input type="text" name="txnStoreCode" id="txnStoreCode" value="200" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnReference</td>
                        <td><input type="text" kartuku-data-id="txnReference" name="txnReference" id="txnReference" value="1422861297434" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnAmount</td>
                        <td><input type="text" kartuku-data-id="txnAmount" name="txnAmount" id="txnAmount" value="100" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnCurrency</td>
                        <td><input type="text" name="txnCurrency" id="txnCurrency" value="IDR" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnCustom1</td>
                        <td><input type="text" name="txnCustom1" id="txnCustom1" value="custom1" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnCustom2</td>
                        <td><input type="text" name="txnCustom2" id="txnCustom2" value="custom2" size="75"></td>
                    </tr>

                    <tr>
                        <td>txnCustom3</td>
                        <td><input type="text" name="txnCustom3" id="txnCustom3" value="custom3" size="75"></td>
                    </tr>
                    <tr>
                        <!-- submit button is disabled until document is ready (completely loaded) -->
                        <td colspan="2"><input type="submit" id="submit-button" value="Submit"></td>
                    </tr>
                </tbody></table>
        </form>
        <div id="kartuku-3ds-container"  class="popup-hide">

        </div>
        <script>
            // pure JS implementation to retrieve token

            // wait for document is ready and completely loaded
            window.onload = function () {
                var form = document.getElementById('kartuku-form');
                var submitButton = document.getElementById('submit-button');
                // enable the submit button
                submitButton.disabled = false;
                var btnClose= document.getElementById('btnClose');
				var tridsbox = document.getElementById("kartuku-3ds-container");


                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    // instantiate the KartukuOtt object
                    var kartukuOtt = new KartukuOtt();
					// sandbox = false
                    // production = true
                    kartukuOtt.setProduction(false);
					destroyPopup(tridsbox);
                    // put your merchant token
                    // tips, it can be found in form
                    kartukuOtt.setMerchantToken("<?php echo KartukuDirectAPI::$MERCHANT_TOKEN?>");

                    // define the function for success result
                    var successCallback = function (result) {
                        // put the token to the form
                        if(result.url){
                            // open pop up

							buildPopup(tridsbox,result.url);
                        }else{
							destroyPopup(tridsbox);
                            document.getElementById("cardToken").value = result.cardToken;
                            // submit the form
                            form.submit();
                        }

                    };
                    // define the function for error result
                    var errorCallback = function (error) {
                        // handle error while getting the token

						var btnClose=document.getElementById("btnClose");
                        if(btnClose){
						    btnClose.style.display="inherit";
                        }
                        alert(error.message + "\n" + error.status);
                    };
                    // get the token
                    kartukuOtt.getToken(form, "authorize", successCallback, errorCallback);
                });
            };



			function buildPopup(node,url){



				//elements
				var _iframe = document.createElement("iframe");
				var _center= document.createElement("center");
				var _btnClose= document.createElement("button");
				//set attributes

				_iframe.setAttribute("height","450");
				_iframe.setAttribute("width","450");

				_iframe.setAttribute("id","kartuku-3ds-box");

				_btnClose.setAttribute("id","btnClose");
				_btnClose.innerHTML="Close";
				_btnClose.style.display="none";
				_btnClose.addEventListener("click",function(e){destroyPopup(node)});

				_center.appendChild(_btnClose);

				//put element on dom
				node.appendChild(_iframe);
				node.appendChild(_center);

				// show it to the world!
				node.setAttribute("class","popup");
				_iframe.setAttribute("src",url);

			}

			function destroyPopup(node){
				node.setAttribute("class","popup-hide");

				while(node.firstChild){
					node.removeChild(node.firstChild);
				}

			}



        </script>



    </body>
</html>
