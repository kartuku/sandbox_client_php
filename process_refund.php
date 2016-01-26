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
            
            // construct refund message
            $refund = array();
            $refund["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to authorize gateway //-- deprecated
            $refund["ipgGateway"] = $post_data["ipgGateway"]; 
			//-- refer to authorize acquirer
            $refund["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            
            //-- Consumer unique invoice no
            $refund["txnReference"] = $post_data["txnReference"];             
            $refund["txnAmount"] = $post_data["txnAmount"]; 
            $refund["txnCurrency"] = $post_data["txnCurrency"]; 
            
            $refund["ipgTxnReference"] = $post_data["ipgTxnReference"];   
			//-- refer to prev txnReference
			$refund["chargeTxnReference"] = $post_data["chargeTxnReference"];             
            
            //var_dump($authorize);
            $json_str = json_encode($refund);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->refund($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
            
        ?>
    </body>
</html>
