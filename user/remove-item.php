<?php
    // FOR AJAX USE
    if(isset($_POST['item_id'])){
        // get instance of mysqli
        require_once('../database/config.php');
        $db = Database::getInstance();

        // escape string
        $item_id = $db -> real_escape_string($_POST['item_id']);

        // query -- get quantity by item id
        $result_1 = $db -> query("SELECT product.price as product_price, item.quantity as quantity FROM item INNER JOIN product ON product.id = item.product_id WHERE item.id = '$item_id'") or die("'query 1 failed");

        // check if number of rows retrieved more than 1 and fetch associative array, store in variable
        if($result_1 -> num_rows > 0 and $data_1 = $result_1 -> fetch_assoc()):

            // if item quantity is one, than delete the whole item
            if($data_1['quantity'] == 1):
                $db -> query("DELETE FROM item WHERE id=$item_id") or die("could not delete item");

            else:
                // else update current cart -- remove one from existing quantity
                $new_quantity = $db -> real_escape_string($data_1['quantity'] - 1);
                $new_item_price = $db -> real_escape_string($data_1['product_price'] * $new_quantity);
                $db -> query("UPDATE item SET quantity = '$new_quantity', price = '$new_item_price' WHERE id = '$item_id'") or die("query 2 failed");
            endif;
        else:
            // error output if the item id did not exist
            echo "item id not exist -- could not delete";
            die();
        endif;
    }
?>