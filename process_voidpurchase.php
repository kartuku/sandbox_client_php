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
            $void_purchase = array();
            $void_purchase["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to previous process gateway //-- deprecated
            $void_purchase["ipgGateway"] = $post_data["ipgGateway"]; 
			//-- refer to previous process ipgAcquirer
            $void_purchase["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            //-- Consumer unique invoice no. 
            $void_purchase["txnReference"] = $post_data["txnReference"]; 
            //-- refer to capture no.
            $void_purchase["ipgTxnReference"] = $post_data["ipgTxnReference"]; 

            //var_dump($authorize);
            $json_str = json_encode($void_purchase);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->voidPurchase($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
