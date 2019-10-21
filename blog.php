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
    <link rel="stylesheet" href="dist/css/main.css?v=<?php echo time(); ?>" />

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" /> -->

    <link rel="stylesheet" href="css/publicstyle.css?v=<?php echo time(); ?>" />

    <link rel="stylesheet" href="css/blogstyle.css?v=<?php echo time(); ?>" />

    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <script src="js/jQuery3.4.1.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />



    <title>Blog Page</title>
</head>

<body>
    <!-- Header Area -->

    <header>
        <div class="menu-btn">
            <div class="btn-line"></div>
            <div class="btn-line"></div>
            <div class="btn-line"></div>
        </div>

        <nav class="menu">
            <div class="menu-branding ">
                <div class="portrait text-center"></div>
            </div>
            <ul class="menu-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">Tentang Sekolah</a>
                </li>
                <li class="nav-item">
                    <a href="gallery.php?Page=1" class="nav-link">Galeri</a>
                </li>
                <li class="nav-item current">
                    <a href="blog.php?Page=1" class="nav-link">Berita</a>
                </li>
                <li class="nav-item">
                    <a href="http://epanrita.id/" class="nav-link" target="_blank">ePanrita</a>
                </li>
                <li class="nav-item">
                    <a href="kontak.php" class="nav-link">Hubungi Kami</a>
                </li>
            </ul>
        </nav>
    </header>
    <!--End of Header Area -->

    <main id="berita">
        <div class="wrapper">
            <div class="box1">
                <h1 class="lg-heading">
                    Portal <span class="text-secondary">Berita</span>
                </h1>
                <h2 class="sm-heading">
                    Selamat datang di Portal Berita SMKN 8 Bone
                </h2>
            </div>
            <div class="box2">
                <form action="blog.php" class="navbar-form navbar-right">
                    <div class="nested">
                        <div class="box2-1">
                            <input type="text" placeholder="Cari Berita" name="search">
                        </div>
                        <div class="box2-2">
                            <button class="btnDefault" name="searchButton">Go</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <!--Container-->
            <div class="box3">
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
                    <div class="blogpost">
                        <div class="img-area">
                            <img class="img-thumbnail" src="assets/<?php echo $Image; ?>" ;>
                        </div>

                        <div class="caption">
                            <div class="captionInside">
                                <div class="published">
                                    <h6 class="description">Kategori: <?php echo htmlentities($Category); ?> | <?php echo htmlentities($DateTime); ?></h6>
                                </div>
                                <div class="commentsCount">
                                    <?php
                                    $queryApproved = $Connection->query("SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'");
                                    $rowsApproved = mysqli_fetch_array($queryApproved);
                                    $totalApproved = array_shift($rowsApproved);

                                    if ($totalApproved > 0) {
                                        ?>
                                        <div class="totalComments">
                                            Komentar: <?php echo $totalApproved; ?>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                            <h3 id="mainHeading"><?php echo htmlentities($Title); ?></h3>
                            <p class="post">
                                <?php
                                if (strlen($Post) > 150) {
                                    $Post = substr($Post, 0, 150) . '...';
                                }
                                echo htmlentities($Post); ?>
                            </p>
                            <a href="fullPost.php?id=<?php echo $Id; ?>"><span class="btn btn-info">Selengkapnya &rsaquo;&rsaquo;</span></a>
                        </div>

                    </div>
                <?php } ?>
                <div class="paginationS">
                    <div class="page">
                        <!-- Creating Backward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) {
                                ?>

                                <a href="blog.php?Page=<?php echo $Page - 1; ?>" class="pagination"> &laquo; </a>


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
                                    <a href="blog.php?Page=<?php echo $i; ?>" class="pagination active"><?php echo $i; ?></a>
                                <?php
                                } else {
                                    ?>
                                    <a href="blog.php?Page=<?php echo $i; ?>" class="pagination"><?php echo $i; ?></a>
                                <?php   }
                            }
                        } ?>
                        <!-- Creating Forward Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $postPagination) {
                                ?>
                                <a href="blog.php?Page=<?php echo $Page + 1; ?>" class="pagination"> &raquo; </a>
                            <?php
                            }
                        } ?>
                        <!-- End Forward Button area -->
                    </div>
                </div>
            </div>
            <!--Main Blog Area Ending-->

            <div class="box4">
                <!--Side Area-->
                <div class="box4-sub">
                    <div class="SchoolLogo">
                        <img src="images/smkn8bone_logo.png" class="imageIcon">
                    </div>
                    <div class="panel panel1">
                        <div class="panelHeading">
                            <h3 class="panelTitle">Kategori</h3>
                        </div>
                        <div class="panelBody background">

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
                                    <span id="sideHeading"><?php echo $CategoryName . "<br>"; ?></span>
                                </a>
                            <?php } ?>

                        </div>
                        <!-- <div class="panelFooter">

                        </div> -->
                    </div>

                    <div class="panel panel2">
                        <div class="panelHeading panelHeading2">
                            <h3 class="panelTitle">Postingan Terbaru</h3>
                        </div>
                        <div class="panelBody2 background">
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
                                <hr>
                                <div class="rcPost">
                                    <div class="img-rcPost">
                                        <img class="img-thumbnail-rcPost" src="assets/<?php echo htmlentities($Image); ?>" ;>
                                    </div>
                                    <div class="desc-rcPost">
                                        <a href="fullPost.php?id=<?php echo $Id; ?>">
                                            <p id="sideHeading"><?php echo htmlentities($Title); ?></p>
                                        </a>
                                        <!-- <p class="description"><?php echo htmlentities($DateTime); ?></p> -->

                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                        <!-- <div class="panelFooter">

                        </div> -->
                    </div>


                </div>
                <!--Side Area Ending-->
            </div>
        </div>
        <!--Container Ending-->
    </main>
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

    <script src="dist/js/main.js?v=<?php echo time(); ?>"></script>
</body>

</html>