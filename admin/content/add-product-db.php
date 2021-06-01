<?php
    // get instance of mysqli
    require_once("../../database/config.php");
    $db = Database::getInstance();

    // escape string
    $product_name = $db -> real_escape_string($_POST['product_name']);
    $product_price = $db -> real_escape_string($_POST['product_price']);
    $product_description = $db -> real_escape_string($_POST['product_description']);
    $product_category = $db -> real_escape_string($_POST['product_category']);

    // query -- insert product details
    $db -> query("INSERT INTO product VALUES ('','$product_name','$product_price','$product_description','$product_category','1')") or die ("Query Error: ".$db -> error);

    if($db -> affected_rows === 1) {
        // name, type, tmp_name, error, size
        $product_id = $db -> query("SELECT last_insert_id() as last") -> fetch_assoc()['last'] or die ("Query Error: ".$db -> error);

        $stmt = $db -> prepare("INSERT INTO image VALUES (?,?,?,?,?,?)") or die("Could not prepare sql");
        $stmt -> bind_param("ssisbi",$param_id, $param_name, $param_size, $param_type, $param_data, $param_prod_id);
        $param_id = '';
        $param_prod_id = $product_id;
        
        for ($i=0; $i < count($_FILES['image']['name']); $i++) { 
            $param_name = $_FILES['image']['name'][$i];
            $param_size = $_FILES['image']['size'][$i];
            $param_type = $_FILES['image']['type'][$i];
            $param_data = file_get_contents($_FILES['image']['tmp_name'][$i]);
            $stmt -> send_long_data(4,$param_data);
            $stmt -> execute() or die ("Could not execute file ".$i);
        }
        echo 'successfully added';
    }


/* 
    Array
(
    [image] => Array
        (
            [name] => Array
                (
                    [0] => product interface desktop retrieved database.png
                    [1] => product interface desktop.png
                    [2] => product interface mobile retrived db.jpg
                )

            [type] => Array
                (
                    [0] => image/png
                    [1] => image/png
                    [2] => image/jpeg
                )

            [tmp_name] => Array
                (
                    [0] => D:\Web Environment\xampp\tmp\php57F5.tmp
                    [1] => D:\Web Environment\xampp\tmp\php5805.tmp
                    [2] => D:\Web Environment\xampp\tmp\php5816.tmp
                )

            [error] => Array
                (
                    [0] => 0
                    [1] => 0
                    [2] => 0
                )

            [size] => Array
                (
                    [0] => 734852
                    [1] => 326626
                    [2] => 33800
                )

        )

)
*/
?>