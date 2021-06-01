<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Yeppel</title>
    <link rel="shortcut icon" href="../image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("../component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .modal{
            width: 28vw;
            padding: 0 10px;
        }
    </style>

    <!-- Content Delivery Network - JS -->
    <?php include("../component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="../js/main.js"></script>
    <script>
        
    </script>
</head>
<body>
    <!-- modal popup -->
    <div class="modal" id="output-modal">
        <div class="modal-content center-align">
            <h3 id="modal-head"></h3>
            <p id="modal-body"></p>
        </div>
        <div class="modal-footer">
            <a id="btn-cont" class="modal-close waves-effect btn"></a>
        </div>
    </div>
<?php
    if(isset($_POST)):
        /* Get instance of mysql connection */
        require_once("config.php");
        $db = Database::getInstance();

        /* Escape string for security purpose */
        $username = $db -> real_escape_string($_POST['username']);
        $password = $db -> real_escape_string($_POST['password']);
        
        /* Retrieve data from database by username */
        if($result = $db -> query("select user.id as id, user.username as username, user.password as password, role.type as role_type from user inner join role on user.role_id = role.id WHERE user.username = '$username'")):
            $error = true; // -- boolean to store error bool
            /* Check -- number of rows retrieved */
            if($result -> num_rows > 0){
                /* Get data and store into array */
                $data = $result->fetch_assoc();

                /* Verify passord */
                if(password_verify($password,$data['password'])){
                    $error = false; // -- assign error bool false
                    // set browser cookies to save login auth
                    if(isset($_POST['remember']) and $_POST['remember']==='on'){
                        setcookie("username",$username,time()+(7*24*60*60),"/"); //? store username into cookies for a week
                        setcookie("password",$password,time()+(7*24*60*60),"/"); //? store password into cookies for a week
                    }

                    /* Start session and save data intor session array */
                    session_start();
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['role'] = $data['role_type'];
                    if(isset($_SESSION['redirect-url'])){
                        $url = $_SESSION['redirect-url']; // store url information -- exist when user clicked (add to cart) but not login yet
                        unset($_SESSION['redirect-url']); // destroy session variable for redirect-url index
                        header("Location: $url"); // redirect to current product location
                        exit; // terminate file script
                    }
                    header("Location: ../index.php"); // redirect to main index if user login from index page
                }
            }

            if($error){
                // show error -- username has already exist
                ?>
                    <script>
                        $(()=>{
                            $("#modal-head").text("Could not login !");
                            $("#modal-head").css({
                                "color": "red",
                                "font-weight": "600"
                            });
                            $("#modal-body").text("Username or password incorrect");
                            $("#btn-cont").text("Back");
                            $("#btn-cont").addClass("red darken-1")
                            $("#btn-cont").attr("href","../login-page.php");
                        });
                        $(()=>{
                        // prevent modal popup from close by overlay click
                        $('#output-modal').modal({
                            dismissible: false
                        });
                        // assign modal method
                        $('#output-modal').modal('open');
                    });
                    </script>
                <?php
            }
        endif; // endif -- query
    endif; // endif -- isset
?>
</body>
</html>
