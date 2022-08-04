<?php
session_start();
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
    <link rel="stylesheet" media="screen" href="css/stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Petit+Formal+Script&display=swap" rel="stylesheet">
    <title>Administration</title>
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
                <a class="link" href="administration.php">ADMINISTRATION</a>
              </div>

              <div class="col-lg-2 col-md-12 col-sm-12 col-12 link-box">
                <a class="link" href="add-new-article.html">ADD ARTICLE</a>
              </div>
            </div>
          </div>
        </nav>
      </header>

      <h2 class="red-h2">ADMINISTRATION</h2>

      <?php
      include 'connect.php';
      define('UPLPATH', 'images/mini_');

      if(isset($_SESSION['$username'])){

      echo '<div class="user">';
        echo '<div class="redline"></div>';
        echo '<div class="redline"></div>';
        echo '<p class="username-p">
        <span class="username">User:</span> '.$_SESSION['$username'].'
        </p>';
        echo '<form enctype="multipart/form-data" action="" method="POST" id="user-form">';
          echo '<button type="submit" name="logout" value="Log out" class="red-button">
          Log out</button>';
        echo '</form>';
      echo '</div>';
      }

      if(isset($_POST['logout'])){
        $_SESSION['$username'] = null;
        $_SESSION['$level'] = null;
        echo "<script> location.href='login.php'; </script>";
      }

      if(isset($_SESSION['$username']) && $_SESSION['$level'] == 1){

        $query = "SELECT * FROM vijesti";
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($result)) {
          echo '<section class="unos" id="article-id='.$row['id'].'">';
          echo '<div class="unos-box">';
          echo '<form enctype="multipart/form-data" action="#article-id='.$row['id'].'" method="POST">
                  <div class="form-item">
                    <label for="title">Title:</label>
                    <div class="form-field">
                      <input type="text" name="title" class="form-field-textual unos-title"
                      value="'.$row['naslov'].'">
                    </div>
                  </div>

                  <div class="form-item">
                    <label for="about">Short summary (max 50 characters):</label>
                    <div class="form-field">
                      <textarea name="about" rows="2" class="form-field-textual">'.$row['sazetak'].'</textarea>
                    </div>
                  </div>

                  <div class="form-item">
                    <label for="content">Body:</label>
                    <div class="form-field">
                      <textarea name="content" rows="10" class="for-field-textual">'.$row['tekst'].'</textarea>
                    </div>
                  </div>

                  <div class="form-item">
                    <img class="small-photo" src="' . UPLPATH .
                    $row['slika'] . '" width=100px>
                    <label for="pphoto">Photo:</label>
                      <input type="file" accept="image/*" class="input-text" id="photo"
                      value="'.$row['slika'].'" name="photo"/><br>
                  </div>

                  <div class="form-item">
                    <label for="category">News category:</label>
                      <select name="category" class="form-field-textual">
                        <option value="sport"';
                        if('sport' == $row['kategorija'])
                        { echo " selected"; }
                        echo'>Sport</option>

                        <option value="culture"';
                        if('culture' == $row['kategorija'])
                        { echo " selected"; }
                        echo'>Culture</option>
                      </select>
                  </div>

                  <div class="form-item">
                    <label>Archived: ';
                        if($row['arhiva'] == 0) {
                          echo '<input type="checkbox" name="archive" id="archive"/>';
                        } else {
                          echo '<input type="checkbox" name="archive" id="archive" checked/>';
                        }
              echo '</label>
                  </div>

                  <br />
                  <div class="submit-item">
                    <input type="hidden" name="id" class="form-field-textual"
                    value="'.$row['id'].'">
                    <button type="submit" name="update" value="Save"
                    class="green-button">Save</button>
                    <button type="reset" value="Cancel" class="neutral-button">
                    Cancel</button>
                    <button type="submit" name="delete" value="Delete"
                    class="red-button">Delete</button>
                  </div>
                  <br /><br />
          </form>';
        echo '</div>';
        echo '</section>';
        }

        if(isset($_POST['delete'])){
          $id=$_POST['id'];
          $query = "DELETE FROM vijesti WHERE id=$id ";
          $result = mysqli_query($dbc, $query);
        }

        if(isset($_POST['update'])){
          $image = $_FILES['photo']['name'];
          $title=$_POST['title'];
          $about=$_POST['about'];
          $content=$_POST['content'];
          $category=$_POST['category'];
          if(isset($_POST['archive'])){
            $archive=1;
          }else{
            $archive=0;
          }

          $id=$_POST['id'];

          if($image == ''){
            $query = "UPDATE vijesti SET naslov='$title', sazetak='$about',
            tekst='$content', kategorija='$category', arhiva='$archive' WHERE id=$id ";
          }else{
            $img_name = substr($image, 0, strrpos($image, "."));

            $target_dir = 'images/'.$image;
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir);

            $img = imagecreatefromstring(file_get_contents($target_dir));
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            $image = $img_name.'.jpeg';
            $original_img = 'images/'.$image;
            $resized_img =  'images/mini_'.$image;
            imagejpeg($img, $original_img, 100);
            imagedestroy($img);

            $maxDim = 430;
            $file_name = $original_img;
            list($width, $height, $type, $attr) = getimagesize( $file_name );
                $target_filename = $original_img;
                $ratio = $width/$height;
                if( $ratio > 1) {
                    $new_width = $maxDim;
                    $new_height = $maxDim/$ratio;
                } else {
                    $new_width = $maxDim*$ratio;
                    $new_height = $maxDim;
                }
                $src = imagecreatefromstring(file_get_contents($file_name));
                $dst = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($src, $original_img, 90);
                imagedestroy($src);
                imagejpeg($dst, $resized_img, 90);
                imagedestroy($dst);

            unlink($target_dir);

            $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content',
            slika='$image', kategorija='$category', arhiva='$archive' WHERE id=$id ";
          }

          $result = mysqli_query($dbc, $query);
          echo("<meta http-equiv='refresh' content='1'>");
        }
      }else{
        echo '<section class="unos">';
          echo '<div class="unos-box">';
            echo '<p id="no-perm">No permission.</p>';
          echo '</div>';
        echo '</section>';
      }
      mysqli_close($dbc);
      ?>

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
