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
            $void_authorize = array();
            $void_authorize["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to previous process gateway //-- deprecated
            $void_authorize["ipgGateway"] = $post_data["ipgGateway"]; 
			//-- refer to previous process acquirer
            $void_authorize["ipgAcquirer"] = $post_data["ipgAcquirer"]; 
            //-- Consumer unique invoice no. 
            $void_authorize["txnReference"] = $post_data["txnReference"]; 
            //-- refer to authorize no.
            $void_authorize["ipgTxnReference"] = $post_data["ipgTxnReference"]; 
			//-- refer to authorize txnReference
			$void_authorize["chargeTxnReference"] = $post_data["chargeTxnReference"];
            //var_dump($authorize);
            $json_str = json_encode($void_authorize);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->voidAuthorize($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
