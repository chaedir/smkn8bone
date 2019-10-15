<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<!-- SUBMIT BUTTON configuration -->
<?php
if (isset($_POST["Submit"])) {
    $Kontak1 = mysqli_real_escape_string($Connection, $_POST["Kontak1"]);
    $Kontak2 = mysqli_real_escape_string($Connection, $_POST["Kontak2"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%A %H:%M - %d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];

    if (empty($Kontak1)) {
        $_SESSION["ErrorMessage"] = "Address can't be empty";
        Redirect_to("manageKontak.php");
    } elseif (strlen($Kontak1) < 2) {
        $_SESSION["ErrorMessage"] = "Address should be at-least 2 character";
        Redirect_to("manageKontak.php");
    } else {
        //global $Connection;
        $EditIDFromURL = $_GET["edit"];
        $Query = mysqli_query($Connection, "UPDATE contact SET datetime='" . $DateTime . "', author='" . $Admin . "', kontak1='" . $Kontak1 . "', kontak2='" . $Kontak2 . "' WHERE id = '" . $EditIDFromURL . "'");

        if ($Query) {
            $_SESSION["SuccessMessage"] = "Address updated successfully";
            Redirect_to("manageKontak.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
            Redirect_to("manageKontak.php");
        }
    }
}
?>
<!-- end of SUBMIT BUTTON configuration -->
<!DOCTYPE html>
<html lang="en">
<!-- Head Area -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/adminstyles.css?v=<?php echo time(); ?>" />

    <!-- <script src="js/jQuery3.4.1.js"></script> -->

    <!-- <script src="js/bootstrap.min.js"></script> -->

    <title>Edit Address</title>
</head>
<!-- End Of Head Area -->

<!-- Body Area -->
<body>
    <!-- NAVBAR AREA -->
    <div id="head-background1">
    </div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="blog.php?Page=1" class="navbar-brand">
                    <img id="logo" src="images/smkn8bone_logo.png">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php" target="_blank">Home Blog</a></li>
                    <li><a href="about.php" target="_blank">About School</a></li>
                    <li><a href="gallery.php?Page=1" target="_blank">Gallery</a></li>
                    <li><a href="blog.php?Page=1" target="_blank">News</a></li>
                    <li><a href="kontak.php" target="_blank">Address</a></li>                    
                </ul>
                <!-- <form action="blog.php?Page=1" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                    </div>
                    <button class="btn btn-default" name="searchButton">Go</button>
                </form> -->
            </div>
        </div>
    </nav>
    <div id="head-background2">
    </div>
    <!-- END OF NAVBAR AREA -->

    <!-- Main Area -->
    <div class="container-fluid">
        <div class="row">
            <!-- Left area-->
            <div class="col-sm-2">
                <br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php?Page=1"> <span class="glyphicon glyphicon-th"></span>
                            &nbsp;Dashboard</a></li>
                    <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                            &nbsp;Categories</a></li>
                    <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>
                            &nbsp;Manage Admin</a></li>
                    <li><a href="dashBeranda.php"> <span class="glyphicon glyphicon-home"></span>
                            &nbsp;Manage Beranda</a></li>
                    <li><a href="dashTentang.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Tentang Sekolah</a></li>
                    <li><a href="manageGaleri.php?Page=1"> <span class="glyphicon glyphicon-picture"></span>
                            &nbsp;Manage Galeri</a></li>
                    <li class="active"><a href="manageKontak.php"><span class="glyphicon glyphicon-road"></span>
                            &nbsp;Manage Address</a></li>
                    <li><a href="comments.php?Page=1"><span class="glyphicon glyphicon-comment"></span>
                            &nbsp;Comments

                            <?php
                            $queryUnApproved = $Connection->query("SELECT COUNT(*) FROM comments WHERE status='OFF'");
                            $rowsUnApproved = mysqli_fetch_array($queryUnApproved);
                            $totalUnApproved = array_shift($rowsUnApproved);

                            if ($totalUnApproved > 0) {
                                ?>
                            <span class="label pull-right label-warning">
                                <?php echo $totalUnApproved; ?>
                            </span>
                            <?php } ?>

                        </a></li>
                    <!-- <li><a href="blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li> -->
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!--end of Left area-->

            <!-- Right Area -->
            <div class="col-sm-10">
                <h1>Update Address</h1>
                <!-- MESSAGE area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End of MESSAGE area -->

                <!-- EDIT area -->
                <div>
                    <?php
                    $EditIDFromURL = $_GET["edit"];
                    $viewQuery = $Connection->query("SELECT * FROM contact WHERE id=' $EditIDFromURL'");
                    while ($fetchData = mysqli_fetch_array($viewQuery)) {
                        $Id = $fetchData["id"];
                        $DateTime = $fetchData["datetime"];
                        $Admin = $fetchData["author"];
                        $Kontak1 = $fetchData["kontak1"];
                        $Kontak2 = $fetchData["kontak2"];
                        ?>

                    <form action="editKontak.php?edit=<?php echo $EditIDFromURL; ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="address1"><span class="Fieldinfo">Address 1:</span></label>
                                <input value="<?php echo $Kontak1; ?>" class="form-control" type="text" name="Kontak1" id="adress_1" placeholder="Address 1">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="address2"><span class="Fieldinfo">Address 2:</span></label>
                                <input value="<?php echo $Kontak2; ?>" class="form-control" type="text" name="Kontak2" id="adress_2" placeholder="Address 2">
                                <br>
                            </div>

                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Update Address">
                            <br>
                        </fieldset>
                    </form>
                    <?php } ?>
                </div>
                <!--end of EDIT area -->
            </div>
            <!-- End Of Right Area -->
        </div>
    </div>
    <!-- End Of Main Area -->

    <!-- Footer Area -->
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>
    <!-- End Of Footer Area -->
</body>
<!-- End Of Body Area -->
</html>