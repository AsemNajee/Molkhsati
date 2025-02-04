<?php

require_once 'config.php';
require_once 'functions.php';

if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
   print_api(['succes'=>false, 'error'=> 'ليس لديك اي صلاحيات']);
}

$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['name'], $data['info'], $data['teacher_id'])){
   if (isset($data['edit_id'])) {
      print_api(edit_subject($data));
   }
   print_api(add_subject($data));
}
print_api(['succes'=> false, 'error'=> 'لا يوجد مدخلات']);
