<?php

require_once 'config.php';
require_once 'functions.php';

if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
   print_api(['succes'=>false, 'error'=> 'ليس لديك اي صلاحيات']);
}

$data = json_decode(file_get_contents('php://input'), true);
// $data = $_POST;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if(isset($data['name'], $data['section'], $data['subject'], $data['writer'], $data['link'], $data['info'])){
      $section = validate($data['section']);
      $subject = validate($data['subject']);
      $writer = validate($data['writer']);
      $name = validate($data['name']);
      $link = validate($data['link']);
      $info = validate($data['info']);
      if(isset($_FILES['summary_image'])){
         if(($link_image = upload_img($_FILES['summary_image']))['succes']){
            $photo_id = add_photo($link_image['url'])['photo_id'];
         }else{
            $photo_id = null;
         }
      }else{
         $photo_id = null;
      }
      if((is_numeric($section) and is_numeric($subject) and is_numeric($writer))){
         print_api(add_summary($name, $info, $subject, $section, $writer, $link, $photo_id));
      }
   }else if(isset($data['name'], $data['info'], $data['link'], $data['edit_id'])){
      $name = validate($data['name']);
      $link = validate($data['link']);
      $info = validate($data['info']);
      $edit_id = validate($data['edit_id']);
      print_api(edit_summary($name, $info, $link, $edit_id));
   }
}
print_api(['succes'=> false, 'error'=> 'invalid']);
