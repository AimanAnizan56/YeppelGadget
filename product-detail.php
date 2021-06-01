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
    <style>
        .modal{
            width: 20vw;
            padding: 0 10px;
        }
        #description, #description > ol{
            font-size: 1.7rem!important;
            text-align: justify!important; 
        }
    </style>
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <?php
        // get product id -- user selected
        if (isset($_GET['product'])):
            // escape string before inserting into database
            $searchId = $db -> real_escape_string($_GET['product']);
            // begin query -- get product details including all image for the product
            $result = $db -> query("SELECT product.id as prod_id, product.name as prod_name, product.price as prod_price, product.description as description,  image.id as img_id, image.name as img_name from product inner join image on product.id = image.product_id where product.id = $searchId;");
            
            ?>
                <div class="row card-panel z-depth-5" style="transform: scale(0.85); margin-top: -2rem">
                    <div class="col s12 m12 l6">
                        <div class="carousel carousel-slider center z-depth-3">
                            <?php while($data = $result -> fetch_assoc()): // make loop to display all image with carousel slider ?>
                            <div class="carousel-item">
                                <img class="carousel-product" src="database/retrieve-img.php?id=<?php echo $data['img_id']; ?>" alt="<?php echo $data['img_name']; ?>">
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <?php
                            $result -> data_seek(0); // change index of row to 0
                            $detail = $result -> fetch_assoc(); // retrieve associative array
                        ?>
                        <div class="col l12">
                            <h1 class="bold"><?php echo $detail['prod_name']; ?></h1>
                        </div>
                        <div class="col l12">
                            <h1 class="card-panel"><span class="blue-text"> RM <?php echo number_format($detail['prod_price'],2); ?></span> </h1>
                        </div>
                        <div class="col l12" style="margin-bottom: 2rem;">
                            <div id="description">
                                <?php echo $detail['description']; ?>
                            </div>
                        </div>
                        <div class="col l12">
                            <button onclick="addItem('<?php echo $_GET['product']; ?>')" name="add-to-cart" class="btn btn-large waves-effect waves-block light-blue darken-1" style="width: 100%">
                                <i class="material-icons" style="position: absolute; margin-left: 7rem">add_shopping_cart</i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php
        endif;
        
    ?>
    <div id="added-to-cart" class="modal">
        <div class="modal-content">
            <i class="material-icons center green-text text-darken-1" style="width: 100%; font-size: 10rem">check_circle</i>
            <h4 class="center">Added to cart</h4>
        </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script src="js/carousel-normal.js"></script>
    <script>
        
        $(()=>{
            $('#product-page').addClass("active");
            // assign modal method
            $('#added-to-cart').modal({ // customize modal popup to display (add to cart) message
                endingTop: "30%", // margin top
                dismissible: true, // make modal dismissible with keyboard and mouse
                inDuration: 500, // duration for modal popup in
                outDuration: 500 // duration fro modal popup out
            });
        })
        function addItem(productId){
            // perform ajax post http request
            $.post("user/add-item.php" /* Path file */,{
                product_id: productId // variable to pass
            },
            (data, status)=>{
                // status -- success/failed to execute
                // data -- output from file
                // succed added to cart
                if(data === "added to cart"){
                    // open modal popup -- added to cart with icon
                    $('#added-to-cart').modal("open");
                    // execute function after 1 sec 
                    setTimeout(()=>{
                        $("#added-to-cart").modal("close"); // close modal after 1 sec
                    },1000);
                }
                if (data == "login required") {
                    window.location.replace("login-page.php"); // redirect to login page
                }
            }
            );
        }
    </script>
</body>
</html>