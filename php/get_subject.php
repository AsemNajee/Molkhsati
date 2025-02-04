<?php

require_once 'config.php';
require_once 'functions.php';

echo '<pre>';
if (isset($_GET['id'])) {
   $id = $_GET['id'];
} else {
   $data = json_decode(file_get_contents('php://input'), true);
   if (isset($data)) {
      $id = $data['id'];
   } else {
      print_api(['succes' => false, 'error' => 'لا يوجد مدخلات']);
   }
}
print_api(get_profile($id));
echo '</pre>';
