<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<!-- SUBMIT BUTTON configuration -->
<?php
if (isset($_POST["Submit"])) {
    $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);

    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%A %H:%M - %d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
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
        $EditIDFromURL = $_GET["edit"];
        $Query = mysqli_query($Connection, "UPDATE slideshow SET datetime='" . $DateTime . "', image='" . $Image . "', title='" . $Title . "', author='" . $Admin . "' WHERE id = '" . $EditIDFromURL . "'");
        /*$Query = "UPDATE admin_panel SET datetime='" . $DateTime . "', title='" . $Title . "', category_name='" . $Category . "', author='" . $Admin . "', image='" . $Image . "', post='" . $Post . "' WHERE id = '" . $EditIDFromURL . "'";*/
        move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Sukses mengupdate data slide!";
            Redirect_to("dashBeranda.php");
        } else {
            $_SESSION["ErrorMessage"] = "Ups, terjadi kesalahan. Coba lagi atau hubungi programmer terkait!";
            Redirect_to("dashBeranda.php");
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

    <title>Edit Beranda</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!--SIDE Area-->
            <div class="col-sm-2">
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>
                            &nbsp;Dashboard</a></li>
                    <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                            &nbsp;Categories</a></li>
                    <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>
                            &nbsp;Manage Admin</a></li>
                    <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>
                            &nbsp;Comments</a></li>
                    <li><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!--End of SIDE Area-->

            <!--MAIN Area-->
            <div class="col-sm-10">
                <h1>Update Beranda</h1>
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
                    $viewQuery = $Connection->query("SELECT * FROM slideshow WHERE id=' $EditIDFromURL'");
                    while ($fetchData = mysqli_fetch_array($viewQuery)) {
                        $Id = $fetchData["id"];
                        $DateTime = $fetchData["datetime"];
                        $ImageToUpdate = $fetchData["image"];
                        $Title = $fetchData["title"];
                        $Admin = $fetchData["author"];
                        ?>

                        <form action="editBeranda.php?edit=<?php echo $EditIDFromURL; ?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="title"><span class="Fieldinfo">Title:</span></label>
                                    <input value="<?php echo $Title; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
                                    <br>
                                </div>
                                <div class="form-group">
                                    <span class="Fieldinfo">Existing Image:</span>
                                    <img src="slideshows/<?php echo $ImageToUpdate; ?>" width="170" ; height="80px"><br>
                                    <label for="imageselect"><span class="Fieldinfo">Select Image:</span></label>
                                    <input type="File" class="form-control" name="Image" id="imageselect">
                                    <br>
                                </div>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Update Slide">
                                <br>
                            </fieldset>
                        </form>
                    <?php } ?>
                </div>
                <!-- End of EDIT area -->
            </div>
            <!--End of MAIN Area-->
        </div>
    </div>
    </div>

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>