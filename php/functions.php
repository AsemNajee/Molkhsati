<?php


session_start();
session_regenerate_id();

const ADMIN_PASSWORD = 'is_the_password';
const MIN_NAME_LETTERS = 3;
const MIN_DISCRIPTION_LETTERS = 5;



function validate($input){
   $output = trim($input);
   $output = htmlspecialchars($output);
   $output = htmlentities($output);
   return $output;
}

function print_api($array){
   echo json_encode($array,JSON_PRETTY_PRINT);
   exit;
}

function add_summary($name, $info, $subject, $section, $writer, $link, $photo_id){
   global $conn;
   $query = 
   "INSERT INTO summaries (name, info, subject_id, section_id, auther_id, link, photo_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssiiisi', $name, $info, $subject, $section, $writer, $link, $photo_id);
   if($stmt->execute()){
      return ['succes'=> true, 'data'=>'تم اضافة بنجاح', 'summary_id'=> mysqli_insert_id($conn)];
   }
   return ['succes'=> false, 'error'=> 'فشل اضافة الملخص'];
}

function edit_summary($name, $info, $link, $id){
   global $conn;
   $query = "UPDATE summaries SET name = ? , info = ?, link = ? WHERE id = ?";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('sssi', $name, $info, $link, $id);
   if($stmt->execute()){
      return ['succes'=> true, 'data'=>'تم تعديل الملخص بنجاح'];
   }
   return ['succes'=> false, 'error'=> 'فشل تعديل الملخص'];
}

function get_summaries($sub, $sec = 'all'){
   global $conn;
   $query = 
   "SELECT s.name, s.info, s.link, s.id,  
   a.name AS auther_name, a.info AS auther_info, a.id AS auther_id
   FROM summaries s 
   JOIN authers a ON a.id = s.auther_id
   JOIN subjects su ON su.id = s.subject_id
   WHERE subject_id = ?";
   if($sec === 'all'){
      $stmt = mysqli_prepare($conn, $query);
      $stmt->bind_param('i', $sub);
   }else{
      $query .= " AND section_id = ?";
      $stmt = mysqli_prepare($conn, $query);
      $stmt->bind_param('ii', $sub, $sec);
   }
   $data = [];
   if($stmt->execute()){
      $res = $stmt->get_result();
      while($item = mysqli_fetch_assoc($res)){
         $data[] = $item;
      }
      return ['succes'=> true, 'data'=> $data];
   }
   return ['succes'=> false, 'error'=> 'فشل استدعاء الملخص'];
}



function upload_img($image){
   if(isset($image['size'], $image['tmp_name'], $image['name'])){
      if($image['error'] !== 0){
         return ['succes'=> false, 'error'=> 'فشل رفع الصورة'];
      }
      $ext = strtolower(end(explode('.', $image['name'])));
      $new_name = rand(0, 99999999999) . '.' . $ext;
      $new_path = $_SERVER['DOCUMENT_ROOT'] . 'summaries/images/';
      print_r($new_path);
      // if(!is_dir($new_path))  
      mkdir($new_path);
      move_uploaded_file($image['tmp_name'], $new_path . $new_name);
      return ['succes'=> true, 'url'=> $new_path . $new_name];
   }
   return ['succes'=> false, 'error'=> 'فشل رفع الصورة'];
}
function add_photo($link){
   global $conn;
   $query = 
   "INSERT INTO photos (link) VALUES (?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('s', $link);
   if($stmt->execute()) return ['succes'=>true, 'photo_id'=>mysqli_insert_id($conn)];
   else return ['succes'=>false, 'photo_id'=> NULL];
}




/** From this line , the code is more perfossional .
 *  I started to do the best in the code
 *  these functions are self save 
 */
function get_sections(){
   global $conn;
   $query = "SELECT * FROM sections";
   $res = mysqli_query($conn, $query);
   $data = [];
   while(($temp = mysqli_fetch_assoc($res))){
      $data[] = $temp;
   }
   return ['succes'=> true, 'data'=> $data];
}

