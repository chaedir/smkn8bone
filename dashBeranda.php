<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<!-- SUBMIT BUTTON configuration -->
<?php
if (isset($_POST["Submit"])) {
    $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);
    //$Post = mysqli_real_escape_string($Connection, $_POST["Post"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%A %H:%M - %d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $name = $_FILES["Image"]["name"];
    $target_dir = "slideshows/";
    $target_file =  $target_dir . basename($_FILES["Image"]["name"]);
    if (empty($Title)) {
        $_SESSION["ErrorMessage"] = "GAGAL! Title tidak boleh dikosongkan!";
        Redirect_to("dashBeranda.php");
    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMessage"] = "GAGAL! Title tidak boleh kurang dari 2 huruf!";
        Redirect_to("dashBeranda.php");
    } elseif (empty($Image)) {
        $_SESSION["ErrorMessage"] = "GAGAL! Gambar tidak boleh dikosongkan!";
        Redirect_to("dashBeranda.php");
    } else {
        //global $Connection;        
        $Query = mysqli_query($Connection, "INSERT INTO slideshow (datetime,image,title,author) VALUES('" . $DateTime . "','" . $name . "','" . $Title . "','" . $Admin . "')");
        move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Sukses menambahkan slideshow !";
            Redirect_to("dashBeranda.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
            Redirect_to("dashBeranda.php");
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
    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" /> 

    <title>Manage Beranda</title>
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

    <!-- Main area -->
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
                    <li class="active"><a href="dashBeranda.php"> <span class="glyphicon glyphicon-home"></span>
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
            <!--End of Left area-->

            <!-- Right area-->
            <div class="col-sm-10">
                <!-- MESSAGE area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End of MESSAGE area -->
                <h1>Manage Beranda</h1>
                <!-- ADD NEW SLIDE area -->
                <div>
                    <form action="dashBeranda.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Title:</span></label>
                                <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="imageselect"><span class="Fieldinfo">Select Image:</span></label>
                                <input type="File" class="form-control" name="Image" id="imageselect">
                                <br>
                            </div>

                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Slide">
                        </fieldset>
                        <br>
                    </form>
                </div>
                <!-- end of ADD NEW SLIDE area -->

                <!-- SLIDESHOW Area -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Slide Title</th>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>

                        <?php
                        $viewQuery = $Connection->query("SELECT * FROM slideshow ORDER BY id desc");
                        $SrNo = 0;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $Id = $fetchData["id"];
                            $DateTime = $fetchData["datetime"];
                            $Image = $fetchData["image"];
                            $Title = $fetchData["title"];
                            $Admin = $fetchData["author"];
                            $SrNo++;

                            ?>
                        <tr>
                            <td><?php echo $SrNo; ?></td>
                            <td style="color: #5e5eff;">
                                <?php
                                    if (strlen($Title) > 50) {
                                        $Title = substr($Title, 0, 50) . '...';
                                    }
                                    echo $Title;
                                    ?>
                            </td>
                            <td><?php echo $DateTime; ?></td>
                            <td>
                                <?php
                                    if (strlen($Admin) > 40) {
                                        $Admin = substr($Admin, 0, 40) . '...';
                                    }
                                    echo $Admin;
                                    ?>
                            </td>
                            <td><img src="slideshows/<?php echo $Image; ?>" width="170" ; height="50px"></td>
                            <td>
                                <a href="editBeranda.php?edit=<?php echo $Id; ?>">
                                    <span class="btn btn-warning" style="margin: 2px 0;">Edit</span></a>

                                <a href="deleteBeranda.php?delete=<?php echo $Id; ?>">
                                    <span class="btn btn-danger" style="margin: 2px 0;">Delete</span></a>
                            </td>
                            <td>
                                <a href="index.php?id=<?php echo $Id; ?>" target="_blank">
                                    <span class="btn btn-primary" style="margin: 2px 0;">Live Preview</span></a>
                            </td>
                            <!-- <td><?php echo $Post; ?></td> -->
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <!--End of SLIDESHOW Area-->
            </div>
            <!--End of Right area-->
        </div>
    </div>
    <!-- end of Main area -->

    <!-- Footer Area -->
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>
    <!-- End Of Footer Area -->                                
</body>
<!-- End Of Body Area -->
</html>