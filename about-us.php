<?php
    session_start();
    // database class
    require_once('database/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Yeppel</title>
    <link rel="shortcut icon" href="image/favicon2.png" type="image/x-icon">

    <!-- Content Delivery Network - CSS -->
    <?php include("component/cdn-css.php"); ?>
    <!-- Customize CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .image-table {
            width: 10vw;
        }
        th, td{
            border: 1px solid rgba(0,0,0,0.12);
        }
        th {
            padding-left: 1rem;
        }
    </style>
</head>
<body class="grey lighten-3">
    <!-- Navigation bar -->
    <?php include("component/navigation.php"); ?>

    <div class="row container" style="margin-top: 1rem; width: 60vw">
        <table class="centered card-panel z-depth-5">
            <caption>
                <h2><i>Group Member's Information</i></h2>
            </caption>

            <tr>
                <td></td>
                <td>
                    <img class="image-table center-block" src="image/aiman_anizan.JPG" alt=""> <br>
                </td>
                <td>
                    <img class="image-table center-block" src="image/aiman_anizan.JPG" alt=""> <br>
                </td>
                <td>
                    <img class="image-table center-block" src="image/aiman_anizan.JPG" alt=""> <br>
                </td>
            </tr>
            <tr>
                <th>Name</th>
                <td>
                    <div class="center-block" style="width: 10vw">
                        <i><b>Aiman bin Anizan</b></i>
                    </div>
                </td>
                <td>
                    <div class="center-block" style="width: 10vw">
                        <i><b>Mohamad Syahmi Hafiz bin Mohamad Saufi</b></i>
                    </div>
                </td>
                <td>
                    <div class="center-block" style="width: 10vw">
                        <i><b>Aiman bin Azhar</b></i>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Student Number</th>
                <td>
                    <i>2018659558</i>
                </td>
                <td>
                    <i>2018659558</i>
                </td>
                <td>
                    <i>2018659558</i>
                </td>
            </tr>
            <tr>
                <th>Group</th>
                <td>
                    <i>CS110 5D</i>
                </td>
                <td>
                    <i>CS110 5D</i>
                </td>
                <td>
                    <i>CS110 5D</i>
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td><a href="mailto:anizanaiman@gmail.com"><b><i>anizanaiman@gmail.com</i></b></a></td>
                <td><a href="mailto:anizanaiman@gmail.com"><b><i>anizanaiman@gmail.com</i></b></a></td>
                <td><a href="mailto:anizanaiman@gmail.com"><b><i>anizanaiman@gmail.com</i></b></a></td>
            </tr>
            <!-- <thead>
                <tr>
                    <th>Name</th>
                    <th>Student Number</th>
                    <th>Group</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img class="image-table" src="image/aiman_anizan.JPG" alt=""> <br>
                        Aiman bin Anizan
                    </td>
                    <td>2018659558</td>
                    <td>CS110 5D</td>
                    <td>
                        <a href="mailto:anizanaiman@gmail.com">anizanaiman@gmail.com</a>
                    </td>
                </tr>
            </tbody> -->
        </table>
    </div>
    <!-- Content Delivery Network - JS -->
    <?php include("component/cdn-js.php"); ?>
    <!-- Customize Javascript -->
    <script src="js/main.js"></script>
    <script src="js/carousel-with-slider.js"></script>
    <script>
        $(()=>{
            $('#about-page').addClass("active")
        })
    </script>
</body>
</html>