<?php
    require_once("../../database/config.php");
    $db = Database::getInstance();
    $result_category = $db -> query("SELECT id, name FROM category") or die("Query Error: ".$db -> error);
    $category = array();
    foreach($result_category as $row){
        $category[] = $row;
    }
?>
<style>
    .dropdown-content li>span {
        color: #039be5 !important;
    }
</style>
<div class="card-panel">
    <div class="row">
        <div class="col s12 center-align">
            <h4>Add New Product</h4>
        </div>
        <div class="col s12">
            <form id="product-form" enctype="multipart/form-data" onsubmit="add_product(this)">
                
                <div class="input-field col s4">
                    <input type="text" class="" name="product_name" id="product_name" required>
                    <label for="product_name">Product Name</label>
                </div>
                <div class="input-field col s4">
                    <input type="number" name="product_price" id="product_price" required>
                    <label for="product_price">Product Price</label>
                </div>
                <div class="input-field col s4">
                    <select name="product_category" id="product_category">
                        <!-- <option value="" disabled selected>Choose Category</option> -->
                        <?php foreach($category as $row): ?>
                            <option value="<?php echo $row['id'] ?>"> <?php echo $row['name']; ?> </option>
                        <?php endforeach; ?>
                        
                    </select>
                    <label>Product Category</label>
                </div>
                
                <div class="input-field col s12">
                    <textarea class="materialize-textarea" name="product_description" id="product_description" cols="30" rows="10" required></textarea>
                    <label for="product_description">Product Description</label>
                </div>

                <div class="file-field input-field col s12">
                    <div class="btn light-blue darken-1">
                        <span>Choose Image</span>
                        <input type="file" name="image[]" id="image[]" multiple required>
                    </div>
                    <div class="file-path-wrapper">
                        <input type="text" class="file-path validate" placeholder="Upload one image or more">
                    </div>
                </div>

                <div class="col s12 center">
                    <button type="submit" id="btn-add-product" class="btn btn-block waves-effect waves-light light-blue darken-1">
                        Add product
                    </button>
                </div>
                
            </form>

    </div>
</div>
<script>
    $(()=>{
        // add select option method from jquery
        $('select').formSelect();

        /* $("#product-form").submit(()=> {
            event.preventDefault();
            var form_data = $("#product-form");
            // var product_form = new FormData(form_data);
            $("manage-content").load(JSON.stringify(form_data));
        }) */

        /* $("#btn-add-product").click(()=>{
            
        }) */
    })
</script>