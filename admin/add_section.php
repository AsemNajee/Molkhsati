<?php

require_once '../php/functions.php';


if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
    header('Location: password.php');
    exit;
}



require_once 'header.php';
?>


<body>
    <div class="admin">
        <div class="notify"></div>
        <p class="form-info">اضافه قسم</p>
        <div class="container">
            <form action="" class="section-form">
                <div class="input-text section">
                    <div class="name">
                        <p>الاسم</p>
                        <input type="text" name="nameOfSection" placeholder="ادخل اسم القسم">
                        <span class="error">قم بإدخال الاسم بشكل صحيح</span>
                    </div>
                    <div class="description">
                        <p>الوصف</p>
                        <input type="text" name="description" placeholder="ادخل وصف للقسم">
                        <span class="error">قم بإدخال وصف مناسب</span>
                    </div>
                </div>
                <input class="submit" type="submit" value="نشر">
            </form>
        </div>
    </div>
    <script src="../asem.js"></script>
    <script>
        const MIN_NAME_LETTERS = <?php echo MIN_NAME_LETTERS ?>;
        const MIN_DISCRIPTION_LETTERS = <?php echo MIN_DISCRIPTION_LETTERS ?>;

        const sectionForm = document.querySelector('.section-form');
        const sectionName = document.querySelector('[name="nameOfSection"]');
        const sectionDecription = document.querySelector('[name="description"]');
        const sectionErrorNam = document.querySelector('.section .name .error');
        const sectionErrorDecrp = document.querySelector('.section .description .error');

        sectionForm.onsubmit = function(event) {
            event.preventDefault();
            let theName = false;
            let theDecrp = false;
            if (sectionName.value.length >= MIN_NAME_LETTERS) {
                theName = true;
                sectionErrorNam.classList.remove('show')
            } else {
                sectionErrorNam.classList.add('show')
                theName = false;
            }
            if (sectionDecription.value.length >= MIN_DISCRIPTION_LETTERS) {
                theDecrp = true;
                sectionErrorDecrp.classList.remove('show')
            } else {
                sectionErrorDecrp.classList.add('show')
                theDecrp = false;
            }
            if (theName && theDecrp) {
                sendForm(sectionName.value, sectionDecription.value)
            }
        }

        function sendForm(name, discription) {
            const api = '../php/add_section.php'
            fetch(api, {
                    'method': 'POST',
                    'body': JSON.stringify({
                        'name': name,
                        'info': discription,
                        <?php if (isset($_GET['id'])) { ?> 
                            'edit_id': <?php echo $_GET['id'] ?>
                        <?php } ?>
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
                    sectionForm.reset();
                })
                .then(err => console.log(err))
        }
    </script>
</body>

</html>