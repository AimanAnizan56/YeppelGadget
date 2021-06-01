<?php
    session_start();
    // print_r($_POST);
    // check if user is admin
    if($_SESSION['role'] == "admin"):
        // get instance of mysqli class
        require_once("../../database/config.php");
        $db = Database::getInstance();

        // escape string
        $payment_id = $db -> real_escape_string($_POST['payment_id']);
        $sql = "UPDATE payment SET shipment_id = '2' WHERE id = '$payment_id'";
        // query -- update shipment
        $db -> query($sql) or die("Query Error: ".$db -> error);

        // check affected row
        if($db -> affected_rows == 1){
            echo 'success';
        }else {
            echo 'something wrong: '.$sql;
        }
    endif;
?>