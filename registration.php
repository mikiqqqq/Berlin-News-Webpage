<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="description" content="German News Website">
  <meta name="keywords" content="HTML, CSS, PHP, JS">
  <meta name="author" content="Filip Miloš">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" media="screen" href="css/stylesheet.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Petit+Formal+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Registration</title>
</head>
<body>
  <div class="page">
    <header id="header-main">
      <div class="redline">
      </div>
      <h1 id="title">B&middot;Z</h1>
      <nav>
        <div class="container-fluid gx-0">
          <div class="row gx-0">
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

    <?php
    $registration_successful = '';
    $msg='';
    if(isset($_POST['Register'])){
      include "connect.php";

      $name = $_POST['ime'];
      $last_name = $_POST['prezime'];
      $username = $_POST['username'];
      $password = $_POST['pass'];
      $hashed_password = password_hash($password, CRYPT_BLOWFISH);
      $level = 0;

      //Provjera postoji li u bazi već korisnik s tim korisničkim imenom
      $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
      $stmt = mysqli_stmt_init($dbc);
      if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
      }
      if(mysqli_stmt_num_rows($stmt) > 0){
        $msg='Username has already been taken!';
      }else{
        $msg='';
        // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnikau bazi pazeći na SQL injection
        $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka,
          razina)VALUES (?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($dbc);
          if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssd', $name, $last_name, $username,
            $hashed_password, $level);
            mysqli_stmt_execute($stmt);
            $registration_successful = true;
          }
        }

        mysqli_close($dbc);
      }
      //Registracija je prošla uspješno
      if($registration_successful == true) {
        echo '<section class="unos">';
          echo '<div class="unos-box">';
            echo '<p class="reg">'.$username.' has been registered successfully!</p>';
            echo '<p class="reg-msg">Redirecting you back to login page... &nbsp; <i class="fa fa-circle-o-notch fa-spin"></i></p>';
          echo '</div>';
        echo '</section>';
        echo "<script>setTimeout(\"location.href = 'login.php';\",3000);</script>";
      } else {
        //registracija nije protekla uspješno ili je korisnik prvi put došao na
        //stranicu
        ?>

        <section class="unos">
          <div class="unos-box">
            <form enctype="multipart/form-data" action="" method="POST">
              <div class="form-item">
                <label for="title">Name: </label>
                <div class="form-field">
                  <input type="text" name="ime" id="ime" class="form-fieldtextual unos-title">
                  <span id="porukaIme" class="bojaPoruke"></span>
                </div>
              </div>
              <div class="form-item">
                <label for="about">Last name: </label>
                <div class="form-field">
                  <input type="text" name="prezime" id="prezime" class="formfield-textual unos-title">
                  <span id="porukaPrezime" class="bojaPoruke"></span>
                </div>
              </div>
              <div class="form-item">
                <label for="content">Username:</label>
                <div class="form-field">
                  <input type="text" name="username" id="username" class="formfield-textual unos-title">
                  <span id="porukaUsername" class="bojaPoruke"></span>
                  <?php echo '<span class="bojaPoruke">'.$msg.'</span>'; ?>
                </div>
              </div>
              <div class="form-item">
                <label for="pphoto">Password:</label>
                <div class="form-field">
                  <input type="password" name="pass" id="pass" class="formfield-textual unos-title">
                  <span id="porukaPass" class="bojaPoruke"></span>
                </div>
              </div>
              <div class="form-item">
                <label for="pphoto">Repeat password: </label>
                <div class="form-field">
                  <input type="password" name="passRep" id="passRep"
                  class="form-field-textual unos-title">
                  <span id="porukaPassRep" class="bojaPoruke"></span>
                </div>
              </div>
              <br />

              <div class="submit-item">
                <button type="submit" value="Register" class="green-button"
                id="register" name="Register">Register</button>
              </div>
              <br /><br>
            </form>

            <script type="text/javascript">
            document.getElementById("register").onclick = function(event) {
              var slanjeForme = true;

              // Ime korisnika mora biti uneseno
              var poljeIme = document.getElementById("ime");
              var ime = document.getElementById("ime").value;
              if (ime.length == 0) {
                slanjeForme = false;
                poljeIme.style.border = "1px dashed red";
                document.getElementById("porukaIme").innerHTML = "<br>Name is required!<br>";
              } else {
                poljeIme.style.border = "1px solid green";
                document.getElementById("porukaIme").innerHTML = "";
              }

              // Prezime korisnika mora biti uneseno
              var poljePrezime = document.getElementById("prezime");
              var prezime = document.getElementById("prezime").value;
              if (prezime.length == 0) {
                slanjeForme = false;
                poljePrezime.style.border = "1px dashed red";
                document.getElementById("porukaPrezime").innerHTML = "<br>Last name is required!<br>";
              } else {
                poljePrezime.style.border = "1px solid green";
                document.getElementById("porukaPrezime").innerHTML = "";
              }

              // Korisničko ime mora biti uneseno
              var poljeUsername = document.getElementById("username");
              var username = document.getElementById("username").value;
              if (username.length == 0) {
                slanjeForme = false;
                poljeUsername.style.border = "1px dashed red";
                document.getElementById("porukaUsername").innerHTML = "<br>Username is required!<br>";
              } else {
                poljeUsername.style.border = "1px solid green";
                document.getElementById("porukaUsername").innerHTML = "";
              }

              // Provjera podudaranja lozinki
              var poljePass = document.getElementById("pass");
              var pass = document.getElementById("pass").value;
              var poljePassRep = document.getElementById("passRep");
              var passRep = document.getElementById("passRep").value;
              if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                slanjeForme = false;
                poljePass.style.border="1px dashed red";
                poljePassRep.style.border="1px dashed red";
                document.getElementById("porukaPass").innerHTML = "<br>Passwords don't match!<br>";
                document.getElementById("porukaPassRep").innerHTML = "<br>Passwords don't match!<br>";
              } else {
                poljePass.style.border = "1px solid green";
                poljePassRep.style.border = "1px solid green";
                document.getElementById("porukaPass").innerHTML = "";
                document.getElementById("porukaPassRep").innerHTML = "";
              }

              if (slanjeForme != true) {
                event.preventDefault();
              }
            };
            </script>
            <?php
          }
          ?>
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
