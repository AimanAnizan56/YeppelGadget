<?php
    session_start();
    // database class
    require_once('../database/config.php'); 
    // query code -- change profile
    require_once('../user/change-profile.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("../component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("../component/navigation-admin.php"); ?>

    <div class="container">
        <div class="s12 card card-acc white">
            <?php
                // get database instance 
                $db = Database::getInstance();
                // escape string -- prevent sql injection
                $username = $db -> real_escape_string($_SESSION['username']);

                // retrieve column from database by username
                if($result = $db -> query("SELECT * FROM user WHERE username='$username' ")):
                    // check if column retrieved 1
                    if($result->num_rows===1):
                        // fetching data and store as array
                        $data = $result->fetch_assoc();
                        ?>
                            <form action="" method="post">
                                <div class="row">
                                    <blockquote class="col s12" style="border-left-color: #039be5;">
                                        <h4 style="margin-top: 0;">My Profile</h4>
                                        <span>Manage your account</span>
                                    </blockquote>
                                </div>
                                <hr>
                                <!-- Username -->
                                <div class="row margin-top-2">
                                    <div class="col s1"></div>
                                    <div class="col s3">
                                        <span class="type">Username</span>
                                    </div>
                                    <div class="col s8">
                                        <span class="data">
                                            <?php echo $data['username'] ?>
                                            <!-- <input disabled type="text" value=""> -->
                                        </span>
                                    </div>
                                </div>
                                <!-- Name -->
                                <div class="row margin-top-2">
                                    <div class="col s1"></div>
                                    <div class="col s3">
                                        <span class="type">Name</span>
                                    </div>
                                    <div class="col s8">
                                        <span class="data input-field">
                                            <input type="text" name="name" id="name" value="<?php echo $data['name'] ?>">
                                        </span>
                                    </div>
                                </div>
                                <!-- Address -->
                                <div class="row margin-top-2">
                                    <div class="col s1"></div>
                                    <div class="col s3">
                                        <span class="type">Address</span>
                                    </div>
                                    <div class="col s8">
                                        <span class="data input-field">
                                            <textarea class="materialize-textarea" name="address" id="address"><?php echo $data['address'] ?></textarea>
                                        </span>
                                    </div>
                                </div>
                                <!-- Date created -->
                                <div class="row margin-top-2">
                                    <div class="col s1"></div>
                                    <div class="col s3">
                                        <span class="type">Created At</span>
                                    </div>
                                    <div class="col s8">
                                        <span class="data">
                                            <?php echo date("d F Y", strtotime($data['created_at'])); ?>
                                            <!-- <input disabled type="text" value=""> -->
                                        </span>
                                    </div>
                                </div>
                                <div class="row margin-top-2">
                                    <div class="col s4"></div>
                                    <div class="col s7">
                                        <button type="submit" name="save" class="waves-effect waves-light btn light-blue darken-1"><i class="material-icons left">save</i>Save</button>
                                        <a href="change-password-admin.php" class="waves-effect waves-light btn light-blue darken-1">Change Password</a>
                                    </div>
                                </div>
                            </form>
                        <?php
                    endif; // result
                endif; // query
            ?>
        </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("../component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="../js/main.js"></script>
    <script>
        $(()=>{
            $('#profile-page').addClass("active")
        })
    </script>
    <?php require_once("../user/profile-updated.php"); ?>
</body>
</html>