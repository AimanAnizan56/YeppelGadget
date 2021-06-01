<?php
    require_once("../../database/config.php");
    $db = Database::getInstance();
    $sql = "SELECT product.id as prod_id, product.name as prod_name, product.price as prod_price, product.availability_id as prod_availability, image.id as img_id from product inner join image on product.id = image.product_id group by prod_id";
    $result = $db -> query($sql);
?>
<div class="row">
    <h4>Click button to change availability</h4>
    <?php while($result -> num_rows > 0 and $data = $result -> fetch_assoc()): // output product -- by category / search / all product ?>
    <a>
        <div class="col s12 m6 l3">
            <div class="card">
                <div class="card-image">
                    <img class="" src="../database/retrieve-img.php?id=<?php echo $data['img_id'] ?>">
                </div>
                <div class="card-content" style="height: 8rem;">
                    <span class="black-text"><h6><?php echo $data['prod_name'] ?></h6></span>
                    <h6> Price: RM <?php echo number_format($data['prod_price'],2); ?> </h6>
                </div>
                <div class="card-action center">
                    <?php if(strtolower($data['prod_availability']) == "1"): ?>
                    <button class="btn light-blue darken-1 waves-effect waves-light" onclick="changeAvailability(<?php echo $data['prod_id']; ?>)">
                        Available
                    </button>
                    <?php else: ?>
                    <button class="btn red darken-1 waves-effect waves-light" onclick="changeAvailability(<?php echo $data['prod_id']; ?>)">
                        Not Available
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </a>
    <?php endwhile; ?>
</div>