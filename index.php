<?php

require_once 'php/config.php';
require_once 'php/functions.php';


$res = get_subjects();
if ($res['succes']) {
    $data['subjects'] = $res['data'];
} else {
    $data['subjects'] = [];
}

require_once 'header.php';
?>

<body>
    <header>
        <div class="container">
            <h2 class="logo">ملخصاتي</h2>
            <ul class="nav">
                <a href="#subjects">
                    <li>المقررات الدراسية</li>
                </a>
                <a href="about.php">
                    <li>عن الموقع</li>
                </a>
            </ul>
        </div>
    </header>

    <div class="landing">
        <div class="container">
            <div class="text">
                <h1>مرحبا بك, في موقع <span>ملخصاتي</span></h1>
                <p>
                    حيث المعرفه والعلوم والتكنولوجيا,
                    <br>
                        هنا تجدون جميع الملخصات الخاصه بالمقررات الدراسه بطريقة سهلة ومبسطه حيث تم تلخيصها من قبل طلاب وطالبات الكلية
                    </p>
            </div>
            <div class="image">
                <img src="photos/portfolio-2.jpg" alt="">
            </div>
        </div>
        <a href="#subjects"><i class="fa fa-angle-double-down fa-2x"></i></a>
    </div>

    <div class="subjects" id="subjects">
        <div class="container">
            <div class="main-heading">
                <h2>المقررات الدراسية</h2>
                <p>
                    اختر مقرراً لاستعراض جميع ملخصاته
                </p>
            </div>
            <div class="content">
                <?php foreach ($data['subjects'] as $item) { ?>
                    <div class="box" onclick="location = 'summaries.php?subject=<?php echo $item['id'] ?>'">
                        <img src="photos/portfolio-1.jpg" alt="">
                        <div class="info">
                            <h3><?php echo $item['name'] ?></h3>
                            <p><?php echo $item['info'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php

    require_once 'footer.php';

    ?>
</body>

</html>