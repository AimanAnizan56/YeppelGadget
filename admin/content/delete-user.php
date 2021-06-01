<?php
    session_start();
    //print_r($_SESSION);
    // check if user is admin
    if($_SESSION['role'] == "admin"):
        // get instance of mysqli class
        require_once("../../database/config.php");
        $db = Database::getInstance();

        // escape string
        $user_id = $db -> real_escape_string($_POST['user_id']);
        $sql = "DELETE FROM user WHERE id = '$user_id'";
        // query -- delete user
        $db -> query($sql) or die("Query Error: ".$db -> error);

        // check affected row
        if($db -> affected_rows == 1){
            echo 'deleted';
        }else {
            echo 'something wrong: '.$sql;
        }
    endif;
?>