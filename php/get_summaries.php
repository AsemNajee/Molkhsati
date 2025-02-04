<?php

require_once 'config.php';
require_once 'functions.php';

$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['subject_id'], $data['section_id'])){
   if(is_numeric($data['subject_id'])){
      $sub = validate($data['subject_id']);
      if(is_numeric($data['section_id'])){
         $sec = validate($data['section_id']);
      }else{
         $sec = 'all';
      }
      print_api(get_summaries($sub, $sec));
   }
}
print_api(['succes'=> false, 'error'=> 'invalid']);