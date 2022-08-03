<?php
session_start();
if(isset($_SESSION['$username'])){
  echo "<script> location.href='administration.php'; </script>";
}
?>
<!DOCTYPE html>
<html>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Log in</title>
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

    <h2 class="red-h2">LOG IN</h2>

    <section class="unos">
      <div class="unos-box">
        <form  enctype="multipart/form-data" action="" method="post">
          <div class="form-item">
            <label for="username">Username:</label>
            <div class="form-field">
              <input type="text" name="username" id="username" class="form-field-textual unos-title">
            </div>
            <span id="usernameMsg" class="errorMessage"></span><br />
          </div>

          <div class="form-item">
            <label for="password">Password:</label>
            <div class="form-field">
              <input type="password" name="password" id="password" class="form-field-textual unos-title">
            </div>
            <span id="passwordMsg" class="errorMessage"></span><br /><br>
          </div>

          <div class="submit-item">
            <button type="submit" value="Login" name="login" id="login"
            class="green-button">Log in</button>
          </div>
          <br/><br/>
        </form>

        <script type = "text/javascript">
        document.getElementById("login").onclick = function(event) {
          var slanje_forme = true;

          var username_elem = document.getElementById("username");
          var username = document.getElementById("username").value;
          if (username == "") {
            slanje_forme = false;
            username_elem.style.border = "1px dashed red";
            document.getElementById("usernameMsg").innerHTML = "Username is required!";
          }else{
            username_elem.style.border = "1px solid black";
            document.getElementById("usernameMsg").innerHTML = "";
          }

          var password_elem = document.getElementById("password");
          var password = document.getElementById("password").value;
          if (password == "") {
            slanje_forme = false;
            password_elem.style.border = "1px dashed red";
            document.getElementById("passwordMsg").innerHTML = "Password can't be empty!";
          }else{
            password_elem.style.border = "1px solid black";
            document.getElementById("passwordMsg").innerHTML = "";
          }

          if (slanje_forme != true) {
            event.preventDefault();
          }
        }
        </script>
        <?php
        include 'connect.php';

        $login = false;
        $admin = false;

        if(isset($_POST['login'])){
          $username = $_POST['username'];
          $password = $_POST['password'];

          $sql="SELECT korisnicko_ime, lozinka, razina, ime, prezime FROM korisnik WHERE korisnicko_ime=?";

          $stmt=mysqli_stmt_init($dbc);

          if (mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt,'s',$username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
          }
          mysqli_stmt_bind_result($stmt, $user, $hashedPassword, $level, $name, $last_name);
          mysqli_stmt_fetch($stmt);

          if ((password_verify($_POST['password'], $hashedPassword) &&
          mysqli_stmt_num_rows($stmt)>0)) {
            if($level == 0){
              $login = true;
              $admin = false;
            }else{
              $login = true;
              $admin = true;
            }

            echo ''.$username. ' ' .$level.'--------------------------------';
            $_SESSION['$username'] = $username;
            $_SESSION['$level'] = $level;
            echo ''.$_SESSION['$level']. ' ' .$_SESSION['$username']. '--------------------------------';
          }else{
            $login = false;
          }

          if($login == true && $admin == true){
            echo "<p class='login-msg'>Logged in successfully! &nbsp; <i class='fa fa-circle-o-notch fa-spin'></i></p>";
          }
          else if($login == true && $admin == false){
            echo "<p class='level-msg'> $name $last_name is not an admin!</p>";
          }
          else{
            echo "<p class='reg-msg'>You don't have a registered account. Register <a href='registration.php'>here.</a></p>";
          }
          if($login){
            echo "<script>setTimeout(\"location.href = 'administration.php';\",3000);</script>";
          }
        }else{
          if(isset($_SESSION['$username'])){
            echo "<script> location.href='administration.php'; </script>";
          }
        }

        mysqli_close($dbc);
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
