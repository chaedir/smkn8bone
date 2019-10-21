<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />    

    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="dist/css/main.css?v=<?php echo time(); ?>" />

    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <title>Contact Us</title>
  </head>

  <body>
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
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
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
                <li class="nav-item current">
                    <a href="kontak.php" class="nav-link">Hubungi Kami</a>
                </li>
        </ul>
      </nav>
    </header>

    <main id="contact">

    <?php
        $viewQuery = $Connection->query("SELECT * FROM contact");
        while ($fetchData = mysqli_fetch_array($viewQuery)) {
            $email = $fetchData["kontak1"];
            $address = $fetchData["kontak2"];            
        }
    ?>

      <h1 class="lg-heading">
        Hubungi <span class="text-secondary">Kami</span>
      </h1>
      <h2 class="sm-heading">
        Anda dapat menghubungi kami di alamat berikut
      </h2>

      <div class="boxes">
        <div>
          <span class="text-secondary">Email: </span> <?php echo nl2br($email); ?>
        </div>
        <div>
          <span class="text-secondary">Address: </span> <?php echo nl2br($address); ?>
        </div>
      </div>
    </main>

    <footer id="main-footer">
      Copyright &copy; 2019 SMKN 8 Bone
    </footer>

    <script src="dist/js/main.js"></script>
  </body>
</html>
