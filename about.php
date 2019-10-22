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

    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <title>About School</title>
</head>

<body>
    <!-- MENU HEADER area -->
    <header>
        <!-- 3 LINE area -->
        <div class="menu-btn">
            <div class="btn-line"></div>
            <div class="btn-line"></div>
            <div class="btn-line"></div>
        </div>
        <!-- end of 3 LINE area -->

        <!-- MENU area -->
        <nav class="menu">
            <div class="menu-branding">
                <div class="portrait"></div>
            </div>
            <ul class="menu-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item current">
                    <a href="about.php" class="nav-link">Tentang Sekolah</a>
                </li>
                <li class="nav-item">
                    <a href="gallery.php?Page=1" class="nav-link">Galeri</a>
                </li>
                <li class="nav-item">
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
        <!-- end of MENU area -->
    </header>
    <!-- end of MENU HEADER area -->

    <main id="about">

        <?php
        $viewQuery = $Connection->query("SELECT * FROM tentang_sekolah");
        while ($fetchData = mysqli_fetch_array($viewQuery)) {
            $Image = $fetchData["image"];
            $p1_title = $fetchData["p1Title"];
            $p1_post = $fetchData["p1Post"];
            $p2_title = $fetchData["p2Title"];
            $p2_post = $fetchData["p2Post"];
            $p3_title = $fetchData["p3Title"];
            $p3_post = $fetchData["p3Post"];
            $p4_title = $fetchData["p4Title"];
            $p4_post = $fetchData["p4Post"];
        }
        ?>

        <h1 class="lg-heading">
            Tentang <span class="text-secondary">Sekolah</span>
        </h1>
        <h2 class="sm-heading">
            Selamat datang di SMKN 8 Bone
        </h2>

        <div class="about-info">
            <img src="assets/<?php echo $Image; ?>" alt="SMKN 8 Bone" class="bio-image" />

            <div class="bio">
                <h3 class="text-secondary">
                    <?php echo $p1_title; ?>
                </h3>
                <p>
                    <?php echo nl2br($p1_post); ?>
                </p>
            </div>

            <div class="job job-1">
                <h3 class="job-head"><?php echo $p2_title; ?></h3>
                <!-- <h6>Fullstack developer</h6> -->
                <p>
                    <?php echo nl2br($p2_post); ?>
                </p>
            </div>

            <div class="job job-2">
                <h3 class="job-head"><?php echo $p3_title; ?></h3>
                <!-- <h6>Front End Developer</h6> -->
                <p>
                    <?php echo nl2br($p3_post); ?>
                </p>
            </div>

            <div class="job job-3">
                <h3 class="job-head"><?php echo $p4_title; ?></h3>
                <!-- <h6>Graphic Designer</h6> -->
                <?php echo nl2br($p4_post); ?>
            </div>
        </div>
    </main>

    <footer id="main-footer">
        Copyright &copy; 2019 SMKN 8 Bone
    </footer>

    <script src="dist/js/main.js"></script>
</body>

</html>