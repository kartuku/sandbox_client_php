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
            $token_remove = array();
            $token_remove["merchantToken"] = $post_data["merchantToken"];             
            $token_remove["merchantUserCode"] = $post_data["merchantUserCode"]; 
            //-- Card Token
            $token_remove["cardToken"] = $post_data["cardToken"]; 

            //var_dump($authorize);
            $json_str = json_encode($token_remove);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->tokenRemove($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
