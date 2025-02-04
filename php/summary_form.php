<?php 

require_once 'config.php';
require_once 'functions.php';

$query = "SELECT name, id FROM sections";
$res = mysqli_query($conn, $query);
if($res->num_rows < 1){
   // do some thig to show there is no sections in database.
}
$data['sections']= [];
while($temp = mysqli_fetch_assoc($res)){
   $data['sections'][] = $temp;
}

$query = "SELECT name, id FROM authers";
$res = mysqli_query($conn, $query);
if($res->num_rows < 1){
   // do some thig to show there is no authers in database.
}
$data['authers']= [];
while($temp = mysqli_fetch_assoc($res)){
   $data['authers'][] = $temp;
}

$query = "SELECT name, id FROM subjects";
$res = mysqli_query($conn, $query);
if($res->num_rows < 1){
   // do some thig to show there is no subjects in database.
}
$data['subjects']= [];
while($temp = mysqli_fetch_assoc($res)){
   $data['subjects'][] = $temp;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <div class="container">
      <div class="page-head">

      </div>
      <form action="add_summary.php" enctype="multipart/form-data" method="post">
         <input type="file" name="summary_image">
         <input type="text" name="name" placeholder="name">
         <input type="text" name="section" placeholder="section">
         <input type="text" name="writer" placeholder="writer">
         <input type="text" name="subject" placeholder="subject">
         <input type="text" name="link" placeholder="link">
         <input type="submit">
      </form>
   </div>
</body>
</html>