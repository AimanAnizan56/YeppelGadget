<?php
    session_start();
    // database class
    require_once('../database/config.php');
    $db = Database::getInstance();
    $result_total_order = $db -> query("SELECT count(payment.id) as total_order FROM payment inner join orders on orders.id = payment.orders_id") or die('Query Error: '.$db -> error);
    $total_order = $result_total_order -> num_rows == 0 ? 0 : $result_total_order -> fetch_assoc()['total_order'];
    $result_total_sales = $db -> query("SELECT sum(total) as total_sales FROM payment inner join orders on orders.id = payment.orders_id") or die('Query Error: '.$db -> error);
    $total_sales = $result_total_sales -> num_rows == 0 ? 0 : $result_total_sales -> fetch_assoc()['total_sales'];
    $total_product = $db -> query("SELECT count(id) as total_product FROM product") -> fetch_assoc()['total_product'] or die('Query Error: '.$db -> error);
    $total_user = $db -> query("SELECT count(id) as total_user FROM user") -> fetch_assoc()['total_user'] or die('Query Error: '.$db -> error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Yeppel</title>
    <link rel="shortcut icon" href="../image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("../component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="homepage.css">
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("../component/navigation-admin.php"); ?>

    <div class="container">
        <div class="row" style="margin-top: 3rem;">
            <div class="col s3">
                <div class="col s12 card-panel light-blue darken-1 white-text center z-depth-3">
                    <h5>TOTAL ORDERS</h5>
                    <h3> <b> <?php echo $total_order; ?> </b> </h3>
                </div>
            </div>
            <div class="col s3">
                <div class="col s12 card-panel green darken-1 white-text center z-depth-3">
                    <h5>TOTAL SALES</h5>
                    <h3> <b> <?php echo "RM ".number_format($total_sales); ?> </b> </h3>
                </div>
            </div>
            <div class="col s3">
                <div class="col s12 card-panel deep-purple darken-1 white-text center z-depth-3">
                    <h5>TOTAL PRODUCTS</h5>
                    <h3> <b id="total-product-board"> <?php echo $total_product; ?> </b> </h3>
                </div>
            </div>
            <div class="col s3">
                <div class="col s12 card-panel pink darken-1 white-text center z-depth-3">
                    <h5> TOTAL USERS </h5>
                    <h3> <b id="total-user-board"> <?php echo $total_user; ?> </b> </h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s3" style="margin-bottom: 1rem;">
                <button type="button" id="btn-new-order" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">To-Process Shipment</button>
            </div>
            <div class="col s3" style="margin-bottom: 1rem;">
                <button type="button" id="btn-processed-order" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">Processed Shipment</button>
            </div>
            <div class="col s3" style="margin-bottom: 1rem;">
                <button type="button" id="btn-complete-order" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">Complete Orders</button>
            </div>
            <div class="col s3" style="margin-bottom: 1rem;">
                <button type="button" id="btn-manage-user" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">Manage Users</button>
            </div>
            <div class="col s4" style="margin-bottom: 1rem;">
                <button type="button" id="btn-view-sales" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">View Sales</button>
            </div>
            <div class="col s4" style="margin-bottom: 1rem;">
                <button type="button" id="btn-add-product" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">Add New Products</button>
            </div>
            <div class="col s4" style="margin-bottom: 1rem;">
                <button type="button" id="btn-manage-product" class="btn btn-block waves-effect waves-light col s12 light-blue darken-1 z-depth-3">Manage Products</button>
            </div>
            
        </div>

        <div class="row">
            <div id="manage-content" class="col s12">
                
            </div>
        </div>
    </div>

    <!-- Popup -->
    <?php include("modal-popup.php") ?>
    
    <!-- Content Delivery Network - JS -->
    <?php include("../component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="../js/main.js"></script>
    <script src="homepage.js"></script>
</body>
</html>