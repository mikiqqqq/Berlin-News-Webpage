<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="German News Website">
  <meta name="keywords" content="HTML, CSS, PHP, JS">
  <meta name="author" content="Filip Miloš">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" media="screen" href="stylesheet.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Petit+Formal+Script&display=swap" rel="stylesheet">
  <title>Article</title>
</head>
<body>
  <div class="page">
    <header id="header-main">
      <div class="redline">
      </div>
      <h1 id="title">B&middot;Z</h1>
      <nav>
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-2 col-md-6 col-sm-12 col-12 link-box">
              <a class="link" href="home.php">HOME</a>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-12 col-12 link-box">
              <a class="link" href="berlin-sport.php">BERLIN-SPORT</a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 col-12 link-box">
              <a class="link" href="kultur-und-show.php">KULTUR UND SHOW</a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 col-12 link-box">
              <a class="link" href="login.php">ADMINISTRATION</a>
            </div>

            <div class="col-lg-2 col-md-12 col-sm-12 col-12 link-box">
              <a class="link" href="add-new-article.html">ADD ARTICLE</a>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <section class="news-article">
      <?php
      include 'connect.php';
      define('UPLPATH', 'images/');

      if(isset($_GET['id'])){
        $id = $_GET['id'];
      }

      $query = "SELECT * FROM vijesti WHERE id=$id";
      $result = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($result)) {
        echo '<div class="clanak-title-box">';
          echo '<h4>' .$row['sazetak']. '</h4>';
          echo '<h2>' .$row['naslov']. '</h2>';
        echo '</div>';
          echo '<img class="article-img"
          src="' . UPLPATH . $row['slika'] . '">';
        echo '<div class="clanak-article-box">';
          echo '<pre class="article-text">' .$row['tekst']. '</pre>';
          echo '<p class="date">' .$row['datum']. '</p>';
        echo '</div>';
      }
      ?>
    </section>

    <footer>
      <div id="footer-text">
        <p>Weitere Online-Angebote der Axel Springer SE:</p>
      </div>
      <div id="opaque-footer-box"></div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
