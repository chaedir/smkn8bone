<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
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

    <title>Dashboard</title>
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
                <a href="blog.php?Page=1" class="navbar-brand">
                    <img id="logo" src="images/smkn8bone_logo.png">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php" target="_blank">Home</a></li>
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <!--Side Area-->
                <br>
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
                    <li><a href="blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!--Ending of Side Area-->
            <div class="col-sm-10">
                <!--Main Area-->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <h1>Admin Dashboard</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Post Title</th>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>

                        <?php
                        $viewQuery = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc");
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
                            <td>
                                <?php
                                    if (strlen($Category) > 40) {
                                        $Category = substr($Category, 0, 40) . '...';
                                    }
                                    echo $Category;
                                    ?></td>
                            <td><img src="assets/<?php echo $Image; ?>" width="170" ; height="50px"></td>
                            <td>
                                <?php
                                    $queryApproved = $Connection->query("SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'");
                                    $rowsApproved = mysqli_fetch_array($queryApproved);
                                    $totalApproved = array_shift($rowsApproved);

                                    if ($totalApproved > 0) {
                                        ?>
                                <span class="label pull-right label-success">
                                    <?php echo $totalApproved; ?>
                                </span>
                                <?php } ?>

                                <?php
                                    $queryUnApproved = $Connection->query("SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='OFF'");
                                    $rowsUnApproved = mysqli_fetch_array($queryUnApproved);
                                    $totalUnApproved = array_shift($rowsUnApproved);

                                    if ($totalUnApproved > 0) {
                                        ?>
                                <span class="label pull-left label-warning">
                                    <?php echo $totalUnApproved; ?>
                                </span>
                                <?php } ?>

                            </td>
                            <td>
                                <a href="editPost.php?edit=<?php echo $Id; ?>">
                                    <span class="btn btn-warning" style="margin: 2px 0;">Edit</span></a>

                                <a href="deletePost.php?delete=<?php echo $Id; ?>">
                                    <span class="btn btn-danger" style="margin: 2px 0;">Delete</span></a>
                            </td>
                            <td>
                                <a href="fullPost.php?id=<?php echo $Id; ?>" target="_blank">
                                    <span class="btn btn-primary" style="margin: 2px 0;">Live Preview</span></a>
                            </td>
                            <!-- <td><?php echo $Post; ?></td> -->
                        </tr>
                        <?php } ?>


                    </table>
                </div>
            </div>
            <!--Ending of Main Area-->
        </div>
    </div>

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

</body>

</html>