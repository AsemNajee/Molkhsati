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
        <p class="form-info">اضافه ناشر</p>
        <div class="container">
            <form action="" class="author-form">
                <div class="input-text author">
                    <div class="name">
                        <p>الاسم</p>
                        <input type="text" name="nameOfAuthor" placeholder="ادخل اسم الناشر">
                        <span class="error">قم بإدخال الاسم بشكل صحيح</span>
                    </div>
                    <div class="description">
                        <p>الوصف</p>
                        <input type="text" name="description" placeholder="ادخل وصف للناشر">
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

        const authorForm = document.querySelector('.author-form');
        const authorName = document.querySelector('[name="nameOfAuthor"]');
        const authorDecription = document.querySelector('[name="description"]');
        const authorErrorNam = document.querySelector('.author .name .error');
        const authorErrorDecrp = document.querySelector('.author .description .error');
        console.log(authorForm, authorName, authorDecription, authorErrorDecrp, authorErrorNam)

        authorForm.onsubmit = function(event) {
            event.preventDefault();
            let theName = false;
            let theDecrp = false;
            if (authorName.value.length >= MIN_NAME_LETTERS) {
                theName = true;
                authorErrorNam.classList.remove('show')
            } else {
                authorErrorNam.classList.add('show')
                theName = false;
            }
            if (authorDecription.value.length >= MIN_DISCRIPTION_LETTERS) {
                theDecrp = true;
                authorErrorDecrp.classList.remove('show')
            } else {
                authorErrorDecrp.classList.add('show')
                theDecrp = false;
            }
            if (theName && theDecrp) {
                sendForm(authorName.value, authorDecription.value)
            }
        }

        function sendForm(name, discription) {
            const api = '../php/add_auther.php'
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
                    authorForm.reset();
                })
                .then(err => console.log(err))
        }
    </script>
</body>

</html>