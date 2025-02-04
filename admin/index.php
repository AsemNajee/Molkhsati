<?php

require_once '../php/functions.php';


if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
   header('Location: password.php');
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/style.css">
   <title>Admin</title>
   <style>
      *{
         box-sizing: content-box;
      }
      ul{
         display: flex;
         flex-direction: column;
         padding: 8px;
         gap: 8px;
         li{
            list-style: none;
            height: 50px;
            a{
               display: inline-block;
               text-align: center;
               line-height: 50px;
               background-color: #eee;
               border-radius: 4px;
               border: 2px solid #ddd;
               height: 100%;
               width: 100%;
               color: #232323;
               font-weight: bold;
            }
         }
      }
   </style>
</head>
<body>
   <div class="links">
      <ul>
         <li><a href="add.php?add=teacher">add teacher</a></li>
         <li><a href="add.php?add=section">add section</a></li>
         <li><a href="add.php?add=subject">add subject</a></li>
         <li><a href="add.php?add=auther">add auther</a></li>
         <li><a href="add_summaries.php?add=">add summaries</a></li>
      </ul>
   </div>
</body>
</html>