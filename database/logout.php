<?php
    session_start();
    /* Destroy session data */
    if(session_destroy()) {
        header("location: ../index.php"); // redirect to main page
    }
?>