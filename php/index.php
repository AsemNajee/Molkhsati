<?php

print_r($_FILES);


include_once 'config.php';

// $query = "ALTER TABLE summaries ADD photo_id INT(8) , FOREIGN KEY (photo_id) REFERENCES photos(id)";


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <form action="add_summary.php" enctype="multipart/form-data" method="post">
      <input type="file" name="summary_image">
      <input type="text" name="name" placeholder="name">
      <input type="text" name="section" placeholder="section">
      <input type="text" name="writer" placeholder="writer">
      <input type="text" name="subject" placeholder="subject">
      <input type="text" name="link" placeholder="link">
      <input type="submit">
   </form>
</body>
</html>