<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
<!-- Head area -->
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
<!-- End Of Head area -->

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
            <!-- Left Area-->
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
                    <li><a href="dashTentang.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Tentang Sekolah</a></li>
                    <li><a href="manageGaleri.php?Page=1"> <span class="glyphicon glyphicon-picture"></span>
                            &nbsp;Manage Galeri</a></li>
                    <li><a href="manageKontak.php"><span class="glyphicon glyphicon-road"></span>
                            &nbsp;Manage Address</a></li>
                    <li class="active"><a href="comments.php?Page=1"><span class="glyphicon glyphicon-comment"></span>
                            &nbsp;Comments</a></li>
                    <!-- <li><a href="blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span>
                            &nbsp;Live Blog</a></li> -->
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            &nbsp;Logout</a></li>
                </ul>
            </div>
            <!-- End of Left Area-->

            <!-- Right Area-->
            <div class="col-sm-10">  
                <!-- Pop Up Message Area -->
                <div>
                    <?php echo Message();
                    echo SuccessMessage();
                    ?>
                </div>
                <!-- End Of Pop Up Message Area -->

                <!-- Unapproved Comments Area -->
                <h1>Unapproved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete Comment</th>
                            <th>Details</th>
                        </tr>
                        <?php                        
                        if (isset($_GET["Page"])) {
                            $Page = $_GET["Page"];
                            if ($Page < 1) {
                                $ShowPostFrom = 0;
                            } else {
                                $ShowPostFrom = ($Page * 5) - 5;
                                //echo $ShowPostFrom;
                            }
                            $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='OFF' ORDER BY id desc LIMIT $ShowPostFrom,5");              
                        } else {
                            $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='OFF' ORDER BY id desc LIMIT 0,5");
                        }                        
                        $SrNo = 1;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $CommentId = $fetchData["id"];
                            $DateTimeofComment = $fetchData["datetime"];
                            $PersonName = $fetchData["name"];
                            $Comment = $fetchData["comment"];
                            $CommentedPostId = $fetchData["admin_panel_id"];
                            $SrNoPage = $ShowPostFrom + $SrNo++;

                            if (strlen($PersonName) > 13) {
                                $PersonName = substr($PersonName, 0, 13) . '...';
                            }
                            ?>
                        <tr>
                            <td><?php echo htmlentities($SrNoPage); ?></td>
                            <td><?php echo htmlentities($DateTimeofComment); ?></td>
                            <td style="color:cadetblue"><?php echo htmlentities($PersonName); ?></td>
                            <td><?php echo htmlentities($Comment); ?></td>
                            <td>
                                <a href="approveComment.php?id=<?php echo $CommentId; ?>">
                                    <span class="btn btn-success" style="margin: 2px 0;">Approve</span></a>
                            </td>
                            <td>
                                <a href="deleteComment.php?id=<?php echo $CommentId; ?>">
                                    <span class="btn btn-danger" style="margin: 2px 0;">Delete</span></a>
                            </td>
                            <td>
                                <a href="fullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank">
                                    <span class="btn btn-primary" style="margin: 2px 0;">Live Preview</span></a>
                            </td>
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
                                <a href="comments.php?Page=<?php echo $Page - 1; ?>" class="pagination"> &laquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Backward Button area -->
                        <?php
                        $queryPagination = $Connection->query("SELECT COUNT(*) FROM comments WHERE status='OFF'");
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
                                    <a href="comments.php?Page=<?php echo $i; ?>" class="pagination aktif"><?php echo $i; ?></a>
                                <?php
                                } else {
                                    ?>
                                    <a href="comments.php?Page=<?php echo $i; ?>" class="pagination"><?php echo $i; ?></a>
                                <?php   }
                            }
                        } ?>
                        <!-- Creating Forward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $postPagination) {
                                ?>
                                <a href="comments.php?Page=<?php echo $Page + 1; ?>" class="pagination"> &raquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Forward Button area -->
                    </div>          
                </div><br>
                <!-- END OF PAGINATION AREA -->
                </div>
                <!-- End Of Unapproved Comments Area -->

                <!-- Approved Comments Area -->
                <h1>Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approved By</th>
                            <th>Revert Approve</th>
                            <th>Delete Comment</th>
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
                            $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='ON' ORDER BY id desc LIMIT $ShowPostFrom,15");              
                        } else {
                            $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='ON' ORDER BY id desc LIMIT 0,15");
                        }                        
                        $SrNo = 1;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $CommentId = $fetchData["id"];
                            $DateTimeofComment = $fetchData["datetime"];
                            $PersonName = $fetchData["name"];
                            $Comment = $fetchData["comment"];
                            $ApprovedBy = $fetchData["approvedby"];
                            $CommentedPostId = $fetchData["admin_panel_id"];
                            $SrNoPage = $ShowPostFrom + $SrNo++;

                            if (strlen($PersonName) > 13) {
                                $PersonName = substr($PersonName, 0, 13) . '...';
                            }
                            ?>
                        <tr>
                            <td><?php echo htmlentities($SrNoPage); ?></td>
                            <td><?php echo htmlentities($DateTimeofComment); ?></td>
                            <td style="color:cadetblue;"><?php echo htmlentities($PersonName); ?></td>
                            <td><?php echo htmlentities($Comment); ?></td>
                            <td><?php echo htmlentities($ApprovedBy); ?></td>
                            <td>
                                <a href="disapproveComment.php?id=<?php echo $CommentId; ?>">
                                    <span class="btn btn-warning" style="margin: 2px 0;">Disapprove</span></a>
                            </td>
                            <td>
                                <a href="deleteComment.php?id=<?php echo $CommentId; ?>">
                                    <span class="btn btn-danger" style="margin: 2px 0;">Delete</span></a>
                            </td>
                            <td>
                                <a href="fullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank">
                                    <span class="btn btn-primary" style="margin: 2px 0;">Live Preview</span></a>
                            </td>
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
                                <a href="comments.php?Page=<?php echo $Page - 1; ?>" class="pagination"> &laquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Backward Button area -->
                        <?php
                        $queryPagination = $Connection->query("SELECT COUNT(*) FROM comments WHERE status='ON'");
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
                                    <a href="comments.php?Page=<?php echo $i; ?>" class="pagination aktif"><?php echo $i; ?></a>
                                <?php
                                } else {
                                    ?>
                                    <a href="comments.php?Page=<?php echo $i; ?>" class="pagination"><?php echo $i; ?></a>
                                <?php   }
                            }
                        } ?>
                        <!-- Creating Forward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $postPagination) {
                                ?>
                                <a href="comments.php?Page=<?php echo $Page + 1; ?>" class="pagination"> &raquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Forward Button area -->
                    </div>          
                </div><br>
                <!-- END OF PAGINATION AREA -->
                </div>
                <!-- End Of Approved Comments Area -->
            </div>
            <!-- End of Right Area-->
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