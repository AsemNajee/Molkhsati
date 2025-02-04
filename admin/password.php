<?php

require_once '../php/functions.php';


if(isset($_SESSION['state']) && $_SESSION['state'] === ADMIN_PASSWORD){
    header('Location: index.php');
    exit;
}
if(isset($_POST['password'])){
    if($_POST['password'] === ADMIN_PASSWORD){
        $_SESSION['state'] = $_POST['password'];
        header('Location: index.php');
        exit;
    }else{
        echo 'wrong password';
    }
}else{
    echo 'no password';
}

?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin</title>
</head>
<body>
    <div class="password admin">
        <div class="container">
            <p class="form-info">هذي الصفحه خاصه بالمشرفين</p>
            <form action="password.php" method="post">
                <span class="text-pass">قم بإدخل الرمز للدخول الى صفحه الاشراف</span>
                <div class="input-text">
                    <div>
                        <p>كلمة السر</p>
                        <input name="password" class="input-pass" type="password" placeholder="ادخل الرمز هنا">
                    </div>
                </div>
                <input type="submit" class="submit" value="دخول">
            </form>
        </div>
    </div>
</body>
</html>