<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account |  Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">
    
    <!-- Content Delivery Network -->
    <?php include("component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="grey lighten-3">
    <div class="container">
        <div class="" style="margin-top:3rem"></div>
            <div class="card-panel">
                <div class="row">
                    <div class="col l6 m6 hide-on-med-and-down">
                        <img src="image/login-img.jpg" alt="" class="responsive-img fix-img hide-on-small-only">
                    </div>
                    <div class="col l6 m12 s12">
                        <h3 class="brand-heading center-align">Create Account</h3>
                        <div style="margin-top: 1rem;"></div>
                        <form id="form" action="database/create_acc.php" method="post">
                            <div class="input-field">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="name" id="name" class="validate" required>
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">fingerprint</i>
                                <input type="text" name="username" id="username" class="validate" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <input type="text" name="address" id="address" class="validate" required>
                                <label for="address">Address</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="password" id="password" class="validate" required>
                                <label for="password">Password</label>
                            </div>
                            <label class="input-field" style="margin-left: 3rem; display: block">
                                <input type="checkbox" name="agreement" id="agreement" required>
                                <span>I agree with term and conditions</span>
                            </label>
                            <button type="button" id="create-acc" disabled style="width: 100%; margin-bottom: 1rem; margin-top: 1rem" class="waves-effect waves-light btn light-blue darken-1">SIGN UP</button>
                            <a href="index.php" style="width: 100%; margin-bottom: 1rem" class="waves-effect waves-light btn grey lighten-5 black-text">CANCEL</a>
                            <a href="login-page.php">Login account</a>
                        </form>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal" id="confirmation-box" style="width: 25rem">
        <div class="modal-content">
            <h4 class="center-align" style="margin-top: 1rem;">Create account?</h4>
            <div class="right" style="padding: 1rem 0;">
                <button type="button" id="confirm" class="btn waves-effect waves-light light-blue darken-1" href="">Create</button>
                <button type="button" id="confirmation-close" class="btn waves-effect waves-light white black-text" href="">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script>
        $(()=>{
            $("#create-acc").click(()=>{
                // check if there is empty field of input
                if($("#name").val() == ""){
                    $("#name").focus();
                    return;
                }
                if($("#username").val() == ""){
                    $("#username").focus();
                    return;
                }
                if($("#address").val() == ""){
                    $("#address").focus();
                    return;
                }
                if($("#password").val() == ""){
                    $("#password").focus();
                    return;
                }
                // open confirmation modal -- get confirmation from user
                $("#confirmation-box").modal("open");
            })
            // close confirmation modal -- if user clicked button no
            $("#confirmation-close").click(()=>{
                $("#confirmation-box").modal("close");
            });
            // add event for confirm button clicked -- submit form to another file.
            $("#confirm").click(()=>{
                $("#form").submit();
            });
        })
    </script>
</body>
</html>