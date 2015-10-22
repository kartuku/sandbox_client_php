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
            $capture = array();
            $capture["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to authorize gateway
            $capture["ipgGateway"] = $post_data["ipgGateway"]; 
            
            //-- Consumer unique invoice no
            $capture["txnReference"] = $post_data["txnReference"];             
            $capture["txnAmount"] = $post_data["txnAmount"]; 
            $capture["txnCurrency"] = $post_data["txnCurrency"]; 
            
            //-- refer to authorize txnReference
            $capture["authTxnReference"] = $post_data["authTxnReference"]; 
            
            //-- refer to authorize ipgTxnReference
            $capture["authIpgTxnReference"] = $post_data["authIpgTxnReference"]; 
            
            //var_dump($authorize);
            $json_str = json_encode($capture);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->capture($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
            
        ?>
    </body>
</html>
