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
    <meta http-equiv="Cache-control" content="no-cache">
    <title>Cart | Yeppel</title>
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
    </style>
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <div class="container">
        <div class="row card-panel" style="margin-top: 3rem">
            <div class="col l12">
                <blockquote style="border-left-color: #039be5;">
                    <h3>Cart</h3>
                </blockquote>
            </div>
            <div class="col l12">
                <ol class="collection">
                    <?php
                        // check if user already login
                        if(isset($_SESSION['id']) and isset($_SESSION['username'])):
                            // escape string
                            $user_id = $db -> real_escape_string($_SESSION['id']);

                            $order = $db -> query("select id from orders where status_id = '1' and user_id='$user_id'") or die("Query failed: ".$db -> error);

                            if($order -> num_rows == 1):
                                // escape string
                                $order_id = $db -> real_escape_string($order -> fetch_assoc()['id']);

                                // begin query -- retrieve item added into cart with limit one image
                                $result = $db -> query("select item.id as item_id, product.name as product_name,product.price as price_per_item, item.quantity as item_quantity, item.price as item_price, image.id as image from item inner join product on item.product_id = product.id inner join image on image.product_id = product.id inner join orders on orders.id = item.orders_id where orders.id = '$order_id' and product.availability_id = '1' group by item.id") 
                                or die("query 1 failed");

                                // variable to store total price
                                $total_price = 0;

                                // check if rows more thant one
                                if($result -> num_rows > 0):
                                    // fetch associative array - store into a variable
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
                                            <a href="" onclick="event.preventDefault();deleteItem('<?php echo $data['item_id']; ?>')" class="secondary-content red-text tooltipped" data-position="right" data-tooltip="Remove item">
                                                <i class="material-icons">
                                                    remove_shopping_cart
                                                </i>
                                            </a>
                                        </li>
                                    <?php
                                    endwhile;
                                    goto skip_none; // skip display
                                else:
                                    goto display_none; // show display -- nothing added
                                endif;
                            else:
                                    goto display_none;
                            endif;
                            display_none:
                            ?>
                            <li class="collection-item avatar black-text">
                                <span class="title">
                                    <h6>
                                        Nothing added yet
                                    </h6>
                                </span>
                            </li>
                            <?php
                            
                        else:
                            header("location: login-page.php");
                        endif;
                    ?>
                <?php skip_none: ?>
                </ol>
            </div>
            <?php if(isset($total_price) and $total_price > 0): // check if variable is set ?>
            <div class="col l12">
                <ul class="collection">
                    <li class="collection-item">
                        <div class="right-align">
                            SUBTOTAL: &ensp; 
                            <span class="light-blue-text text-darken-1" style="font-size: 1.8rem!important"> 
                                RM <?php echo number_format($total_price,2); ?>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
            <div class="col l12">
                <?php if(isset($result) and $result -> num_rows > 0):  ?>
                <a href="check-out.php" class="btn waves-effect waves-light light-blue darken-1 right">
                    Check Out
                </a>
                <?php endif; ?>
                <a href="index.php" class="btn waves-effect grey lighten-4 black-text right" style="margin-right: 1rem;">
                    Cancel
                </a>
            </div>
        </div>
    </div>
    

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script>
        function deleteItem(itemId){
            // perform ajax post http request
            $.post("user/remove-item.php" /* path */,{
                item_id: itemId /* variable to pass */
            },
            (data, status)=>{
                window.location.href=window.location.href;
            }
            );
        }
    </script>
</body>
</html>