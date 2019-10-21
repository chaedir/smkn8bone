<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/db.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <!-- HEAD AREA -->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->
    

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/publicstyle.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="css/blogstyle.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="dist/css/main.css?v=<?php echo time(); ?>" />

    <link rel="icon" href="dist/img/smkn8bone_logo.png" type="image/gif" sizes="16x16" />

    <script src="js/jQuery3.4.1.js"></script>

    <script src="js/bootstrap.min.js"></script>

    

    <title>Gallery Page</title>
  </head>
  <!-- END OF HEAD AREA -->

  <!-- STYLE AREA -->
  <style>
    body {
      /* font-family: Verdana, sans-serif; */
      margin: 0;
    }

    * {
      box-sizing: border-box;
    }

    .row {
    display: flex;
    flex-wrap: wrap;
    /* padding: 0 4px; */
  }

    .row > .column {      
      padding: 8px 8px;      
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    .column {
      position: relative;
      flex: 25%;
      max-width: 25%;  
      /* float: left;       */
      /* width: 25%; */
      /* overflow: hidden; */
    }

    .column img {
      display: block;
      height: 30vh;
      width: 100%;
      object-fit: cover;
    }    

    .column .imageTitle{      
      position: absolute; 
      bottom: 4.5px; 
      /* background: rgb(0, 0, 0); */
      background: rgba(0, 0, 0, 0.5); /* Black see-through */
      color: #f1f1f1; 
      width: 95.8%;      
      transition: .5s ease;
      opacity:0;
      color: white;
      font-size: 20px;
      padding: 20px;
      text-align: center;
    }

    .column:hover .imageTitle {
      opacity: 1;
    }

    /* The Modal (background) */
    .modal {
      display: none;
      position: fixed;
      z-index: 2;
      padding-top: 40px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.8);      
    }

    /* Modal Content */
    .modal-content {
      position: relative;      
      margin: auto;
      padding: 0;
      width: 90%;      
      max-width: 1200px;
    }    

    /* The Close Button */
    .closeGlry {      
      position: absolute;
      top: 50px;
      right: 0;
      padding: 0 8px 0 8px;      
      margin-top: -50px;
      color: white;
      font-size: 30px;
      font-weight: bold;
      transition: 0.6s ease;
      border-radius: 0 0 0 3px;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .closeGlry:hover,
    .closeGlry:focus {
      background-color: rgba(0, 0, 0, 0.8);
      text-decoration: none;
      cursor: pointer;
    }

    .mySlides {
      display: none;
    }

    .mySlides .imageDescription{      
      position: absolute; 
      bottom: 2px; 
      /* background: rgb(0, 0, 0); */
      background: rgba(0, 0, 0, 0.5); /* Black see-through */
      color: #f1f1f1; 
      width: 100%;      
      transition: .5s ease;
      opacity:1;
      color: white;
      font-size: 20px;
      padding: 20px;
      text-align: center;
    }

    .cursor {
      cursor: pointer;
    }

    /* Next & previous buttons */
    .prev,
    .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -50px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
      -webkit-user-select: none;
      background-color: rgba(0, 0, 0, 0.4);
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      background-color: rgba(0, 0, 0, 0.4);
      font-size: 12px;
      font-weight: bold;
      padding: 8px 12px;
      position: absolute;
      border-radius: 0 0 3px 0;
      top: 0;
    }

    img {
      margin-bottom: -4px;
    }

    /* .caption-container {
      text-align: center;
      background-color: black;
      padding: 2px 16px;
      color: white;
    } */  

    .demo {
      opacity: 0.6;
    }

    .active,
    .demo:hover {
      opacity: 1;
    }

    img.hover-shadow {
      transition: 0.3s;
    }

    .hover-shadow:hover {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2),
        0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media screen and (max-width: 800px) {
      .column {
        flex: 50%;
        max-width: 50%;
      }
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
      .column {
        flex: 100%;
        max-width: 100%;
      }
    }
  </style>
  <!-- END OF STYLE AREA -->

  <body>
    <!-- HEADER AREA -->
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
                <li class="nav-item current">
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
    </header>
    <!--END OF HEADER AREA -->

    <main id="work">
      <h1 class="lg-heading">
        Galeri <span class="text-secondary">Sekolah</span>
      </h1>
      <h2 class="sm-heading">
        Kegiatan dan Fasilitas Sekolah
      </h2>
    
      <!-- GALLERY AREA -->
      <div class="row">
        <?php
            if (isset($_GET["Page"])) {
              $Page = $_GET["Page"];
              if ($Page < 1) {
                  $ShowPostFrom = 0;
              } else {
                  $ShowPostFrom = ($Page * 8) - 8;
                  //echo $ShowPostFrom;
              }
              $viewQuery = $Connection->query("SELECT * FROM galeri ORDER BY id desc LIMIT $ShowPostFrom,8");              
            } else {
              $viewQuery = $Connection->query("SELECT * FROM galeri ORDER BY id desc LIMIT 0,8");
            }            
            $SrNo = 0;
            while ($fetchData = mysqli_fetch_array($viewQuery)) {
                $Id = $fetchData["id"];
                $DateTime = $fetchData["datetime"];
                $Image = $fetchData["image"];
                $Title = $fetchData["title"];                
                $Admin = $fetchData["author"];
                $SrNo++;
        ?>
          <div class="column">
            <img
              src="gallery/<?php echo $Image; ?>"
              style="width:100%"
              onclick="openModal();currentSlide(1)"
              class="hover-shadow cursor"
            />
            <div class="imageTitle"><?php echo $Title; ?></div>
          </div>
        <?php } ?>     

      <!-- END OF GALLERY -->
    </main>    

      <!-- PAGINATION AREA -->
      <div class="paginationS">
          <div class="page">
              <!-- Creating Backward Button -->
              <?php
              if (isset($Page)) {
                  if ($Page > 1) {
                      ?>
                      <a href="gallery.php?Page=<?php echo $Page - 1; ?>" class="pagination"> &laquo; </a>
                  <?php
                  }
              } ?>
              <!-- End Backward Button area -->
              <?php
              $queryPagination = $Connection->query("SELECT COUNT(*) FROM galeri");
              $rowsPagination = mysqli_fetch_array($queryPagination);
              $totalPosts = array_shift($rowsPagination);
              //echo $totalPosts;
              $postPagination = $totalPosts / 8;
              $postPagination = ceil($postPagination);
              //echo $postPagination;

              for ($i = 1; $i <= $postPagination; $i++) {
                  if (isset($Page)) {
                      if ($i == $Page) {
                          ?>
                          <a href="gallery.php?Page=<?php echo $i; ?>" class="pagination active"><?php echo $i; ?></a>
                      <?php
                      } else {
                          ?>
                          <a href="gallery.php?Page=<?php echo $i; ?>" class="pagination"><?php echo $i; ?></a>
                      <?php   }
                  }
              } ?>
              <!-- Creating Forward Button -->
              <?php
              if (isset($Page)) {
                  if ($Page + 1 <= $postPagination) {
                      ?>
                      <a href="gallery.php?Page=<?php echo $Page + 1; ?>" class="pagination"> &raquo; </a>
                  <?php
                  }
              } ?>
              <!-- End Forward Button area -->
          </div>          
      </div><br>
      <!-- END OF PAGINATION AREA -->

      <!-- LIGHTBOX AREA -->
      <div id="myModal" class="modal">
        <!-- <span class="close cursor" onclick="closeModal()">&times;</span> -->
        <div class="modal-content">
          <!-- FULL SCREEN PHOTO SELECTED AREA -->
          <?php
            $viewQuery = $Connection->query("SELECT * FROM galeri ORDER BY id desc");
            $SrNo = 0;
            while ($fetchData = mysqli_fetch_array($viewQuery)) {
                $Id = $fetchData["id"];
                $DateTime = $fetchData["datetime"];
                $Image = $fetchData["image"];
                $Title = $fetchData["title"];
                $Description = $fetchData["description"];
                $Admin = $fetchData["author"];
                $SrNo++;
          ?>
              <div class="mySlides">
                <!-- total photoes count area -->
                <div class="numbertext"> 
                  <?php
                      $queryTotalPhotoes = $Connection->query("SELECT COUNT(*) FROM galeri");
                      $rowsTotalPhotoes = mysqli_fetch_array($queryTotalPhotoes);
                      $TotalPhotoes = array_shift($rowsTotalPhotoes);

                      if ($TotalPhotoes > 0) {
                          ?>                    
                          <?php echo $SrNo; ?> / <?php echo $TotalPhotoes; ?>                    
                  <?php } ?>
                </div>
                <!-- END OF total photoes count area -->
                <img src="gallery/<?php echo $Image; ?>" style="width:100%; height:90vh; object-fit: cover;" /> 
                <div class="imageDescription"><?php echo $Description; ?></div> 
              </div>            
          <?php } ?>
              <span class="closeGlry cursor" onclick="closeModal()">&times;</span>
              <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1)">&#10095;</a>              
          
          <!-- END OF FULL SCREEN PHOTO SELECTED AREA -->          
        </div>
      </div>
      <!-- END OF LIGHTBOX AREA -->    
      
    <!-- FOOTER AREA -->
    <footer id="main-footer">
          Copyright &copy; 2019 SMKN 8 Bone
    </footer>
    <!-- END OF FOOTER -->
    
    <!-- SCRIPT AREA -->
    <script>
      function openModal() {
        document.getElementById("myModal").style.display = "block";
      }

      function closeModal() {
        document.getElementById("myModal").style.display = "none";
      }

      var slideIndex = 1;
      showSlides(slideIndex);

      function plusSlides(n) {
        showSlides((slideIndex += n));
      }

      function currentSlide(n) {
        showSlides((slideIndex = n));
      }

      function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
          slideIndex = 1;
        }
        if (n < 1) {
          slideIndex = slides.length;
        }
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
      }
    </script>
    <script src="dist/js/main.js?v=<?php echo time(); ?>"></script>
    <!-- END OF SCRIPT AREA -->
  </body>
</html>
