<?php
    session_start();
    // database class
    require_once('database/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <!-- Carousel - Slide -->
    <div class="carousel carousel-slider center">
        <div class="carousel-fixed-item center">
            <a href="product.php" class="btn waves-effect light-blue darken-1 hoverable btn-buynow">BUY NOW</a>
        </div>
        <div class="carousel-item">
            <img class="carousel-item-img" src="image/financing-products-og-202006.jpg" alt="Image 1">
        </div>
        <div class="carousel-item">
            <img src="image/iphone.jpg" alt="Image 2">
        </div>
        <div class="carousel-item">
            <img src="image/apple-pay-apple-watch-16-9.jpeg" alt="Image 3">
        </div>
    </div>

    <div class="row container">
        <div class="col s12 center-align">
            <h3 class="bold">BROWSE BY CATEGORY</h3>
        </div>

        <?php 
        // get instance of mysql object
        $db = Database::getInstance();
        $category = $db -> query("SELECT * FROM category"); // retrieved catergory from database
        // store associative array into a variable
        while($data = $category -> fetch_assoc()):
        ?>
        <div class="col s12 m6 l4">
            <a href="product.php?category=<?php echo $data['name'] ?>">
                <div class="card hoverable">
                    <div class="card-image blue">
                        <img class="category-img" src="data:image/jpeg;base64,<?php echo base64_encode($data['image']); ?>"> <!-- Base64 -- encode binary blob into base64 to display image -->
                    </div>
                    <div class="card-content center-align">
                        <h5><?php echo strtoupper($data['name']); ?></h5>
                    </div>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script src="js/carousel-with-slider.js"></script>
    <script>
        $(()=>{
            $('#home-page').addClass("active");
        })
    </script>
</body>
</html>