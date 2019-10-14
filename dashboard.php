<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">

<!-- HEAD AREA -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css?v=<?php echo time(); ?>" />
    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" /> 

    <title>Dashboard</title>
</head>
<!-- END OF HEAD AREA -->

<!-- STYLE AREA -->
<style>
    /* THIS STYLE ONLY FOR PAGINATION */
    .paginationS {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        padding-top: 10px;
    }

    .page {
        grid-column: 1;
        justify-self: center;
    }

    .pagination {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color 0.3s;
    border: 1px solid #ddd;
    margin: 0 4px;
    }

    .aktif {
    background-color: #1f70cc;
    color: white;
    border: 1px solid #1f70cc;
    }

    .pagination:hover:not(.aktif) {
    background-color: #ddd;
    }
</style>
<!-- END OF STYLE AREA -->

<!-- BODY AREA -->
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

    <!-- MAIN AREA -->
    <div class="container-fluid">
        <div class="row">
            <!--LEFT Area-->
            <div class="col-sm-2">                
                <br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="dashboard.php?Page=1"> <span class="glyphicon glyphicon-th"></span>
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
            <!--Ending of LEFT Area-->

            <!--RIGHT Area-->
            <div class="col-sm-10"> 
                <!-- Pop Up Message Area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End Pop Up Message Area -->

                <!-- Dashboard Area -->
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

                        if (isset($_GET["Page"])) {
                            $Page = $_GET["Page"];
                            if ($Page < 1) {
                                $ShowPostFrom = 0;
                            } else {
                                $ShowPostFrom = ($Page * 15) - 15;
                                //echo $ShowPostFrom;
                            }
                            $viewQuery = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,15");              
                        } else {
                            $viewQuery = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,15");
                        }                        
                        $SrNo = 1;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $Id = $fetchData["id"];
                            $DateTime = $fetchData["datetime"];
                            $Title = $fetchData["title"];
                            $Category = $fetchData["category_name"];
                            $Admin = $fetchData["author"];
                            $Image = $fetchData["image"];
                            $Post = $fetchData["post"];
                            $SrNoPage = $ShowPostFrom + $SrNo++;

                            ?>
                        <tr>
                            <td><?php echo $SrNoPage; ?></td>
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
                    
                <!-- PAGINATION AREA -->
                <div class="paginationS">
                    <div class="page">
                        <!-- Creating Backward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) {
                                ?>
                                <a href="dashboard.php?Page=<?php echo $Page - 1; ?>" class="pagination"> &laquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Backward Button area -->
                        <?php
                        $queryPagination = $Connection->query("SELECT COUNT(*) FROM admin_panel");
                        $rowsPagination = mysqli_fetch_array($queryPagination);
                        $totalPosts = array_shift($rowsPagination);
                        //echo $totalPosts;
                        $postPagination = $totalPosts / 15;
                        $postPagination = ceil($postPagination);
                        //echo $postPagination;

                        for ($i = 1; $i <= $postPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) {
                                    ?>
                                    <a href="dashboard.php?Page=<?php echo $i; ?>" class="pagination aktif"><?php echo $i; ?></a>
                                <?php
                                } else {
                                    ?>
                                    <a href="dashboard.php?Page=<?php echo $i; ?>" class="pagination"><?php echo $i; ?></a>
                                <?php   }
                            }
                        } ?>
                        <!-- Creating Forward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $postPagination) {
                                ?>
                                <a href="dashboard.php?Page=<?php echo $Page + 1; ?>" class="pagination"> &raquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Forward Button area -->
                    </div>          
                </div><br>
                <!-- END OF PAGINATION AREA -->
                </div>
                <!-- End of Dashboard Area -->                
            </div>
            <!--End of RIGHT Area-->
        </div>
    </div>
    <!-- END OF MAIN AREA -->

    <!-- FOOTER AREA -->
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>
    <!-- END OF FOOTER AREA -->
</body>
<!-- END OF BODY AREA -->
</html>