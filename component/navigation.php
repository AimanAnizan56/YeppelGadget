<?php
    if(isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
        header("location: admin/homepage.php");
    }
?>
<div class="navbar-fixed">
    <nav class="nav-wrapper light-blue darken-1">
        <a href="index.php" class="brand-logo brand-heading">Yeppel</a>
        <a href="#" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right hide-on-med-and-down menu">
            <li><i id="search-icon" class="material-icons tooltipped" data-position="bottom" data-tooltip="Search" style="margin-right: 1.3rem; margin-top: 0.2rem">search</i></li>
            <li id="home-page" class=""><a href="index.php">Home</a></li>
            <li id="product-page" class=""><a href="product.php">Product</a></li>
            <li id="about-page" class=""><a href="about-us.php">About</a></li>
            <?php
                /* Check if user already login or not */
                if(isset($_SESSION['username'])) {
                    /* Output username at navigation bar */
                    ?> 
                    <li id="profile-page"><a href="#" class="dropdown-trigger" data-target="dropdown-user">
                        <?php echo $_SESSION['username']; ?></a> <!-- Output username -- replaced login button -->
                    </li> 

                    <ul id="dropdown-user" class="dropdown-content">
                        <li><a class="light-blue-text text-darken-1" href="profile.php">My Account</a></li>
                        <li><a class="light-blue-text text-darken-1" href="my-purchase.php">My Purchase</a></li>
                        <li><a class="light-blue-text text-darken-1" href="database/logout.php">Logout</a></li>
                    </ul>
                    <?php
                }else {
                    ?> <li><a href="login-page.php">Login</a></li> <?php // default login button -- useer did not login yet
                }
            ?>
        </ul>
        <a href="cart.php" class="brand-logo right cart tooltipped" data-position="left" data-tooltip="View Cart" style="margin-top: 0.2rem;"><i class="material-icons cart">shopping_cart</i></a>
    </nav>
</div>

<div class="modal" id="search-box" style="width: 30rem;">
    <form action="product.php" method="GET" class="modal-content">
        <span class="data input-field">
            <i class="material-icons prefix">search</i>
            <input type="text" class="validate" name="search" id="search" required>
            <label for="search">Search</label>
        </span>
        <span>
            <button type="submit" class="waves-effect waves-light btn light-blue darken-1" style="width: 100%; margin: 0.5rem 0">Search</button>
        </span>
    </form>
</div>