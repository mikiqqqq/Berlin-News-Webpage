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
  <link href="https://fonts.googleapis.com/css2?family=Anek+Malayalam:wght@300&family=Petit+Formal+Script&display=swap" rel="stylesheet">
  <title>Kultur Und Show</title>
</head>
<body>
  <div class="page-kultur">
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

            <div class="col-lg-2 col-md-6 col-sm-12 col-12 link-box">
              <a class="link" href="add-new-article.html">ADD ARTICLE</a>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <h2 class="category-h2">KULTUR UND SHOW</h2>

    <section class="kultur-und-show">
      <div class="container">
        <div class="row">
          <article class="col-lg-4 col-md-12 col-sm-12 col-12">
            <div>
              <a class="kultur-link" href="news-article.php?id=1">
                <img src="images/sandra.png" alt="Sandra Maischberger"/>
                <h4>Sie hast es, shoppen zu gehen</h4>
                <h3>In Sachen Mode hat bei Sandra Maischberger ihr Mann die Hosen an!</h3>
              </a>
            </div>
          </article>

          <article class="col-lg-4 col-md-12 col-sm-12 col-12">
            <div>
              <a class="kultur-link" href="news-article.php?id=1">
                <img src="images/junkhe.png" alt="Harald Junkher"/>
                <h4>Fans schauen in die Rohre</h4>
                <h3>ARD verschiebt Film uber Harald Junkher</h3>
              </a>
            </div>
          </article>

          <article class="col-lg-4 col-md-12 col-sm-12 col-12">
            <div>
              <a class="kultur-link" href="news-article.php?id=1">
                <img src="images/mariella.png" alt="Mariella Ahrens"/>
                <h4>TV-Star Mariella Ahrens</h4>
                <h3>"Meine Tochter sollen wie ich unabhangig durs Leben gehen!"</h3>
              </a>
            </div>
          </article>
          <?php
          include 'connect.php';
          define('UPLPATH', 'images/');

          $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='culture' LIMIT 4";
          $result = mysqli_query($dbc, $query);
          $i=0;
          while($row = mysqli_fetch_array($result)) {
            echo '<article class="col-lg-4 col-md-12 col-sm-12 col-12">';
              echo '<div>';
                echo '<a class="kultur-link" href="news-article.php?id='.$row['id'].'">';
                  echo '<img src="' . UPLPATH . $row['slika'] . '"/>';
                  echo "<h4>" .$row['naslov']. '</h4>';
                  echo '<h3>' .$row['sazetak']. '</h3>';
                echo '</a>';
              echo '</div>';
            echo '</article>';
          }

          mysqli_close($dbc);
          ?>
        </div>
      </div>
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
