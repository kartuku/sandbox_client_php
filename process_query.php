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
            $query = array();
            $query["merchantToken"] = $post_data["merchantToken"]; 
            //-- refer to previous process gateway //-- deprecated
            // $query["ipgGateway"] = $post_data["ipgGateway"]; //-- deprecated
            //-- Consumer unique invoice no. 
            $query["txnReference"] = $post_data["txnReference"]; 

            //var_dump($authorize);
            $json_str = json_encode($query);
            try{
                // the parameter in json string
                $result = $kartukuDirectAPI->query($json_str);
                echo "Message :<br>{$result}<br>";
            }  catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </body>
</html>
