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
    $DateTime = strftime("%d %B %Y", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $name = $_FILES["Image"]["name"];
    $target_dir = "slideshow/";
    $target_file =  $target_dir . basename($_FILES["Image"]["name"]);
    if (empty($Title)) {
        $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("dashBeranda.php");
    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMessage"] = "Title should be at-least 2 character";
        Redirect_to("dashBeranda.php");
    } else {
        //global $Connection;        
        $Query = mysqli_query($Connection, "INSERT INTO slideshow (datetime,image,title,post,author) VALUES('" . $DateTime . "','" . $name . "','" . $Title . "','" . $Post . "','" . $Admin . "')");
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
<!-- HEAD area -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/adminstyles.css?v=<?php echo time(); ?>" />

    <!-- <script src="js/jQuery3.4.1.js"></script> -->

    <!-- <script src="js/bootstrap.min.js"></script> -->

    <title>Add New Beranda</title>
</head>
<!-- end of HEAD area -->

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
                <a href="blog.php" class="navbar-brand">
                    <img id="logo" src="images/smkn8bone_logo.png">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="blog.php" target="_blank">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Feature</a></li>
                </ul>
                <form action="blog.php" class="navbar-form navbar-right">
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

    <!--CONTAINER area-->
    <div class="container-fluid">
        <div class="row">
            <!--SIDE area-->
            <div class="col-sm-2">
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>
                            &nbsp;Dashboard</a></li>
                    <li class="active"><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                            &nbsp;Categories</a></li>
                    <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>
                            &nbsp;Manage Admin</a></li>
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
                <h1>Add New Beranda Post</h1>
                <!-- MESSAGE area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- end of MESSAGE area -->

                <!-- ADD NEW IMAGE area -->
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
                            <div class="form-group">
                                <label for="postarea"><span class="Fieldinfo">Post:</span></label>
                                <textarea name="Post" id="postarea" class="form-control"></textarea>
                                <br>
                            </div>
                            <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Post">
                        </fieldset>
                        <br>
                    </form>
                </div>
                <!-- end of ADD NEW IMAGE area -->
            </div>
            <!--end of MAIN area-->
        </div>
    </div>
    <!--end of CONTAINER area-->

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>