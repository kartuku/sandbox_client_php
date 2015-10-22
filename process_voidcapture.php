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
            $void_capture = array();
            $void_capture["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to previous process gateway
            $void_capture["ipgGateway"] = $post_data["ipgGateway"]; 
            //-- Consumer unique invoice no. 
            $void_capture["txnReference"] = $post_data["txnReference"]; 
            //-- refer to capture no.
            $void_capture["ipgCaptureNo"] = $post_data["ipgCaptureNo"]; 

            //var_dump($authorize);
            $json_str = json_encode($void_capture);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->voidCapture($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
