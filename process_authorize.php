<?php if(filter_input(INPUT_SERVER, "REQUEST_METHOD") !== "POST"){
                http_response_code(405);
                echo "Method Not Allowed";
                die();
            };?>
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
        <?php
            
        
            include_once './KartukuDirectAPI.php';
            // instantiate and set access token + secret key
            $kartukuDirectAPI = new KartukuDirectAPI();            
            
            $post_data = filter_input_array(INPUT_POST);
            
            // construct authorize message
            $authorize = array();
            $authorize["merchantToken"] = $post_data["merchantToken"]; 
            $authorize["merchantUserCode"] = $post_data["merchantUserCode"]; 
            $authorize["txnTradingDate"] = $post_data["txnTradingDate"]; 
            $authorize["txnStoreCode"] = $post_data["txnStoreCode"]; 
            $authorize["ipgGateway"] = $post_data["ipgGateway"]; //-- deprecated
            $authorize["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            //-- Consumer unique invoice no
            $authorize["txnReference"] = $post_data["txnReference"]; 
            
            $authorize["txnAmount"] = $post_data["txnAmount"]; 
            $authorize["txnCurrency"] = $post_data["txnCurrency"]; 
            $authorize["txnCustom1"] = $post_data["txnCustom1"]; 
            $authorize["txnCustom2"] = $post_data["txnCustom2"]; 
            $authorize["txnCustom3"] = $post_data["txnCustom3"]; 
            
            //-- set to true to tokenize given card details (via OTT) for future transaction.
            $authorize["cardTokenize"] = $post_data["cardTokenize"]; 
            
            //-- OTT / Tokenization Token
            $authorize["cardToken"] = $post_data["cardToken"]; 
            
            //-- only if using Tokenization Token instead of OTT
            $authorize["cardCVV"] = $post_data["cardCVV"]; 
            //-- bin filtering, separated by colon ':'.
            $authorize["filterBin"] = $post_data["filterBin"]; 
            //-- card type filtering, separated by colon ':'.
            $authorize["filterCard"] = $post_data["filterCard"];
            
            //var_dump($authorize);
            $json_str = json_encode($authorize);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->authorize($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
            
            
        ?>
    </body>
</html>
