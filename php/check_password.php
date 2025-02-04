<?php

require_once 'config.php';
require_once 'functions.php';

$data = json_decode(file_get_contents('php://input'));
if(isset($data['password'])){
   if(password($data['password']))
      print_api(['succes'=> true, 'error'=> 'تم اجتياز كلمة المرور بنجاح']);
   else
      print_api(['succes'=> false, 'error'=> 'لا تتطابق المدخلات']);
}
print_api(['succes'=> false, 'error'=> 'لا يوجد مدخلات']);

