<?php

require_once '../php/config.php';
require_once '../php/functions.php';


if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
    header('Location: password.php');
    exit;
}

$res = get_teachers();
if ($res['succes']) {
    $teachers = $res['data'];
} else {
    $teachers = [];
}



require_once 'header.php';
?>


<body>
    <div class="admin">
        <div class="notify"></div>
        <p class="form-info">اضافه مادة او مقرر</p>
        <div class="container">
            <form action="" class="subject-form">
                <div class="input-text subject">
                    <div class="name">
                        <p>الاسم</p>
                        <input type="text" name="nameOfSubject" placeholder="ادخل اسم المادة">
                        <span class="error">قم بإدخال الاسم بشكل صحيح</span>
                    </div>
                    <div class="description">
                        <p>الوصف</p>
                        <input type="text" name="description" placeholder="ادخل وصف للمادة">
                        <span class="error">قم بإدخال وصف مناسب</span>
                    </div>
                </div>
                <fieldset>
                    <select class=".teacher" name="teacher" id="">
                        <option>حدد مدرس المقرر</option>
                        <?php
                        foreach ($teachers as $teacher) {
                            echo '<option value="' . $teacher['id'] . '">' . $teacher['name'] . '</option>';
                        }
                        ?>
                    </select>
                </fieldset>
                <input type="submit" class="submit" value="نشر">
            </form>
        </div>
    </div>
    <script src="../asem.js"></script>
    <script>
        const MIN_NAME_LETTERS = <?php echo MIN_NAME_LETTERS ?>;
        const MIN_DISCRIPTION_LETTERS = <?php echo MIN_DISCRIPTION_LETTERS ?>;

        const subjectForm = document.querySelector('.subject-form');
        const subjectDecription = document.querySelector('[name="description"]');
        const subjectName = document.querySelector('[name="nameOfSubject"]');
        const subjectErrorNam = document.querySelector('.subject .name .error');
        const subjectTeacher = document.querySelector('[name="teacher"]');
        const subjectErrorDecrp = document.querySelector('.subject .description .error');
        // console.log(subjectForm, subjectName, subjectDecription, subjectErrorNam, subjectErrorDecrp)

        // console.log(subjectTeacher.value);
        subjectForm.onsubmit = function(event) {
            event.preventDefault();
            let theName = false;
            let theDecrp = false;
            let theTeach = false;
            if (subjectName.value.length >= MIN_NAME_LETTERS) {
                theName = true;
                subjectErrorNam.classList.remove('show')
            } else {
                subjectErrorNam.classList.add('show')
                theName = false;
            }
            if (subjectDecription.value.length >= MIN_DISCRIPTION_LETTERS) {
                theDecrp = true;
                subjectErrorDecrp.classList.remove('show')
            } else {
                subjectErrorDecrp.classList.add('show')
                theDecrp = false;
            }
            if (subjectTeacher.value) {
                theTeach = true;
            }
            if (theName && theDecrp && theTeach) {
                sendForm(subjectName.value, subjectDecription.value, subjectTeacher.value)
            }
        }

        function sendForm(name, discription, teacher_id) {
            const api = '../php/add_subject.php'
            fetch(api, {
                    'method': 'POST',
                    'body': JSON.stringify({
                        'name': name,
                        'info': discription,
                        'teacher_id': teacher_id,
                        <?php if (isset($_GET['id'])) { ?> 
                            'edit_id': <?php echo $_GET['id'] ?>
                        <?php } ?>
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data['succes']) {
                        document.querySelector('.notify').innerHTML += NotifyTemplete('نجح ', data['data'])
                    } else {
                        document.querySelector('.notify').innerHTML += NotifyTemplete('فشل ', data['error'], 'warrning')
                    }
                    subjectForm.reset();
                })
                .then(err => console.log(err))
        }
    </script>
</body>

</html>