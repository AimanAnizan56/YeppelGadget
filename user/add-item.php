<?php
    // For AJAX
    session_start();
    if(isset($_SESSION['id']) and isset($_SESSION['username'])):
        $error = false;

        // get instance of mysql
        require_once("../database/config.php");
        $db = Database::getInstance();

        // escape string
        $user_id = $db -> real_escape_string($_SESSION['id']);
        $user_username = $db -> real_escape_string($_SESSION['username']);
        $product_id = $db -> real_escape_string($_POST['product_id']); // product id that user wanted to add
        $product_price = $db -> query("SELECT price FROM product WHERE id = '$product_id'") -> fetch_assoc()['price'] or die("query 0 error: ".$db -> error);

        // begin select query -- to check order by user
        if($order_result = $db -> query("SELECT id as orders_id from orders where user_id='$user_id' and status_id = '1' limit 1")):

            // check retrieved row
            if($order_result -> num_rows == 0):

                // insert new order
                $db -> query("INSERT INTO orders VALUES ('','1','$user_id')") or die("query 1 error: ".$db -> error);

                // retrieve new order inserted
                $order_id = $db -> query("SELECT last_insert_id() as id") -> fetch_assoc()['id'];

                // insert new item
                insert_product('',1,$product_price,$order_id,$product_id, $db);
            else:
                // -- continue order
                // fetch order id
                $order_id = $order_result -> fetch_assoc()['orders_id'];

                // check item -- add current quantity / continue current quantity
                $item = $db -> query("SELECT id, quantity FROM item WHERE product_id = '$product_id' and orders_id = '$order_id'") or die('query 4 error: '.$db -> error);

                // check row retrieved
                if($item -> num_rows == 0){

                    // insert new item
                    insert_product('',1,$product_price,$order_id,$product_id,$db); 
                }

                // fetch existing item
                $item_data = $item->fetch_assoc();
                $item_id = $item_data['id'];

                // assign new quantitiy and price
                $new_quantity = $item_data['quantity'] + 1;
                $new_price = $new_quantity * $product_price;

                // update exisiting data -- item
                $db -> query("UPDATE item SET price = '$new_price', quantity = '$new_quantity' WHERE id ='$item_id'") or die("query 5 error");
                die("added to cart");
            endif;
        else:
            die('main query error');
        endif;
        
    else:
        // store current path -- for product that user selected
        $_SESSION['redirect-url'] = $_SERVER['HTTP_REFERER'];
        echo 'login required'; // output this and reutrn data by ajax -- checked later with if else statement
    endif;
    function insert_product(
        string $id = '',
        int $quantity,
        int $price,
        string $orderId,
        string $productId,
        mysqli $conn
    ){
        $conn -> query("INSERT INTO item VALUES ('',$quantity,'$price','$orderId','$productId')") or die("query 3 error: ".$conn -> error);
        die ("added to cart");
        exit;
    }
?>