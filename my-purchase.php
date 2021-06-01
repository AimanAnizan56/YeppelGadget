<?php
    session_start();
    // database class
    require_once('database/config.php');
    $db = Database::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Purchase | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal{
            width: 20vw;
            padding: 0 10px;
        }
        .details {
            display: inline-block;
            width: 6vw;
        }
    </style>
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <div class="container">
        <div class="row card-panel z-depth-5" style="margin: 3rem 0">

            <div class="col s12">
                <blockquote style="border-left-color: #039be5;">
                    <h3>My Purchase</h3>
                </blockquote>
            </div>

            <div class="col s12">
                    <?php
                        // check if user already login
                        if(isset($_SESSION['id']) and isset($_SESSION['username'])):

                            // escape string
                            $user_id = $db -> real_escape_string($_SESSION['id']);

                            // begin query -- select complete order
                            $order = $db -> query("select id from orders where status_id = '2' and user_id='$user_id' order by orders.id desc") or die("Query failed: ".$db -> error);

                            // check row retrieved
                            if($order -> num_rows > 0):
                                // variable to store total price
                                $total_price = 0;

                                // looping -- display completed purchased product
                                foreach($order as $row):
                                    // escape string
                                    $order_id = $db -> real_escape_string($row['id']);

                                    // begin query -- retrieved items purchased detail by orders id
                                    $payment = $db -> query("SELECT payment.id as payment_id, payment.orders_id as orders_id, payment.purchased_at as purchase_date, shipment.status as shipment_status, shipment.id as shipment_id from payment inner join shipment on payment.shipment_id = shipment.id where payment.orders_id = '$order_id'") -> fetch_assoc() or die ("Error: ". $db -> error);
                                    $subtotal = $db -> query("SELECT sum(price) as subtotal FROM item WHERE orders_id = '$order_id'") -> fetch_assoc()['subtotal'] or die("Query failed: ".$db -> error);

                                    // begin query -- retrieve item added into cart with limit one image
                                    $result = $db -> query("select item.id as item_id, product.name as product_name,product.price as price_per_item, item.quantity as item_quantity, item.price as item_price, image.id as image from item inner join product on item.product_id = product.id inner join image on image.product_id = product.id inner join orders on orders.id = item.orders_id where orders.id = '$order_id' group by item.id") 
                                    or die("query 1 failed");

                                    // check if rows more thant one
                                    if($result -> num_rows > 0):
                                        // fetch associative array - store into a variable
                                        ?>
                                        <!-- Display current order with card panel -->
                                        <div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
                                            <div class="row">
                                                <div class="col s12">

                                                    <span class="col s6">
                                                        <b class="details">Orders Id</b> 
                                                        <span> <b>:&ensp;</b> <?php echo $order_id; ?> </span>
                                                    </span>

                                                    <span class="col s6">
                                                        <b class="details">Payment Id</b> 
                                                        <span> <b>:&ensp;</b> <?php echo $payment['payment_id']; ?> </span>
                                                    </span>

                                                    <span class="col s6">
                                                        <b class="details">Purchase Date</b> 
                                                        <span> <b>:&ensp;</b> <?php echo date("d F Y", strtotime($payment['purchase_date'])); ?> </span>
                                                    </span>

                                                    <span class="col s6">
                                                        <b class="details">Shipping Status</b> 
                                                            <?php
                                                            if(strtolower($payment['shipment_status']) == 'received'){
                                                                ?>
                                                                    <b>:&ensp;</b>
                                                                    <span class="green darken-1 white-text" style="padding: 0 0.5rem;"> 
                                                                        <?php echo ucwords($payment['shipment_status']); ?>
                                                                    </span>
                                                                <?php
                                                            }else {
                                                                ?>
                                                                    <b>:&ensp;</b>
                                                                    <span class="light-blue darken-1 white-text" style="padding: 0 0.5rem;"> 
                                                                        <?php echo ucwords($payment['shipment_status']); ?>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?> 
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Display items with current orders id -->
                                            <ol class="collection"> 
                                            <?php
                                            while($data = $result -> fetch_assoc()):
                                                $total_price += $data['item_price']; // add into variable -- used to store total of all product
                                            ?>
                                                <li class="collection-item avatar black-text">
                                                    <img src="database/retrieve-img.php?id=<?php echo $data['image']; ?>" alt="" class="circle">
                                                    <span class="title">
                                                        <h6>
                                                            <?php echo $data['product_name']; ?>
                                                        </h6>
                                                    </span>
                                                    <p>
                                                        &ensp; <b>RM <?php echo number_format($data['price_per_item'],2); ?> </b> &nbsp; x &nbsp; <?php echo $data['item_quantity']; ?> &nbsp; = &nbsp; <b class="light-blue-text text-darken-1">RM <?php echo number_format($data['item_price'],2); ?></b>
                                                    </p>
                                                </li>
                                            <?php endwhile; ?>
                                            </ol>

                                            <!-- Subtotal and button to received order -->
                                            <div class="row">
                                                <span class="col s12 right-align">
                                                    <?php
                                                    if(strtolower($payment['shipment_status']) == 'received'){
                                                        ?>
                                                            <label class="btn green darken-1" style="margin-right: 2rem;">
                                                                <i class="material-icons right">check</i>
                                                                Completed
                                                            </label>
                                                        <?php    
                                                    } else if (strtolower($payment['shipment_status']) == 'to receive') {
                                                        ?>
                                                            <button type="button" onclick="received_order(<?php echo $payment['payment_id']; ?>)" class="btn waves-effect waves-light light-blue darken-1" style="margin-right: 2rem;">
                                                                Received Order
                                                            </button>
                                                        <?php    
                                                    }else {
                                                        ?>
                                                            <label class="btn light-blue darken-1" style="margin-right: 2rem;">
                                                                <i class="material-icons right">local_shipping</i>
                                                                Pending
                                                            </label>
                                                        <?php    
                                                    }
                                                    ?>
                                                    SUBTOTAL: &ensp; 
                                                    <span class="light-blue-text text-darken-1" style="font-size: 1.3rem!important"> 
                                                        RM  <?php echo number_format($subtotal,2); ?>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                            <?php
                                    else:
                                        goto display_none; // show display -- nothing added
                                    endif;
                                endforeach;
                                goto skip_none; // skip display
                            else:
                                    goto display_none;
                            endif;

                            // display this if user do not buy anything yet
                            display_none:
                            ?>
                            <ol class="collection">
                                <li class="collection-item avatar black-text">
                                    <span class="title">
                                        <h6>
                                            You had not purchased anything yet
                                        </h6>
                                    </span>
                                </li>
                            </ol>
                            <?php
                            
                        else:
                            header("location: login-page.php");
                        endif;
                    ?>
                <!-- Skip here if user has buy at least one product -->
                <?php skip_none: ?>
            </div>
            <?php if(isset($total_price) and $total_price > 0): // check if variable is set ?>
            <div class="col s12">
                <ul class="collection">
                    <li class="collection-item">
                        <div class="right-align">
                            TOTAL PURCHASED: &ensp; 
                            <span class="light-blue-text text-darken-1" style="font-size: 1.8rem!important"> 
                                RM <?php echo number_format($total_price,2); ?>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
            <div class="col s12">
                <!-- <a href="index.php" class="btn waves-effect grey lighten-4 black-text right" style="margin-right: 1rem;">
                    Cancel
                </a> -->
            </div>
        </div>
    </div>
    
    <div class="modal" id="modal-confirm-received" style="margin-top: 8rem;">
        <div class="modal-content center">
            <h3>
                Received order?
            </h3>
            <button id="btn-confirm-received" class="btn btn-block waves-effect waves-light light-blue darken-1">
                Yes
            </button>
            <button class="btn btn-block waves-effect waves-light white black-text modal-close">
                No
            </button>
        </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script>
        var current_payment_id = "";
        $(()=>{
            $("#profile-page").addClass("active");
            $("#btn-confirm-received").click(()=>{
                // send post using jquery and load
                $.post("database/confirm-received.php",
                {
                    payment_id: current_payment_id
                },
                (data, status)=>{
                    if(data == "update success") {
                        window.location.reload(true);
                    }
                })
            })
        })
        function received_order ( payment_id) {
            $(()=>{
                $("#modal-confirm-received").modal("open");
                current_payment_id = payment_id;
            })
        }
    </script>
    <script src="js/main.js"></script>
</body>
</html>