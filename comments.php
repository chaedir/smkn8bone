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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <!--Side Area-->
                <br>
                <ul id="side_menu" class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>
                            &nbsp;Dashboard</a></li>
                    <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span>
                            &nbsp;Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                            &nbsp;Categories</a></li>
                    <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span>
                            &nbsp;Manage Admin</a></li>
                    <li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>
                            &nbsp;Comments</a></li>
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
                        $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='OFF' ORDER BY id desc");
                        $SrNo = 0;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $CommentId = $fetchData["id"];
                            $DateTimeofComment = $fetchData["datetime"];
                            $PersonName = $fetchData["name"];
                            $Comment = $fetchData["comment"];
                            $CommentedPostId = $fetchData["admin_panel_id"];
                            $SrNo++;

                            if (strlen($PersonName) > 13) {
                                $PersonName = substr($PersonName, 0, 13) . '...';
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
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
                </div>

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
                        $viewQuery = $Connection->query("SELECT * FROM comments WHERE status='ON' ORDER BY id desc");
                        $SrNo = 0;
                        while ($fetchData = mysqli_fetch_array($viewQuery)) {
                            $CommentId = $fetchData["id"];
                            $DateTimeofComment = $fetchData["datetime"];
                            $PersonName = $fetchData["name"];
                            $Comment = $fetchData["comment"];
                            $ApprovedBy = $fetchData["approvedby"];
                            $CommentedPostId = $fetchData["admin_panel_id"];
                            $SrNo++;

                            if (strlen($PersonName) > 13) {
                                $PersonName = substr($PersonName, 0, 13) . '...';
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
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