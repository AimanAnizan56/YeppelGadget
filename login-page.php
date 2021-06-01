<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Yeppel</title>
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
                    <div class="col l6 hide-on-med-and-down">
                        <img src="image/login-img.jpg" alt="" class="responsive-img hide-on-small-only">
                    </div>
                    <div class="col l6 m12 s12">
                        <h3 class="brand-heading center-align">SIGN IN</h3>
                        <div style="margin-top: 4rem;"></div>
                        <form action="database/login-auth.php" method="post">
                            <div class="input-field">
                                <i class="material-icons prefix">fingerprint</i>
                                <input type="text" name="username" id="username" class="validate" value="<?php if(isset($_COOKIE['username'])){ echo $_COOKIE['username']; } else echo "" ?>" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field">
                                <i id="password-icon" class="material-icons prefix">lock</i>
                                <input type="password" name="password" id="password" class="validate" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; } ?>" required>
                                <label for="password">Password</label>
                            </div>
                            <label style="margin-left: 3rem; display: block">
                                <input type="checkbox" name="remember" id="remember">
                                <span>Remember me</span>
                            </label>
                            <button type="submit" style="width: 100%; margin-bottom: 1rem; margin-top: 1rem" class="waves-effect waves-light btn light-blue darken-1">LOGIN</button>
                            <a href="index.php" style="width: 100%; margin-bottom: 1rem" class="waves-effect waves-light btn grey lighten-5 black-text">CANCEL</a>
                            <a href="create-acc-page.php">Create account</a>
                        </form>
                    </div>
                </div>
            </div>
    </div>

    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
</body>
</html>