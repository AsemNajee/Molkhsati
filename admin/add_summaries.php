<?php

require_once '../php/config.php';
require_once '../php/functions.php';


if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
    header('Location: password.php');
    exit;
}

$res = get_authers();
if ($res['succes']) {
    $authers = $res['data'];
} else {
    $authers = [];
}

$res = get_sections();
if ($res['succes']) {
    $sections = $res['data'];
} else {
    $sections = [];
}

$res = get_subjects();
if ($res['succes']) {
    $subjects = $res['data'];
} else {
    $subjects = [];
}



require_once 'header.php';
?>


<body>
    <div class="admin">
        <div class="notify"></div>
        <p class="form-info">اضافه ملخص</p>
        <div class="container">
            <form action="" class="main-form">
                <div class="input-text main">
                    <div class="name">
                        <p>الاسم</p>
                        <input type="text" name="name" placeholder="يرجى اضافه الاسم">
                        <span class="error">الرجاء ادخال الاسم</span>
                    </div>
                    <div class="description">
                        <p>الوصف</p>
                        <textarea name="description" placeholder="ادخل وصف للملخص هنا"></textarea>
                        <span class="error">ادخل وصف مناسب</span>
                    </div>
                    <!-- asem did this code -->
                    <!-- <div class="description">
                        <p>الوصف</p>
                        <input type="text" name="description" placeholder="ادخل وصف للناشر">
                        <span class="error">قم بإدخال وصف مناسب</span>
                    </div> -->
                    <!-- end asem code -->
                    <div class="link">
                        <p>الرابط</p>
                        <input type="url" name="link" placeholder="ادخل الرابط هنا">
                        <span class="error">قم بإدخال الرابط</span>
                    </div>
                </div>
                <fieldset>
                    <select name="subject">
                        <option>حدد المقرر</option>
                        <?php
                        foreach ($subjects as $subject) {
                            echo '<option value="' . $subject['id'] . '">' . $subject['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <select name="section">
                        <option>حدد نوع الملخص</option>
                        <?php
                        foreach ($sections as $section) {
                            echo '<option value="' . $section['id'] . '">' . $section['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <select name="auther">
                        <option>حدد مُلخِص الملف</option>
                        <?php
                        foreach ($authers as $auther) {
                            echo '<option value="' . $auther['id'] . '">' . $auther['name'] . '</option>';
                        }
                        ?>
                    </select>
                </fieldset>
                <input class="submit" type="submit" value="نشر">
            </form>
        </div>
    </div>
    <script src="../asem.js"></script>
    <script>
        const MIN_NAME_LETTERS = <?php echo MIN_NAME_LETTERS ?>;
        const MIN_DISCRIPTION_LETTERS = <?php echo MIN_DISCRIPTION_LETTERS ?>;
        const mainDecription = document.querySelector('[name="description"]');
        const subject = document.querySelector('[name="subject"]');
        const auther = document.querySelector('[name="auther"]');
        const section = document.querySelector('[name="section"]');
        const ErrorDecrp = document.querySelector('.main .description .error');

        let mainForm = document.querySelector('.main-form');
        const mainName = document.querySelector('[name="name"]');
        const mainLink = document.querySelector('[name="link"]');
        const mainErrorNam = document.querySelector('.main .name .error');
        const mainErrorlnk = document.querySelector('.main .link .error')

        mainForm.onsubmit = function(event) {
            event.preventDefault();
            let theName = false;
            let theLink = false;
            let theDecrp = false;
            if (mainName.value.length >= MIN_NAME_LETTERS) {
                theName = true;
                mainErrorNam.classList.remove('show')
            } else {
                mainErrorNam.classList.add('show')
                theName = false;
            }
            if (mainLink.value.length >= 5) {
                theLink = true;
                mainErrorlnk.classList.remove('show')
            } else {
                mainErrorlnk.classList.add('show')
                theLink = false;
            }
            // Asem did this condition .
            if (mainDecription.value.length >= MIN_DISCRIPTION_LETTERS) {
                theDecrp = true;
                ErrorDecrp.classList.remove('show')
            } else {
                ErrorDecrp.classList.add('show')
                theDecrp = false;
            }
            if (theName && theDecrp && theLink) {
                sendForm(mainName.value, mainDecription.value, mainLink.value)
            }
        }

        function sendForm(name, discription, link) {
            const api = '../php/add_summary.php'
            fetch(api, {
                    'method': 'POST',
                    'body': JSON.stringify({
                        'name': name,
                        'link': link,
                        'info': discription,
                        // <?php if(!isset($_GET['id'])) { ?>
                            'section': section.value,
                            'subject': subject.value,
                            'writer': auther.value
                        // <?php }else{ ?>
                            'edit_id': <?php echo $_GET['id'] ?>
                        // <?php } ?>
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data['succes']) {
                        console.log(data['data'])
                        document.querySelector('.notify').innerHTML += NotifyTemplete('نجح ', data['data'])
                    } else {
                        document.querySelector('.notify').innerHTML += NotifyTemplete('فشل ', data['error'], 'warrning')
                    }
                    mainForm.reset();
                })
                .then(err => console.log(err))
        }
    </script>
</body>

</html>