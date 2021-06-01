<?php
    // retrieve database static class
    require_once('config.php');
    // get instace of mysqli connection
    $db = Database::getInstance();

    // *** USE THIS HTML TAG TO RETRIEVE IMAGE ***
    // *** <img src="retrieve-img.php?id=0001"> ***

    // check if method get --- id index
    if(isset($_GET['id'])){
        // escape string before retrieve data from database
        $id = $db -> real_escape_string($_GET['id']);

        // execute query
        if($result = $db -> query("SELECT type,data FROM image WHERE id='$id'")){
            // check row retrieved and fetch data into a array
            if($result -> num_rows === 1 and $image = $result -> fetch_assoc()){
                // indicate media type -- image
                header("Content-Type: ".$image['type']);
                // output data of image
                echo $image['data'];
            }else {
                // output error image
                errorImage();
            }
        }
    }else errorImage();

    // display error image -- no image
    function errorImage(){
        $error = file_get_contents("../image/no_photo.png");
        header("content-type: image/png");
        echo $error;
    }
?>