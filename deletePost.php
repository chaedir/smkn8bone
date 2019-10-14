<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection, $_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection, $_POST["Post"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = "Chaedir";
    $Image = $_FILES["Image"]["name"];
    $target_dir = "assets/";
    $target_file =  $target_dir . basename($_FILES["Image"]["name"]);

    //global $Connection;
    $DeleteIDFromURL = $_GET["delete"];
    $Query = mysqli_query($Connection, "DELETE FROM admin_panel WHERE id = '" . $DeleteIDFromURL . "'");
    move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
    if ($Query) {
        $_SESSION["SuccessMessage"] = "Post deleted successfully";
        Redirect_to("dashboard.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
        Redirect_to("dashboard.php");
    }
}
?>
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

    <title>Delete Post</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>
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
                    <li><a href="manageKontak.php"><span class="glyphicon glyphicon-road"></span>
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
                    <li><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <div class="col-sm-10">
                <h1>Delete Post</h1>
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <div>
                    <?php
                    $EditIDFromURL = $_GET["delete"];
                    $viewQuery = $Connection->query("SELECT * FROM admin_panel WHERE id=' $EditIDFromURL'");
                    while ($fetchData = mysqli_fetch_array($viewQuery)) {
                        $TitleToUpdate = $fetchData["title"];
                        $CategoryToUpdate = $fetchData["category_name"];
                        $ImageToUpdate = $fetchData["image"];
                        $PostToUpdate = $fetchData["post"];
                    }
                    ?>

                    <form action="deletePost.php?delete=<?php echo $EditIDFromURL; ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Title:</span></label>
                                <input disabled value="<?php echo $TitleToUpdate; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <span class="Fieldinfo">Existing Category:</span>
                                <?php echo $CategoryToUpdate; ?><br>
                                <label for="categoryselect"><span class="Fieldinfo">Category:</span></label>
                                <select disabled name="Category" id="categoryselect" class="form-control">
                                    <?php
                                    //mysqli_query($Connection, "SELECT * FROM category");
                                    $getProduct    = $Connection->query("SELECT * FROM category ORDER BY datetime desc");

                                    while ($fetchProduct = mysqli_fetch_array($getProduct)) {
                                        $Id = $fetchProduct["id"];
                                        $CategoryName = $fetchProduct["name"];
                                        ?>
                                    <option><?php echo $CategoryName; ?></option>
                                    <?php } ?>
                                </select>
                                <br>
                            </div>
                            <div class="form-group">
                                <span class="Fieldinfo">Existing Image:</span>
                                <img src="assets/<?php echo $ImageToUpdate; ?>" width="170" ; height="80px"><br>
                                <label for="imageselect"><span class="Fieldinfo">Select Image:</span></label>
                                <input disabled type="File" class="form-control" name="Image" id="imageselect">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post:</span></label>
                                <textarea disabled name="Post" id="postarea" class="form-control"><?php echo $PostToUpdate; ?></textarea>
                                <br>
                            </div>
                            <input class="btn btn-danger btn-block" type="submit" name="Submit" value="Delete Post">
                            <br>
                </div>
                </fieldset>
                </form>
            </div>


        </div>
    </div>
    </div>

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>