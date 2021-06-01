<?php
    if(isset($_POST['payment_id'])):
        // get instance of mysqli class
        require_once("config.php");
        $db = Database::getInstance();

        // escape string 
        $payment_id = $db -> real_escape_string($_POST['payment_id']);

        // begin query -- update shipment status (from "to receive" to "received")
        $db -> query("UPDATE payment SET shipment_id = '3' WHERE id = '$payment_id'") or die("Query Error: ".$db -> error);
        
        // output data
        if($db -> affected_rows === 1){
            echo 'update success';
            exit;
        }
        echo 'update failed';
    endif;
?>