function get_teachers(){
   global $conn;
   $query = "SELECT * FROM teachers";
   $res = mysqli_query($conn, $query);
   $data = [];
   while(($temp = mysqli_fetch_assoc($res))){
      $data[] = $temp;
   }
   return ['succes'=> true, 'data'=> $data];
}
function get_teacher($id){
   global $conn;
   if(!is_numeric($id)){
      return ['succes'=> true, 'error'=> 'حصل خطا'];
   }
   $query = "SELECT * FROM teachers WHERE id = ?";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('i', $id);
   $stmt->execute();
   $res = $stmt->get_result();
   $data = [];
   if($res->num_rows > 0){
      $data[] = mysqli_fetch_assoc($res);
   }
   return ['succes'=> true, 'data'=> $data];
}

function get_subjects(){
   global $conn;
   $query = "SELECT * FROM subjects";
   $res = mysqli_query($conn, $query);
   $data = [];
   while(($temp = mysqli_fetch_assoc($res))){
      $data[] = $temp;
   }
   return ['succes'=> true, 'data'=> $data];
}
function get_authers(){
   global $conn;
   $query = "SELECT * FROM authers";
   $res = mysqli_query($conn, $query);
   $data = [];
   while(($temp = mysqli_fetch_assoc($res))){
      $data[] = $temp;
   }
   return ['succes'=> true, 'data'=> $data];
}


function get_subject($id){
   if(!is_numeric($id)){
      return ['succes' => false, 'error' => 'معرف خاطئ'];
   }
   global $conn;
   $query =
   "SELECT subjects.*, teachers.name AS teacher FROM subjects
   JOIN teachers ON teachers.id = subjects.teacher_id
   WHERE subjects.id = ?";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('i', $id);
   if(!$stmt->execute()){
      return ['succes' => false, 'error' => 'فشل الاستدعاء'];
   }
   $res = $stmt->get_result();
   if($res->num_rows > 0){
      $data = mysqli_fetch_assoc($res);
   }else{
      $data = [];
   }
   return ['succes'=> true, 'data'=> $data];
}

function get_summarie($id){
   global $conn;
   $query = 
   "SELECT summaries.*, 
   authers.name AS auther,
   -- teachers.name AS teacher, 
   sections.name AS section,
   subjects.name AS `subject`
   FROM summaries 
   JOIN authers ON authers.id = summaries.auther_id
   JOIN sections ON sections.id = summaries.section_id
   -- JOIN teachers ON teachers.id = summaries.teacher_id
   JOIN subjects ON subjects.id = summaries.subject_id
   WHERE summaries.id = ?";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('i', $id);
   if (!$stmt->execute()) {
      return ['succes' => false, 'error' => 'فشل الاستدعاء'];
   }
   $res = $stmt->get_result();
   if ($res->num_rows > 0) {
      $data = mysqli_fetch_assoc($res);
   } else {
      $data = [];
   }
   return ['succes' => true, 'data' => $data];
}






function add_auther($data){
   $name = validate($data['name']);
   $info = validate($data['info']);
   global $conn;
   $query = "INSERT INTO authers (name, info) VALUES (?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ss', $name, $info);
   if($stmt->execute()){
      return ['succes'=>true, 'data'=>'تم الاضافة بنجاح'];
   }else{
      return ['succes'=>false, 'error'=>'فشل الاضافة'];
   }
}

function edit_auther($data){
   if(!isset($data['name'], $data['info'], $data['edit_id'])){
      return ['succes'=>false, 'error'=>'فشل التعديل'];
   }
   $name = validate($data['name']);
   $info = validate($data['info']);
   $edit_id = validate($data['edit_id']);
   global $conn;
   $query = "UPDATE authers SET name = ?, info = ? WHERE id = ? ";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssi', $name, $info, $edit_id);
   if($stmt->execute()){
      return ['succes'=>true, 'data'=>'تم التعديل بنجاح'];
   }else{
      return ['succes'=>false, 'error'=>'فشل التعديل'];
   }
}


