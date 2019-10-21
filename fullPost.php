<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $Name = mysqli_real_escape_string($Connection, $_POST["Name"]);
    $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    $Comment = mysqli_real_escape_string($Connection, $_POST["Comment"]);
    date_default_timezone_set("Asia/Makassar");
    $CurrentTime = time();
    //$DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $DateTime = strftime("%A %H:%M - %d %B %Y", $CurrentTime);
    $DateTime;
    $PostIDFromURL = $_GET["id"];
    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "Semua kolom harus terisi";
    } elseif (strlen($Comment) > 500) {
        $_SESSION["ErrorMessage"] = "Komentar maksimal 500 karakter";
    } else {
        //global $Connection;  
        $PostIDFromURL = $_GET["id"];
        $Query = mysqli_query($Connection, "INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id) VALUES('" . $DateTime . "','" . $Name . "','" . $Email . "','" . $Comment . "','" . PENDING . "','" . OFF . "','" . $PostIDFromURL . "')");
        if ($Query) {
            $_SESSION["SuccessMessage"] = "Sukses, komentar anda menunggu persetujuan admin";
            Redirect_to("fullPost.php?id={$PostIDFromURL}");
        } else {
            $_SESSION["ErrorMessage"] = "Terjadi kesalahan, coba lagi!";
            Redirect_to("fullPost.php?id={$PostIDFromURL}");
        }
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
    <link rel="stylesheet" href="dist/css/main.css?v=<?php echo time(); ?>" />

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" /> -->

    <link rel="stylesheet" href="css/publicstyle.css?v=<?php echo time(); ?>" />

    <link rel="stylesheet" href="css/blogstyle.css?v=<?php echo time(); ?>" />

    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <script src="js/jQuery3.4.1.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />

    <title>Full Blog Post</title>

    <style>
        .Fieldinfo {
            color: #005e90;
            font-family: 'Times New Roman', Times, serif;
            font-size: 1.2em;
        }
    </style>
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

        <!--Container-->
        <div class="container">
            <!--Main Blog Area-->
            <div class="box3">
                <div class="blogpostFullPost">
                    <div class="blogpostFullPost1">
                        <?php echo Message();
                        echo SuccessMessage();
                        ?>
                        <?php
                        if (isset($_GET["searchButton"])) {
                            $Search = $_GET["search"];
                            $viewQuery = $Connection->query("SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category_name LIKE '%$Search%' OR post LIKE '%$Search%'");
                        } else {
                            $PostIDFromURL = $_GET["id"];
                            $viewQuery = $Connection->query("SELECT * FROM admin_panel WHERE id='$PostIDFromURL' ORDER BY datetime");
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

                            <div class="img-areaFullPost">
                                <h2 id="mainHeadingFullPost"><?php echo htmlentities($Title); ?></h2>
                                <div class="published">
                                    <h6 class="description">Kategori: <?php echo htmlentities($Category); ?> | <?php echo htmlentities($DateTime); ?></h6>

                                </div>
                                <img class="img-thumbnailFullPost" src="assets/<?php echo $Image; ?>" ;>
                            </div>

                            <div class="captionFullPost">
                                <div class="captionInside">
                                    <p class="post">
                                        <?php
                                        echo nl2br($Post);
                                        ?>
                                    </p>
                                </div>

                            </div>

                        <?php } ?>

                        <div class="commentsFullPost">
                            <br>
                            <h3 class="fieldInfo">Respon pembaca</h3>
                            <br>

                            <!-- Comments Area -->
                            <?php
                            $PostIDFromURL = $_GET["id"];
                            $extractingCommentQuery = $Connection->query("SELECT * FROM comments WHERE admin_panel_id='$PostIDFromURL' AND status='ON' ORDER BY datetime desc");
                            while ($fetchData = mysqli_fetch_array($extractingCommentQuery)) {
                                $commentDate = $fetchData["datetime"];
                                $commentatorName = $fetchData["name"];
                                $userComment = $fetchData["comment"];
                                ?>

                                <div class="commentBlock">
                                    <img class="commentIcon" src="images/user.png" width="70px" ; height="70px" ;>
                                    <div class="info">
                                        <p class="commentInfo"><?php echo $commentatorName; ?></p>
                                        <p class="description2"><?php echo $commentDate; ?></p>
                                    </div>

                                    <p class="commentS"><?php echo nl2br($userComment); ?></p>
                                </div>
                                <!-- End of Comments Area -->
                                <hr>
                            <?php } ?>

                            <br><br>
                            <!-- Write Comment Area -->
                            <h3 class="fieldInfo">Beri tanggapan anda pada kolom komentar</h3>
                            <br>
                            <div class="insertComment">
                                <form action="fullPost.php?id=<?php echo $PostIDFromURL; ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="col-25">
                                            <label for="Name">Name</label>
                                        </div>
                                        <div class="col-75">
                                            <input id="codeName" type="text" name="Name" id="commentator_Name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-25">
                                            <label for="Email">Email</label>
                                        </div>
                                        <div class="col-75">
                                            <input type="email" name="Email" id="commentator_Email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-25">
                                            <label for="commentarea">Comment</label>
                                        </div>
                                        <div class="col-75">
                                            <textarea name="Comment" id="commentarea"></textarea>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="Submit" value="Submit Comment">
                                    </div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Write Comment Area -->


            </div>
            <!--Main Blog Area Ending-->

            <!--Side Area-->
            <div class="box4">
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
                            $getProduct    = $Connection->query("SELECT * FROM category ORDER BY datetime desc");
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
                        <!-- <div class="panel-footer">

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
                            $getProduct    = $Connection->query("SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5");
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
                                        <!-- <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime); ?></p> -->
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                        <!-- <div class="panel-footer">

                        </div> -->
                    </div>

                </div>
            </div>
            <!--Side Area Ending-->
        </div>
        <!--Container Ending-->

    </main>
    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

    <script src="dist/js/main.js?v=<?php echo time(); ?>"></script>
</body>

</html>