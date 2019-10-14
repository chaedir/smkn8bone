<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<!-- SUBMIT BUTTON configuration -->
<!-- <?php
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
                $_SESSION["ErrorMessage"] = "GAGAL! Kontak tidak boleh dikosongkan!";
                Redirect_to("manageKontak.php");
            } elseif (strlen($Kontak1) < 2) {
                $_SESSION["ErrorMessage"] = "GAGAL! Kontak tidak boleh kurang dari 2 huruf!";
                Redirect_to("manageKontak.php");
            } else {
                //global $Connection;        
                $Query = mysqli_query($Connection, "INSERT INTO contact (datetime,author,kontak1,kontak2) VALUES('" . $DateTime . "','" . $Admin . "','" . $Kontak1 . "','" . $Kontak2 . "')");
                move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
                if ($Query) {
                    $_SESSION["SuccessMessage"] = "Sukses menambahkan ke Kontak !";
                    Redirect_to("manageKontak.php");
                } else {
                    $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
                    Redirect_to("manageKontak.php");
                }
            }
        }
        ?> -->
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

    <title>Manage Contact</title>
</head>

<body>
    <!-- NAVBAR area -->
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
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="backup.php?Page=1" target="_blank">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Feature</a></li>
                </ul>
                <form action="blog.php?Page=1" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                    </div>
                    <button class="btn btn-default" name="searchButton">Go</button>
                </form>
            </div>
        </div>
    </nav>
    <div id="head-background2">
    </div>
    <!-- end of NAVBAR area -->

    <!-- CONTAINER area -->
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

            <!--MAIN area-->
            <div class="col-sm-10">
                <h1>Manage Address</h1>
                <!-- MESSAGE area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End of MESSAGE area -->

                <!-- ADD NEW DATA area -->
                <!-- <div>
                    <form action="manageKontak.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="Kontak1"><span class="Fieldinfo">Address 1:</span></label>
                                <input class="form-control" type="text" name="Kontak1" id="Kontak1" placeholder="Kontak1">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="Kontak2"><span class="Fieldinfo">Address 2:</span></label>
                                <input class="form-control" type="text" name="Kontak2" id="Kontak2" placeholder="Kontak2">
                            </div>

                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Contact">
                        </fieldset>
                        <br>
                    </form>
                </div> -->
                <!-- end of ADD NEW DATA area -->

                <!-- SHOW DATA area -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>

                        <?php
                        $viewQuery = $Connection->query("SELECT * FROM contact");
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $Id = $fetchData["id"];
                            $DateTime = $fetchData["datetime"];
                            $Admin = $fetchData["author"];
                            $Kontak1 = $fetchData["kontak1"];
                            $Kontak2 = $fetchData["kontak2"];
                            ?>
                        <tr>
                            <td><?php echo $DateTime; ?></td>
                            <td>
                                <?php
                                    if (strlen($Admin) > 40) {
                                        $Admin = substr($Admin, 0, 40) . '...';
                                    }
                                    echo $Admin;
                                    ?>
                            </td>
                            <td>
                                <?php
                                    if (strlen($Kontak1) > 40) {
                                        $Kontak1 = substr($Kontak1, 0, 40) . '...';
                                    }
                                    echo $Kontak1;
                                    ?>
                            </td>
                            <td>
                                <?php
                                    if (strlen($Kontak2) > 40) {
                                        $Kontak2 = substr($Kontak2, 0, 40) . '...';
                                    }
                                    echo $Kontak2;
                                    ?>
                            </td>
                            <td>
                                <a href="editKontak.php?edit=<?php echo $Id; ?>">
                                    <span class="btn btn-warning" style="margin: 2px 0;">Edit</span></a>
                            </td>
                            <td>
                                <a href="kontak.php" target="_blank">
                                    <span class="btn btn-primary" style="margin: 2px 0;">Live Preview</span></a>
                            </td>
                            <!-- <td><?php echo $Post; ?></td> -->
                        </tr>
                        <?php } ?>


                    </table>
                </div>
                <!-- SHOW DATA area -->
            </div>
            <!--end of MAIN area-->
        </div>
    </div>
    <!-- end of CONTAINER area -->

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>