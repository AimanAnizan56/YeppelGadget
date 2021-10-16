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
    <title>Product | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <?php   
        // default sql -- retrieve all product
        $sql = "SELECT product.id as prod_id, product.name as prod_name, product.price as prod_price, image.id as img_id from product inner join image on product.id = image.product_id where product.availability_id = '1' group by prod_id";
        echo '<blockquote class="container" style="border-left-color: #039be5">';
        // if user browse by category
        if(isset($_GET['category'])):
            // output header -- (ucfirst -- upper case first char)
            echo "<h2>".ucfirst($_GET['category'])."</h2>";
            // escape string before retrieveing from database
            $category = $db -> real_escape_string($_GET['category']);
            // retrieve image by category selected from user
            $sql = "SELECT product.id as prod_id, product.name as prod_name, product.price as prod_price, image.id as img_id from product inner join image on product.id = image.product_id inner join category on product.category_id = category.id where category.name = '$category' and product.availability_id = '1' group by prod_id";

            //if user browse by searching keyword
        elseif(isset($_GET['search'])):
            // output header
            echo "<h2> Search Keyword: ".$_GET['search']."</h2>";
            // escape string before retrieving from database
            $search = $db -> real_escape_string("%".$_GET['search']."%");
            // retrieve image by searching keyword -- use (like) and (%) to search entire word
            $sql = "SELECT product.id as prod_id, product.name as prod_name, product.price as prod_price, image.id as img_id from product inner join image on product.id = image.product_id inner join category on product.category_id = category.id where product.name like '$search' and product.availability_id = '1' group by prod_id";
        else:
            // default header for all product
            echo '<h2>All Product</h2>';
        endif; // end if get category
        echo '</blockquote>';

        // execute sql query
        $result = $db -> query($sql) or die($db -> error);
    ?>
        <div class="container row" style="margin-top: 3rem;">
            <?php while($result -> num_rows > 0 and $data = $result -> fetch_assoc()): // output product -- by category / search / all product ?>
            <a href="product-detail.php?product=<?php echo $data['prod_id'] ?>">
                <div class="col s12 m6 l3">
                    <div class="card hoverable">
                        <div class="card-image">
                            <img class="" src="database/retrieve-img.php?id=<?php echo $data['img_id'] ?>">
                        </div>
                        <div class="card-content" style="height: 8rem;">
                            <span class="black-text"><h6><?php echo $data['prod_name'] ?></h6></span>
                        </div>
                        <div class="card-action">
                            <h5>
                                from RM <?php echo number_format($data['prod_price'],2); ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
            <?php if($result -> num_rows == 0 and isset($_GET['search'])): ?>
            <div class="col s12 m12 l12">
                <h5> Your search for <b style="padding: 0 0.5rem;" class="grey lighten-1"><?php echo $_GET['search']; ?></b> did not yield any results. </h5>
            </div>
            <?php endif;?>
        </div>
    
    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script>
        $(()=>{
            $('#product-page').addClass("active")
        })
    </script>
</body>
</html>