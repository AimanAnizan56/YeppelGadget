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
    <title>Check Out | Yeppel</title>
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
                    <h3>Check Out</h3>
                </blockquote>
            </div>

            <div class="col l6">
                <h6>
                    Shipping Detail
                </h6>
                <ul class="collection">
                    <li class="collection-item row">
                        <?php 
                            // escape string
                            $user_id = $db -> real_escape_string($_SESSION['id']);
                            // begin query -- retrieve name and address using username as condition
                            $result = $db -> query("select name, address from user where id='$user_id'") or die("Query for user failed");
                            // check row retrieved
                            if($result -> num_rows == 1):
                                // fetch associative array - store into a variable
                                $data = $result -> fetch_assoc();
                        ?>
                        <span class="title col l2">
                            Name
                        </span>
                        <span class="col l10" style="font-weight: 600">
                            <?php echo $data['name']; ?>
                        </span>
                    </li>
                    <li class="collection-item row">
                        <span class="title col l2">
                            Ship to
                        </span>
                        <span class="col l10" style="font-weight: 600">
                            <?php echo $data['address']; endif;?>
                        </span>
                    </li>
                    <li class="collection-item row">
                        <span class="title col l2">
                            Method
                        </span>
                        <span class="col l10" style="font-weight: 600">
                            Free Shipping
                        </span>
                    </li>
                </ul>
                <h6>
                    Payment
                </h6>
                <?php
                    $gateway = Database::getRows("SELECT * FROM gateway"); $checked = true;
                ?>
                <span>All transactions are secure and encrypted.</span>
                <ul class="collection">
                    <?php foreach($gateway as $row): ?>
                    <li class="collection-item">
                            <label>
                                <input class="with-gap" name="gateway_id" id="gateway_id" value="<?php echo $row -> id; ?>" type="radio" required <?php if($checked==true){ echo 'checked'; $checked = false; } ?> >
                                <span class="black-text"><?php echo $row -> name; ?></span>
                            </label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col l6">
                <ol class="collection">
                    <?php
                        
                        // begin query -- retrieve item added into cart with limit one image
                        $result = $db -> query("select item.id as item_id, product.name as product_name,product.price as price_per_item, item.quantity as item_quantity, item.price as item_price, image.id as image, orders.id as orders_id from item inner join product on item.product_id = product.id inner join image on image.product_id = product.id inner join orders on orders.id = item.orders_id where orders.user_id = '$user_id' and orders.status_id = '1' group by item.id") 
                        or die("query for item failed");
                        // variable to store total price and orders id
                        $total_price = 0;
                        $orders_id = "";
                        // check if rows more thant one
                        if($result -> num_rows > 0):
                            // fetch associative array - store into a variable
                            while($data = $result -> fetch_assoc()):
                                $orders_id = $data['orders_id'];
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
                            <?php
                            endwhile;
                        endif;
                    ?>
                </ol>
                <ul class="collection">
                        <li class="collection-item black-text">
                            <div>
                                <span class="left-align">
                                Subtotal
                                </span>
                                <span class="right light-blue-text text-darken-1" style="font-size: 1.3rem!important">
                                    <b>RM <?php echo number_format($total_price,2); ?></b>
                                </span>
                            </div>
                            <div style="margin-top: 1rem;">
                                <span class="left-align">
                                Shipping
                                </span>
                                <span class="right light-blue-text text-darken-1" style="font-size: 1.3rem!important">
                                    <b>Free</b>
                                </span>
                            </div>
                        </li>
                        <li class="collection-item black-text">
                            <div>
                                <span class="left-align">
                                Total
                                </span>
                                <span class="right light-blue-text text-darken-1" style="font-size: 1.3rem!important">
                                    <b>RM <?php echo number_format($total_price,2); ?></b>
                                </span>
                            </div>
                        </li>
                </ul>
            </div>
            <div class="col l12">
                <a href="index.php" class="btn waves-effect grey lighten-4 black-text right" style="margin-right: 1rem;">
                    Cancel
                </a>
                <button type="button" id="btn-submit" class="btn waves-effect waves-light light-blue darken-1 right" style="margin-right: 1rem;">
                    Continue to Payment
                </button>
            </div>
        </div>
    </div>

    <div id="complete-order" class="modal">
        <div class="modal-content">
            <i class="material-icons center green-text text-darken-1" style="width: 100%; font-size: 10rem">check_circle</i>
            <h4 class="center">Thank you for purchasing</h4>
        </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script>
        $(()=>{
            // add event listener for submit button
            $("#btn-submit").click(()=>{
                // post request -- send gateway id and orders id
                $.post( "user/make-payment.php" , {
                    gateway_id: $("#gateway_id:checked").val(),
                    orders_id: "<?php echo $orders_id; ?>"
                },
                (data, status)=>{
                    // alert(data);
                    // check if payment complete
                    if(data == "orders complete") {
                        // initialize modal
                        $('#complete-order').modal({
                            dismissible: false
                        });
                        // open modal popup
                        $('#complete-order').modal("open");
                        // redirect user after 1 sec
                        setTimeout(()=>{
                            window.location.replace("my-purchase.php");
                        },1000)
                    }
                }
                );
            })
        })
    </script>
    <script src="js/main.js"></script>
</body>
</html>