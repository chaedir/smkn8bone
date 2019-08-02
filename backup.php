<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" />

    <link rel="stylesheet" href="css/publicstyle.css?v=<?php echo time(); ?>" />

    <script src="js/jQuery3.4.1.js"></script>

    <script src="js/bootstrap.min.js"></script>


    <title>Blog Page</title>
</head>

<body>

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
                    <li class="active"><a href="blog.php">Blog</a></li>
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
    <div class="container">
        <!--Container-->
        <div class="blog-header">
            <h1>The Complete Responsive CMS Blog</h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
        <div class="row">
            <!--Row-->
            <div class="col-sm-8">
                <!--Main Blog Area-->
                <?php
                //Query when Search Button is active
                if (isset($_GET["searchButton"])) {
                    $Search = $_GET["search"];
                    $viewQuery = $Connection->query("SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category_name LIKE '%$Search%' OR post LIKE '%$Search%'");
                }
                // Query When Category is active URL Tab
                elseif (isset($_GET["category"])) {
                    $Category = $_GET["category"];
                    $viewQuery = $Connection->query("SELECT * FROM admin_panel WHERE category_name='$Category' ORDER BY id desc");
                }
                //Query when pagination is active i.e blog.php?Page=1
                elseif (isset($_GET["Page"])) {
                    $Page = $_GET["Page"];
                    if ($Page < 1) {
                        $ShowPostFrom = 0;
                    } else {
                        $ShowPostFrom = ($Page * 5) - 5;
                        //echo $ShowPostFrom;
                    }
                    $viewQuery = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,5");

                    //Default Query for blog.php
                } else {
                    $viewQuery = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5");
                }
                $SrNo = 0;
                while ($fetchData = mysqli_fetch_array($viewQuery)) {
                    $Id = $fetchData["id"];
                    $DateTime = $fetchData["datetime"];
                    $Title = $fetchData["title"];
                    $Category = $fetchData["category_name"];
                    $Admin = $fetchData["author"];
                    $Image = $fetchData["image"];
                    $Post = $fetchData["post"];
                    $SrNo++;
                    ?>
                    <div class="blogpost thumbnail">
                        <img class="img-responsive img-rounded" src="assets/<?php echo $Image; ?>">

                        <div class="caption">
                            <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
                            <h6 class="description">Category: <?php echo htmlentities($Category); ?> <br> Published on <?php echo htmlentities($DateTime); ?>

                                <?php
                                $queryApproved = $Connection->query("SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'");
                                $rowsApproved = mysqli_fetch_array($queryApproved);
                                $totalApproved = array_shift($rowsApproved);

                                if ($totalApproved > 0) {
                                    ?>
                                    <span class="badge pull-right">
                                        Comments: <?php echo $totalApproved; ?>
                                    </span>
                                <?php } ?>

                            </h6>
                            <p class="post">
                                <?php
                                if (strlen($Post) > 150) {
                                    $Post = substr($Post, 0, 150) . '...';
                                }
                                echo htmlentities($Post); ?>
                            </p>
                        </div>
                        <a href="fullPost.php?id=<?php echo $Id; ?>"><span class="btn btn-info">Read more &rsaquo;&rsaquo;</span></a>
                    </div>
                <?php } ?>
                <nav>
                    <ul class="pagination pull-left pagination-lg">
                        <!-- Creating Backward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) {
                                ?>
                                <li><a href="blog.php?Page=<?php echo $Page - 1; ?>"> &laquo; </a> </li>
                            <?php
                            }
                        } ?>
                        <!-- End Backward Button area -->
                        <?php
                        $queryPagination = $Connection->query("SELECT COUNT(*) FROM admin_panel");
                        $rowsPagination = mysqli_fetch_array($queryPagination);
                        $totalPosts = array_shift($rowsPagination);
                        //echo $totalPosts;
                        $postPagination = $totalPosts / 5;
                        $postPagination = ceil($postPagination);
                        //echo $postPagination;

                        for ($i = 1; $i <= $postPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) {
                                    ?>
                                    <li class="active"><a href="blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php
                                } else {
                                    ?>
                                    <li><a href="blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php   }
                            }
                        } ?>
                        <!-- Creating Forward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $postPagination) {
                                ?>
                                <li><a href="blog.php?Page=<?php echo $Page + 1; ?>"> &raquo; </a> </li>
                            <?php
                            }
                        } ?>
                        <!-- End Forward Button area -->
                    </ul>
                </nav>

            </div>
            <!--Main Blog Area Ending-->

            <div class="col-sm-offset-1 col-sm-3">
                <!--Side Area-->
                <h2>Tentang SMKN 8 Bone</h2>
                <img src="images/smkn8bone_logo.png" class="img-responsive img-circle imageIcon">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit vero, non officiis maiores necessitatibus earum eum provident dicta dignissimos, perferendis qui commodi itaque quos dolor quibusdam neque aut iste nam. Doloribus quaerat doloremque molestias pariatur ducimus placeat quidem quas harum?</p>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">Categories</h2>
                    </div>
                    <div class="panel-body">

                        <?php
                        //mysqli_query($Connection, "SELECT * FROM category");
                        global $Connection;
                        $getProduct    = $Connection->query("SELECT * FROM category ORDER BY id desc");
                        //$SrNo = 0;
                        while ($fetchProduct = mysqli_fetch_array($getProduct)) {
                            $Id = $fetchProduct["id"];
                            $CategoryName = $fetchProduct["name"];
                            //$SrNo++;

                            ?>
                            <a href="blog.php?category=<?php echo $CategoryName; ?>">
                                <span id="heading"><?php echo $CategoryName . "<br>"; ?></span>
                            </a>
                        <?php } ?>

                    </div>
                    <div class="panel-footer">

                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">Recent Posts</h2>
                    </div>
                    <div class="panel-body background">
                        <?php
                        //mysqli_query($Connection, "SELECT * FROM category");
                        global $Connection;
                        $getProduct    = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5");
                        //$SrNo = 0;
                        while ($dataRows = mysqli_fetch_array($getProduct)) {
                            $Id = $dataRows["id"];
                            $Title = $dataRows["title"];
                            $DateTime = $dataRows["datetime"];
                            $Image = $dataRows["image"];
                            if (strlen($DateTime) > 12) {
                                $DateTime = substr($DateTime, 0, 12);
                            }

                            ?>
                            <div>
                                <img class="pull-left" style="margin: 10px 0 0 10px;" src="assets/<?php echo htmlentities($Image); ?>" width="70" ; height="70" ;>
                                <a href="fullPost.php?id=<?php echo $Id; ?>">
                                    <p id="heading" style="margin-left: 90px;"><?php echo htmlentities($Title); ?></p>
                                </a>
                                <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime); ?></p>
                                <hr>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="panel-footer">

                    </div>
                </div>


            </div>
            <!--Side Area Ending-->
        </div>
        <!--Row Ending-->
    </div>
    <!--Container Ending-->

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

    <script src="js/main.js"></script>
</body>

</html>