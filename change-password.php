<?php 
    session_start();
    require_once('database/config.php');
    $updated = false
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Develivery Network - CSS -->
    <?php include("component/cdn-css.php") ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include("component/navigation.php") ?>

    <div class="container">
        <div class="s12 card card-acc white">
            <form action="" method="post">
                <div class="row">
                    <blockquote class="col s12" style="border-left-color: #039be5;">
                        <h4 style="margin-top: 0;">Change Password</h4>
                        <span>For your account's security, do not share your password with anyone else</span>
                    </blockquote>
                </div>
                <hr>
                <!-- Current Password -->
                <div class="row margin-top-2">
                    <div class="col s1"></div>
                    <div class="col s3">
                        <span class="type">Current Password</span>
                    </div>
                    <div class="col s8">
                        <span class="data input-field">
                            <input type="password" name="current_password" id="current_password" required>
                        </span>
                    </div>
                </div>
                <!-- New Password -->
                <div class="row margin-top-2">
                    <div class="col s1"></div>
                    <div class="col s3">
                        <span class="type">New Password</span>
                    </div>
                    <div class="col s8">
                        <span class="data input-field">
                            <input type="password" name="new_password" id="new_password">
                        </span>
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="row margin-top-2">
                    <div class="col s1"></div>
                    <div class="col s3">
                        <span class="type">Confirm Password</span>
                    </div>
                    <div class="col s8">
                        <span class="data input-field">
                            <input type="password" name="confirm_password" id="confirm_password">
                            <span class="helper-text" for="confirm_password" data-error="wrong" data-success="right"></span>
                        </span>
                    </div>
                </div>
                <div class="row margin-top-2">
                    <div class="col s4"></div>
                    <div class="col s7">
                        <button id="confirm_btn" type="submit" name="confirm" disabled class="waves-effect waves-light btn light-blue darken-1"><i class="material-icons left">save</i>confirm</button>
                    </div>
                </div>
            </form>
            <!-- Password Change Algorithm -->
            <?php require_once("user/password-algo.php") ?>
        </div>
    </div>
    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <!-- For passwordd corfirmation -->
    <script src="js/change-password.js"></script>
    <!-- popup -->
    <?php require_once("user/password-updated.php"); ?>
</body>
</html>