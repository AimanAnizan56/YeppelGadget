<?php
    require_once("../../database/config.php");
    $db = Database::getInstance();

    $product_id = $db -> real_escape_string($_POST['product_id']);
    $current_availability = $db -> query("SELECT availability_id FROM product WHERE id = '$product_id'") -> fetch_assoc()['availability_id'] or die('Query Error: '.$db -> error);

    if($current_availability == '1') {
        $db -> query("UPDATE product SET availability_id = '2' WHERE id = '$product_id'") or die ('Query Error: '.$db -> error);
    } else {
        $db -> query("UPDATE product SET availability_id = '1' WHERE id = '$product_id'") or die ('Query Error: '.$db -> error);
    }

    if($db -> affected_rows == 1) {
        echo "changed";
    }
?>