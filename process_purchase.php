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
            $purchase = array();
            $purchase["merchantToken"] = $post_data["merchantToken"]; 
            $purchase["ipgGateway"] = $post_data["ipgGateway"]; //-- deprecated
            $purchase["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            $purchase["merchantUserCode"] = $post_data["merchantUserCode"]; 
            $purchase["txnTradingDate"] = $post_data["txnTradingDate"]; 
            $purchase["txnStoreCode"] = $post_data["txnStoreCode"]; 
            
            //-- Consumer unique invoice no
            $purchase["txnReference"] = $post_data["txnReference"]; 
            
            $purchase["txnAmount"] = $post_data["txnAmount"]; 
            $purchase["txnCurrency"] = $post_data["txnCurrency"]; 
            $purchase["txnCustom1"] = $post_data["txnCustom1"]; 
            $purchase["txnCustom2"] = $post_data["txnCustom2"]; 
            $purchase["txnCustom3"] = $post_data["txnCustom3"]; 
            
            //-- set to true to tokenize given card details (via OTT) for future transaction.
            $purchase["cardTokenize"] = $post_data["cardTokenize"]; 
            
            //-- OTT / Tokenization Token
            $purchase["cardToken"] = $post_data["cardToken"]; 
            
            //-- only if using Tokenization Token instead of OTT
            $purchase["cardCVV"] = $post_data["cardCVV"]; 
            //-- bin filtering, separated by colon ':'.
            $purchase["filterBin"] = $post_data["filterBin"]; 
            //-- card type filtering, separated by colon ':'.
            $purchase["filterCard"] = $post_data["filterCard"];
            
            //var_dump($authorize);
            $json_str = json_encode($purchase);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->purchase($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
            
            
        ?>
    </body>
</html>
