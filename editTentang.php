<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<!-- SUBMIT BUTTON configuration -->
<?php
if (isset($_POST["Submit"])) {
    $p1_title = mysqli_real_escape_string($Connection, $_POST["Title1"]);
    $p2_title = mysqli_real_escape_string($Connection, $_POST["Title2"]);
    $p3_title = mysqli_real_escape_string($Connection, $_POST["Title3"]);
    $p4_title = mysqli_real_escape_string($Connection, $_POST["Title4"]);
    $p1_post = mysqli_real_escape_string($Connection, $_POST["Post1"]);
    $p2_post = mysqli_real_escape_string($Connection, $_POST["Post2"]);
    $p3_post = mysqli_real_escape_string($Connection, $_POST["Post3"]);
    $p4_post = mysqli_real_escape_string($Connection, $_POST["Post4"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%A %H:%M - %d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $target_dir = "assets/";
    $target_file =  $target_dir . basename($_FILES["Image"]["name"]);
    if (empty($p1_title)) {
        $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("dashTentang.php");
    } elseif (strlen($p1_title) < 2) {
        $_SESSION["ErrorMessage"] = "Title should be at-least 2 character";
        Redirect_to("dashTentang.php");
    } else {
        //global $Connection;
        $EditIDFromURL = $_GET["edit"];
        $Query = mysqli_query($Connection, "UPDATE tentang_Sekolah SET datetime='" . $DateTime . "', author='" . $Admin . "', image='" . $Image . "', p1Title='" . $p1_title . "', p1Post='" . $p1_post . "', p2Title='" . $p2_title . "', p2Post='" . $p2_post . "', p3Title='" . $p3_title . "', p3Post='" . $p3_post . "', p4Title='" . $p4_title . "', p4Post='" . $p4_post . "' WHERE id = '" . $EditIDFromURL . "'");

        //$Query = mysqli_query($Connection, "INSERT INTO tentang_Sekolah (datetime,author,image,p1Title,p1Post,p2Title,p2Post,p3Title,p3Post,p4Title,p4Post) VALUES('" . $DateTime . "','" . $Admin . "','" . $Image . "','" . $p1_title . "','" . $p1_post . "','" . $p2_title . "','" . $p2_post . "','" . $p3_title . "','" . $p3_post . "','" . $p4_title . "','" . $p4_post . "')");

        move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Post updated successfully";
            Redirect_to("dashTentang.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
            Redirect_to("dashTentang.php");
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

    <title>Edit Informasi Sekolah</title>
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
            <!-- Left area -->
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
                    <li class="active"><a href="dashTentang.php"><span class="glyphicon glyphicon-list-alt"></span>
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
                    <!-- <li><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li> -->
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!--End of Left area-->

            <!--Right area-->
            <div class="col-sm-10">
                <h1>Update Informasi Sekolah</h1>
                <!-- MESSAGE area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End of MESSAGE area -->

                <!-- SHOW DATABASE area -->
                <div>
                    <?php
                    $EditIDFromURL = $_GET["edit"];
                    $viewQuery = $Connection->query("SELECT * FROM tentang_Sekolah WHERE id=' $EditIDFromURL'");
                    while ($fetchData = mysqli_fetch_array($viewQuery)) {
                        $Image = $fetchData["image"];
                        $p1_title = $fetchData["p1Title"];
                        $p1_post = $fetchData["p1Post"];
                        $p2_title = $fetchData["p2Title"];
                        $p2_post = $fetchData["p2Post"];
                        $p3_title = $fetchData["p3Title"];
                        $p3_post = $fetchData["p3Post"];
                        $p4_title = $fetchData["p4Title"];
                        $p4_post = $fetchData["p4Post"];
                    }
                    ?>

                    <form action="editTentang.php?edit=<?php echo $EditIDFromURL; ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <span class="Fieldinfo">Existing Image:</span>
                                <img src="assets/<?php echo $Image; ?>" width="170" ; height="80px"><br>
                                <label for="imageselect"><span class="Fieldinfo">Select Image:</span></label>
                                <input type="File" class="form-control" name="Image" id="imageselect">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Post1 Title:</span></label>
                                <input value="<?php echo $p1_title; ?>" class="form-control" type="text" name="Title1" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post1 Post:</span></label>
                                <textarea name="Post1" id="postarea" class="form-control"><?php echo $p1_post; ?></textarea>
                                <br>
                            </div>

                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Post2 Title:</span></label>
                                <input value="<?php echo $p2_title; ?>" class="form-control" type="text" name="Title2" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post2 Post:</span></label>
                                <textarea name="Post2" id="postarea" class="form-control"><?php echo $p2_post; ?></textarea>
                                <br>
                            </div>

                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Post3 Title:</span></label>
                                <input value="<?php echo $p3_title; ?>" class="form-control" type="text" name="Title3" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post3 Post:</span></label>
                                <textarea name="Post3" id="postarea" class="form-control"><?php echo $p3_post; ?></textarea>
                                <br>
                            </div>

                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Post4 Title:</span></label>
                                <input value="<?php echo $p4_title; ?>" class="form-control" type="text" name="Title4" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post4 Post:</span></label>
                                <textarea name="Post4" id="postarea" class="form-control"><?php echo $p4_post; ?></textarea>
                                <br>
                            </div>

                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Update Post">
                            <br>
                        </fieldset>
                    </form>
                </div>                
                <!-- End of SHOW DATABASE area -->
            </div>
            <!--End of Right area-->
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