function add_subject($data){
   $name = validate($data['name']);
   $info = validate($data['info']);
   $teacher_id = validate($data['teacher_id']);
   if(!is_numeric($teacher_id)){
      return ['succes'=>false, 'error'=>'فشل الاضافة'];
   }
   global $conn;
   $query = "INSERT INTO subjects (name, info, teacher_id) VALUES (?, ?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssi', $name, $info, $teacher_id);
   if($stmt->execute()){
      return ['succes'=>true, 'data'=>'تم الاضافة بنجاح'];
   }else{
      return ['succes'=>false, 'error'=>'فشل الاضافة'];
   }
}
function edit_subject($data){
   if (!isset($data['name'], $data['info'], $data['edit_id'])) {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
   $name = validate($data['name']);
   $info = validate($data['info']);
   $edit_id = validate($data['edit_id']);
   global $conn;
   $query = "UPDATE subjects SET name = ?, info = ? WHERE id = ? ";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssi', $name, $info, $edit_id);
   if ($stmt->execute()) {
      return ['succes' => true, 'data' => 'تم التعديل بنجاح'];
   } else {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
}


function add_section($data){
   $name = validate($data['name']);
   $info = validate($data['info']);
   global $conn;
   $query = "INSERT INTO sections (name, info) VALUES (?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ss', $name, $info);
   if($stmt->execute()){
      return ['succes'=>true, 'data'=>'تم الاضافة بنجاح'];
   }else{
      return ['succes'=>false, 'error'=>'فشل الاضافة'];
   }
}
function edit_section($data){
   if (!isset($data['name'], $data['info'], $data['edit_id'])) {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
   $name = validate($data['name']);
   $info = validate($data['info']);
   $edit_id = validate($data['edit_id']);
   global $conn;
   $query = "UPDATE sections SET name = ?, info = ? WHERE id = ? ";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssi', $name, $info, $edit_id);
   if ($stmt->execute()) {
      return ['succes' => true, 'data' => 'تم التعديل بنجاح'];
   } else {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
}


function add_teacher($data){
   $name = validate($data['name']);
   $info = validate($data['info']);
   global $conn;
   $query = "INSERT INTO teachers (name, info) VALUES (?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ss', $name, $info);
   if($stmt->execute()){
      return ['succes'=>true, 'data'=>'تم الاضافة بنجاح'];
   }else{
      return ['succes'=>false, 'error'=>'فشل الاضافة'];
   }
}
function edit_teacher($data){
   if (!isset($data['name'], $data['info'], $data['edit_id'])) {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
   $name = validate($data['name']);
   $info = validate($data['info']);
   $edit_id = validate($data['edit_id']);
   global $conn;
   $query = "UPDATE teachers SET name = ?, info = ? WHERE id = ? ";
   $stmt = mysqli_prepare($conn, $query);
   $stmt->bind_param('ssi', $name, $info, $edit_id);
   if ($stmt->execute()) {
      return ['succes' => true, 'data' => 'تم التعديل بنجاح'];
   } else {
      return ['succes' => false, 'error' => 'فشل التعديل'];
   }
}


function password($word){
   if($word === ADMIN_PASSWORD){
      $_SESSION['state'] = 'admin';
      return true;
   }else{
      return false;
   }
}

function get_profile($id){
   global $conn;
   if (is_numeric($id)) {
      $data = []; 
      $query = "SELECT * FROM subjects WHERE id = ?";
      $stmt = mysqli_prepare($conn, $query);
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows > 0) {
         $data = mysqli_fetch_assoc($res);
      }else{
         return [];
      }
      $query =
      "SELECT s.*, l.name AS link_name , l.info AS link_info , 
      l.link AS link_link FROM subjects s
      RIGHT JOIN links l ON l.subject_id = s.id
      WHERE s.id = ?
      ";
      $stmt = mysqli_prepare($conn, $query);
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows > 0) {
         while($temp = mysqli_fetch_assoc($res)){
            $data['links'][] = $temp;
         }
      }else{
         $data['links'] = [];
      }
      return $data;
   }
   return [];
}