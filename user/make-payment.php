<?php
    // ajax post
    if (isset($_POST['gateway_id']) and isset($_POST['orders_id'])):
        // get instance of mysqli object
        require_once "../database/config.php";
        $db = Database::getInstance();

        // escape string
        $gateway_id = $db -> real_escape_string($_POST['gateway_id']);
        $orders_id = $db -> real_escape_string($_POST['orders_id']);
        
        // get total price of orders
        $total = 0;
        $item_price = $db -> query("SELECT item.price as item_price FROM item WHERE orders_id = '$orders_id'") or die("Query 1 Error: ".$db -> error);
        foreach($item_price as $row){
            $total += $row['item_price'];
        }
        $total = $db -> real_escape_string($total);
        // insert into payment
        $db -> query("INSERT INTO payment (total,orders_id,shipment_id,gateway_id) VALUES ('$total','$orders_id','1','$gateway_id')") or die("Query 2 Error: ".$db -> error);

        // update orders - change order to complete
        $db -> query("UPDATE orders set status_id='2' WHERE id = '$orders_id'") or die("Query 3 Error: ".$db -> error);

        if ($db -> error == null) {
            echo 'orders complete';
        }
    endif;
?>