<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />

    <link rel="stylesheet" href="dist/css/main.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="dist/css/style.css?v=<?php echo time(); ?>" />
    <!-- <link rel="stylesheet" href="css/publicstyle.css?v=<?php echo time(); ?>" /> -->

    <link rel="icon" href="/dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <title>Welcome To SMKN 8 Website</title>
</head>

<body id="bg-img">
    <!-- <div class="overlay"></div> -->
    <!-- HEADER area -->
    <header>
        <div class="menu-btn">
            <div class="btn-line"></div>
            <div class="btn-line"></div>
            <div class="btn-line"></div>
        </div>

        <nav class="menu">
            <div class="menu-branding">
                <div class="portrait"></div>
            </div>
            <ul class="menu-nav">
                <li class="nav-item current">
                    <a href="index.html" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="about.html" class="nav-link">Tentang Sekolah</a>
                </li>
                <li class="nav-item">
                    <a href="work.html" class="nav-link">Galeri</a>
                </li>
                <li class="nav-item">
                    <a href="berita.html" class="nav-link">Berita</a>
                </li>
                <li class="nav-item">
                    <a href="http://epanrita.id/" class="nav-link" target="_blank">ePanrita</a>
                </li>
                <li class="nav-item">
                    <a href="contact.html" class="nav-link">Hubungi Kami</a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- end of HEADER area -->

    <!-- MAIN area -->
    <main id="home">
        <!-- CONTAINER1 area -->
        <div class="container1">
            <h1 class="lg-heading" id="index-lg-heading">
                SMKN 8 <span class="text-secondary">BONE</span>
            </h1>
            <h2 class="sm-heading" id="index-sm-heading">
                Selamat Datang di Website SMK Negeri 8 Bone
            </h2>
            <div class="icons">
                <a href="#!">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="#!">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="#!">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="#!">
                    <i class="fab fa-youtube fa-2x"></i>
                </a>
            </div>
        </div>
        <!-- end of CONTAINER1 area -->

        <!-- CONTAINER2 area -->
        <div class="container2">
            <div class="slideshow-container">
                <?php
                $viewQuery = $Connection->query("SELECT * FROM slideshow ORDER BY id desc");
                $SrNo = 0;
                while ($fetchData = mysqli_fetch_array($viewQuery)) {
                    $Id = $fetchData["id"];
                    $DateTime = $fetchData["datetime"];
                    $Image = $fetchData["image"];
                    $Title = $fetchData["title"];
                    $Admin = $fetchData["author"];
                    $SrNo++;

                    ?>
                    <div class="mySlides fade">
                        <div class="numbertext"></div>
                        <img src="slideshows/<?php echo $Image; ?>" width="100%" ; height="400px" ;>
                        <div class="text">
                            <p class="hslide"><?php echo $Title; ?></p>
                            <!-- <p class="pslide">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illo nostrum aliquam unde. Esse cumque praesentium sapiente consectetur ipsam sint laudantium ullam nulla iusto vero dicta excepturi libero, possimus magnam fugiat!</p> -->
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div style="text-align:center">
                <?php
                for ($x = 0; $x <= $Id; $x++) {
                    ?><span class="dot"></span>
                <?php } ?>

            </div>
        </div>
        <!-- end of CONTAINER2 area -->

        <!-- CONTAINER3 area -->
        <div class="container3">
            <p id="container3Heading">Postingan Terbaru</p>
            <div class="wrapper">
                <?php
                //mysqli_query($Connection, "SELECT * FROM category");
                global $Connection;
                $getProduct = $Connection->query("SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5");
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
                    <div class="rcPost">
                        <div class="desc-rcPost">
                            <a href="fullPost.php?id=<?php echo $Id; ?> " target=" _blank">
                                <p id="sideHeading">
                                    <?php
                                        if (strlen($Title) > 50) {
                                            $Title = substr($Title, 0, 50) . '..';
                                        }
                                        echo htmlentities($Title);
                                        ?>
                                </p>
                            </a>
                            <!-- <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime); ?></p> -->
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end of CONTAINER3 area -->
    </main>
    <!-- end of MAIN area -->

    <!-- SCRIPT area -->
    <script src="dist/js/main.js"></script>
    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 6000); // Change image every 10 seconds
        }
    </script>
    <!-- end of SCRIPT area -->
</body>

</html>