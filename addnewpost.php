<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php Confirm_Login(); ?>
<!-- Submit Code Area -->
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
    $Admin = $_SESSION["Username"];
    $name = $_FILES["Image"]["name"];
    $target_dir = "assets/";
    $target_file =  $target_dir . basename($_FILES["Image"]["name"]);
    if (empty($Title)) {
        $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("addnewpost.php");
    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMessage"] = "Title should be at-least 2 character";
        Redirect_to("addnewpost.php");
    } else {
        //global $Connection;        
        $Query = mysqli_query($Connection, "INSERT INTO admin_panel (datetime,title,category_name,author,image,post) VALUES('" . $DateTime . "','" . $Title . "','" . $Category . "','" . $Admin . "','" . $name . "','" . $Post . "')");
        move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Post added successfully";
            Redirect_to("addnewpost.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again !";
            Redirect_to("addnewpost.php");
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


    <title>Add New Post</title>
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
                    <li class="active"><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
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
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!-- end of Left area-->

            <!-- Right area-->                    
            <div class="col-sm-10">                
                <h1>Add New Post</h1>
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <div>
                    <form action="addnewpost.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="title"><span class="Fieldinfo">Title:</span></label>
                                <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="categoryselect"><span class="Fieldinfo">Category:</span></label>
                                <select name="Category" id="categoryselect" class="form-control">
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
            </div>
            <!-- end of Right area-->
        </div>        
    </div>
    <!-- end of Main area-->

    <!-- Footer Area -->
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>
    <!-- End Of Footer Area -->                                    
</body>
<!-- End Of Body Area -->
</html>