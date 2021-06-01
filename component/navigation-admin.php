<?php
    if (!isset($_SESSION['role']) or $_SESSION['role'] != 'admin') {
        header("location: ../index.php");
        echo '<script>alert("safdddfasdf");</script>';
    }
?>
<div class="navbar-fixed">
    <nav class="nav-wrapper light-blue darken-1">
        <a href="index.php" class="brand-logo brand-heading">Yeppel</a>
        <a href="#" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down menu">
            <li id="home-page" class=""><a href="homepage.php">Home</a></li>
            <?php
                /* Check if user already login or not */
                if (isset($_SESSION['username'])) {
                    /* Output username at navigation bar */ ?> 
                    <li id="profile-page"><a href="#" class="dropdown-trigger" data-target="dropdown-user">
                        <?php echo $_SESSION['username']; ?></a> <!-- Output username -- replaced login button -->
                    </li> 

                    <ul id="dropdown-user" class="dropdown-content">
                        <li><a class="light-blue-text text-darken-1" href="profile-admin.php">My Account</a></li>
                        <li><a class="light-blue-text text-darken-1" href="../database/logout.php">Logout</a></li>
                    </ul>
                    <?php
                } else {
                    ?> <li><a href="login-page.php">Login</a></li> <?php // default login button -- useer did not login yet
                }
            ?>
        </ul>
        <label class="brand-logo right cart tooltipped" data-position="left" data-tooltip="Administrator" style="margin-top: 0.2rem;"><i class="material-icons cart">person</i></label>
    </nav>
</div>