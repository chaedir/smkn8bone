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

<body>
    <div class="container-fluid">
        <div class="row">
            <!--SIDE area-->
            <div class="col-sm-2">
                <br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>
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
                    <li><a href="manageGaleri.php"> <span class="glyphicon glyphicon-picture"></span>
                            &nbsp;Manage Galeri</a></li>
                    <li class="active"><a href="manageKontak.php"><span class="glyphicon glyphicon-road"></span>
                            &nbsp;Manage Address</a></li>
                    <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>
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
                    <li><a href="blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!--end of SIDE area-->
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
        </div>
    </div>
    </div>

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>