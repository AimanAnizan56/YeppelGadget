<?php
    require_once("../../database/config.php");
    $db = Database::getInstance();
    $result_orders = $db -> query("select orders.id as orders_id, orders.status_id as order_status, user.username as username, payment.id as payment_id, payment.purchased_at as purchased_date, payment.total as total_purchased, shipment.status as shipment_status, gateway.name as payment_gateway from orders inner join user on orders.user_id = user.id inner join payment on payment.orders_id = orders.id inner join shipment on shipment.id = payment.shipment_id inner join gateway on gateway.id = payment.gateway_id where orders.status_id = '2' and shipment.status = 'received'") or die("Query Error: ".$db -> error);
    $orders = array();
    if($result_orders -> num_rows > 0):
        foreach($result_orders as $row):
            $orders[] = $row;
        endforeach;
        // echo "<pre>",print_r($orders) , "</pre>";
    endif;
?>
<?php if($orders != null): ?>
    <?php foreach($orders as $order): ?>
    
        <div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
            <div class="row">
                <div class="col s12">

                    <span class="col s4">
                        <b class="details">Username</b> 
                        <span> <b>:&ensp;</b> <?php echo $order['username']; ?> </span>
                    </span>
                    
                    <span class="col s4">
                        <b class="details">Payment Id</b> 
                        <span> <b>:&ensp;</b> <?php echo $order['payment_id']; ?> </span>
                    </span>

                    <span class="col s4">
                        <b class="details">Purchase Date</b> 
                        <span> <b>:&ensp;</b> <?php echo date("d F Y", strtotime($order['purchased_date'])); ?> </span>
                    </span>
                    
                    <span class="col s4">
                        <b class="details">Orders Id</b> 
                        <span> <b>:&ensp;</b> <?php echo $order['orders_id']; ?> </span>
                    </span>
                    
                    <span class="col s4">
                        <b class="details">Payment Gateway</b> 
                        <span> <b>:&ensp;</b> <?php echo $order['payment_gateway']; ?> </span>
                    </span>

                    <span class="col s4">
                        <b class="details">Shipping Status</b> 
                        <b>:&ensp;</b>
                        <span class="green darken-1 white-text" style="padding: 0 0.5rem;"> 
                            <?php echo ucwords($order['shipment_status']); ?>
                        </span>
                    </span>
                </div>
            </div>
        

            <!-- Display items with current orders id -->
            <ol class="collection"> 
            <?php
            // begin query -- retrieve item added into cart with limit one image
            $order_id = $db -> real_escape_string($order['orders_id']);
            $total_price = 0;
            $result_item = $db -> query("select item.id as item_id, product.name as product_name,product.price as price_per_item, item.quantity as item_quantity, item.price as item_price, image.id as image from item inner join product on item.product_id = product.id inner join image on image.product_id = product.id inner join orders on orders.id = item.orders_id where orders.id = '$order_id' group by item.id") 
            or die("query 1 failed");
            while($data = $result_item -> fetch_assoc()):
                $total_price += $data['item_price']; // add into variable -- used to store total of all product
            ?>
                <li class="collection-item avatar black-text">
                    <img src="../database/retrieve-img.php?id=<?php echo $data['image']; ?>" alt="" class="circle">
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
                    <!-- <button type="button" onclick="confirmbox_processShipment(<?php echo $order['payment_id']; ?>)" class="btn waves-effect waves-light light-blue darken-1" style="margin-right: 2rem;">
                        <i class="material-icons right">send</i>
                        Process Shipment
                    </button> -->
                    <label class="btn green darken-1" style="margin-right: 2rem;">
                        <i class="material-icons right">check</i>
                        Completed
                    </label>
                        
                    SUBTOTAL: &ensp; 
                    <span class="green-text text-darken-1" style="font-size: 1.3rem!important"> 
                        RM  <?php echo number_format($order['total_purchased'],2); ?>
                    </span>
                </span>
            </div>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="card-panel z-depth-2"  style="margin-bottom: 3rem;">
        <h5>No Order</h5>
    </div>
<?php endif; ?>
