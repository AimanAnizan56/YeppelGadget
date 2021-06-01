<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Create Account |  Yeppel </title>
    <link rel="shortcut icon" href="../image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("../component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .modal {
            width: 20vw;
            padding: 0 10px;
        }
    </style>

    <!-- Content Delivery Network - JS -->
    <?php include("../component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="../js/main.js"></script>
    <script>
        $(()=>{
            // prevent modal popup from close by overlay click
            $('#output-modal').modal({
                dismissible: false,
                inDuration: 500
            });
            // assign modal method
            $('#output-modal').modal('open');
        });
    </script>
</head>
<body>
    <!-- modal popup -->
    <div class="modal" id="output-modal">
        <div class="modal-content center-align">
            <h3 id="modal-head"></h3>
            <i id="icon" class='material-icons' style="font-size: 10rem;"></i>
            <p id="modal-body" style="font-size: 1.2rem;"></p>
            <a id="btn-cont" class="modal-close waves-effect btn" style="width: 100%;"></a>
        </div>
    </div>
<?php
    if(isset($_POST)):
        // database retrieve
        require_once("config.php");
        $db = Database::getInstance();

        $username = $db -> real_escape_string( $_POST['username'] ); // escape string to prevent sql injection

        if($result = $db -> query("SELECT * FROM user WHERE username='$username'")): // query to retrieve username
            // check if username have been inserted
            if($result -> num_rows > 0): 
                // show error -- username has already exist
                ?>
                    <script>
                        $(()=>{
                            $("#modal-head").text("Failed !");
                            $("#modal-head").css({
                                "color": "red",
                                "font-weight": "600"
                            });
                            $("#modal-body").text("Could not create! Username might been existed.");
                            $("#icon").addClass("red-text");
                            $("#icon").text("error");
                            $("#btn-cont").text("Back");
                            $("#btn-cont").addClass("red darken-1")
                            $("#btn-cont").attr("href","../create-acc-page.php");
                        });
                    </script>
                <?php
            else:
                // continue -- username did not exist yet
                // -- retrieve from input field
                $name = $db -> real_escape_string( $_POST['name'] );
                $address = $db -> real_escape_string( $_POST['address'] );
                $hashedPassword = $db -> real_escape_string( password_hash($_POST['password'], PASSWORD_DEFAULT) ); // hashed password
                
                // insert into database
                if($db -> query("INSERT INTO user(username,name,password,address,role_id) VALUES ('$username','$name','$hashedPassword','$address','2')")){
                    if($db -> affected_rows > 0):
                    // show success popup
                    ?>
                        <script>
                            $(()=>{
                                $("#modal-head").text("Success !");
                                $("#modal-head").css({
                                    "font-weight": "600"
                                });
                                $("#modal-head").addClass("green-text text-darken-1");
                                $("#icon").addClass("green-text text-darken-1");
                                $("#icon").text("check_circle");
                                $("#modal-body").text("Your profile has been created.");
                                $("#btn-cont").text("Okay");
                                $("#btn-cont").addClass("green darken-1");
                                $("#btn-cont").attr("href","../login-page.php");
                            });
                        </script>
                    <?php
                    endif;
                }else {
                    // print error message - query failed
                    printf(
                        "<h1 style='text-align:center'>%s</h1><div style='text-align:center'>%s</div>",
                        "ERROR",
                        "Query failed to execute!"
                    );
                }
            endif; // end if -- num_rows
        endif; // end if -- select query
    endif; // end if -- isset
?>
</body>
</html>