<?php
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

  $target_dir = 'images/'.$image;
  move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir);

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
