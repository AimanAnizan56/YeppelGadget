<?php
    $updated = false;
    // check -- button save clicked
    if(isset($_POST['save'])){
        if($_SESSION['role'] == 'admin'){
            require_once('../database/config.php');
        }else {
            require_once('database/config.php');
        }
        
        // get instance of mysql
        $db = Database::getInstance();

        /* Escape string -- prevent sql injection */
        $name = $db -> real_escape_string($_POST['name']);
        $address = $db -> real_escape_string($_POST['address']);
        $username = $db -> real_escape_string($_SESSION['username']);

        /* SQL update query */
        if($db -> query("UPDATE user set name='$name',address='$address'  where username='$username'")){
            if($db->affected_rows===1){
                $updated = true;
            }
        }
    }
?>