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
            $void_refund = array();
            $void_refund["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to previous process gateway //-- deprecated
            $void_refund["ipgGateway"] = $post_data["ipgGateway"]; 
			//-- refer to previous process ipgAcquirer
            $void_refund["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            //-- Consumer unique invoice no. 
            $void_refund["txnReference"] = $post_data["txnReference"]; 
            
            $void_refund["ipgTxnReference"] = $post_data["ipgTxnReference"]; 

            //var_dump($authorize);
            $json_str = json_encode($void_refund);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->voidRefund($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
