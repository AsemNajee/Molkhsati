<?php


require_once '../php/config.php';
require_once '../php/functions.php';


if (!(isset($_SESSION['state']) and $_SESSION['state'] === ADMIN_PASSWORD)) {
    header('Location: password.php');
    exit;
}

if(isset($_GET['id'])){
    $data = get_teacher($_GET['id']);
    if($data['succes']){
        $data = $data['data'];
    }else{
        $data = null;
    }
}


$opration = '';
$apis = array('teacher', 'section', 'subject', 'auther');
$pages = array('teacher'=>'معلم', 'section'=>'قسم', 'subject'=>'مقرر', 'auther'=>'مُلَخِص');
if(isset($_GET['add']) and in_array($_GET['add'], $apis)){
    $opration = $_GET['add'];
    $api = '../php/add_' . $opration . '.php';
}else{
    header('Location: index.php');
    exit;
}


require_once 'header.php';
?>


<body>
    <!-- to show popup when data sent -->
    <div class="notify"></div> 

    <?php 
        $page_title = 'اضافة ' . $pages[$opration]; 
        require_once 'form_head.php';

        if($opration === 'subject'){
            $res = get_teachers();
            if ($res['succes']) {
                $teachers = $res['data'];
            } else {
                $teachers = [];
            }
        ?>
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
        <?php
        }
    ?>


    <?php
        require_once 'form_tail.php';
    ?>

    <!-- start javaScript -->
    <script src="../asem.js"></script>
    <script>
        const MIN_NAME_LETTERS = <?php echo MIN_NAME_LETTERS ?>;
        const MIN_DISCRIPTION_LETTERS = <?php echo MIN_DISCRIPTION_LETTERS ?>;

        const form = document.querySelector('.form');
        const name = document.querySelector('[name="name"]');
        const info = document.querySelector('[name="info"]');
        const nameError = document.querySelector('.form .name .error');
        const infoError = document.querySelector('.form .description .error');
        console.log(form, name, info, infoError, nameError)

        form.onsubmit = function(event) {
            event.preventDefault();
            let theName = false;
            let theDecrp = false;
            if (name.value.length >= MIN_NAME_LETTERS) {
                theName = true;
                nameError.classList.remove('show')
            } else {
                nameError.classList.add('show')
                theName = false;
            }
            if (info.value.length >= MIN_DISCRIPTION_LETTERS) {
                theDecrp = true;
                infoError.classList.remove('show')
            } else {
                infoError.classList.add('show')
                theDecrp = false;
            }
            if (theName && theDecrp) {
                sendForm(name.value, info.value)
            }
        }

        function sendForm(name, discription) {
            const api = '<?php echo $api ?>'
            fetch(api, {
                    'method': 'POST',
                    'body': JSON.stringify({
                        'name': name,
                        'info': discription,
                        // dont take care about the comment and dont remove it.
                        // <?php if (isset($_GET['id'])) { ?> 
                            'edit_id': <?php echo $_GET['id'] ?>,
                        // <?php } if ($opration === 'subject') { ?> 
                            'teacher_id': document.querySelector('[name=teacher]').value
                        // <?php } ?> end
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
                    form.reset();
                })
                .then(err => console.log(err))
        }
    </script>
</body>

</html>