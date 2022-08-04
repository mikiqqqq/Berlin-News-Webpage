<?php
phpInfo();
include "connect.php";

if(isset($_POST['submit'])){
  $title = $_POST['title'];
  $about = $_POST['about'];
  $content = $_POST['content'];
  $category = $_POST['category'];
  $image = $_FILES['photo']['name'];

  $date = date('d.m.Y.');
  if(isset($_POST['archive'])){
    $archive=1;
  }else{
    $archive=0;
  }

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

  $sql = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) values (?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_stmt_init($dbc);

  if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt,'ssssssi', $date, $title, $about, $content, $image, $category, $archive);
    mysqli_stmt_execute($stmt);
  }

  $query = "SELECT * FROM vijesti WHERE naslov='$title' ";
  $result = mysqli_query($dbc, $query);

  while($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
  }

  mysqli_close($dbc);

  header('Refresh:0; url=news-article.php?id='.$id.'');
}
?>
