<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<!-- Submit Code Area -->
<?php
if (isset($_POST["Submit"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    //$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%d %B %Y  %H:%M:%S", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("manageadmin.php");
    } elseif (strlen($Password) < 4) {
        $_SESSION["ErrorMessage"] = "Minimal 4 karakter untuk Admin Password, coba lagi!";
        Redirect_to("manageadmin.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Password dan ConfirmPassword tidak sama, coba lagi!";
        Redirect_to("manageadmin.php");
    } else {
        //global $Connection;
        $Query = mysqli_query($Connection, "INSERT INTO registration (datetime,username,password,addedby) VALUES('" . $DateTime . "','" . $Username . "','" . $Password . "','" . $Admin . "')");
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Admin added successfully";
            Redirect_to("manageadmin.php");
        } else {
            $_SESSION["ErrorMessage"] = "Admin failed to add";
            Redirect_to("manageadmin.php");
        }
    }
}
?>
<!-- End Of Submit Code Area -->
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
    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" /> 

    <title>Manage Admin</title>
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
            <!-- Left Area -->
            <div class="col-sm-2">
                <br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php?Page=1"> <span class="glyphicon glyphicon-th"></span>
                            &nbsp;Dashboard</a></li>
                    <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                            &nbsp;Categories</a></li>
                    <li class="active"><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>
                            &nbsp;Manage Admin</a></li>
                    <li><a href="dashBeranda.php"> <span class="glyphicon glyphicon-home"></span>
                            &nbsp;Manage Beranda</a></li>
                    <li><a href="dashTentang.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Tentang Sekolah</a></li>
                    <li><a href="manageGaleri.php?Page=1"> <span class="glyphicon glyphicon-picture"></span>
                            &nbsp;Manage Galeri</a></li>
                    <li><a href="manageKontak.php"><span class="glyphicon glyphicon-road"></span>
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
            <!-- End Of Left Area -->

            <!-- Right Area -->
            <div class="col-sm-10">
                <h1>Manage Admin Access</h1>
                <!-- Pop Up Message Area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End Of Pop Up Message Area -->

                <!-- Add Admin Area -->
                <div>
                    <form action="manageadmin.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label for="Username"><span class="Fieldinfo">Username:</span></label>
                                <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="Password"><span class="Fieldinfo">Password:</span></label>
                                <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPassword"><span class="Fieldinfo">Confirm Password:</span></label>
                                <input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype same Password">
                            </div>
                            <br>
                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin">
                        </fieldset>
                        <br>
                    </form>
                </div>
                <!-- End Of Add Admin Area -->

                <!-- Show Admins List Area -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Admin Name</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        //mysqli_query($Connection, "SELECT * FROM category");
                        $getProduct    = $Connection->query("SELECT * FROM registration ORDER BY id desc");
                        $SrNo = 0;
                        while ($fetchProduct = mysqli_fetch_array($getProduct)) {
                            $Id = $fetchProduct["id"];
                            $DateTime = $fetchProduct["datetime"];
                            $Username = $fetchProduct["username"];
                            $Admin = $fetchProduct["addedby"];
                            $SrNo++;

                            ?>
                        <tr>
                            <td><?php echo $SrNo; ?></td>
                            <td><?php echo $DateTime; ?></td>
                            <td><?php echo $Username; ?></td>
                            <td><?php echo $Admin; ?></td>
                            <td><a href="deleteAdmin.php?id=<?php echo $Id; ?>">
                                    <span class="btn btn-danger">Delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <!-- End Of Show Admins List Area -->
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