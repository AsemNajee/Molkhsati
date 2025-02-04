<?php

require_once 'header.php';
require_once 'php/config.php';
require_once 'php/functions.php';

$res = get_authers();
if ($res['succes']) {
    $authers = $res['data'];
} else {
    $authers = [];
}
?>

<body>
    <div class="about">
        <div class="main-heading">
            <h2>عن الموقع</h2>
        </div>
        <div class="container">
            <div class="about-content">
                <span>ملخاصتي</span>
                <div class="about-descrp">
                    <p class="about-info">
                    موقع ملخصاتي يرحب بكم جميعاً , تم تطوير هذا الموقع لتقديم خدمة الى الطالب
                    وتوفير الملخصات وترتيبها وفهرستها في قاعدة بيانات واحدة . 
                    </p>
                    <div class="logo">
                        <img class="about-logo" src="photos/logo.jpg" alt="">
                    </div>                
                </div>
            </div>
        </div>
        <a href="#developers" class="flowing-icon"><i class="fa fa-angle-double-down fa-2x"></i></a>
    </div>

    <div class="website-devlop team" id="developers">
        <div class="main-heading">
            <h2>مطوري الموقع</h2>
        </div>
        <div class="container">
            <div class="section-devlop">
                <div class="devlop-about">
                    <p>
                    تم تطوير هذا الموقع بخبرات بسيطة من فريق التطوير , ونتمنى ان يكون هذا الموقع مناسباً ومساعداً في تسهيل خدمة الطلاب 
                </p>
                </div>
                <div class="devlop-content">
                    <div class="devlop-info jamal">
                        <img src="photos/jamal.jpg" alt="">
                        <p class="name">جمال مجدي</p>
                        <div class="descrp">مطور الواجهة الامامية</div>
                        <div class="social-media">
                            <a class="telegram" href="#"><i class="fab fa-telegram-plane"></i></a>
                            <a class="gethub" href="#"><i class="fab fa-github"></i></a>
                            <a class="linked-in" href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="devlop-info asem">
                        <img src="photos/photo.jpg" alt="">
                        <p class="name">عاصم ناجي</p>
                        <div class="descrp">مطور الواجهة الخلفيه</div>
                        <div class="social-media">
                            <a class="telegram" href="https://t.me/AsemNajee"><i class="fab fa-telegram-plane"></i></a>
                            <a class="gethub" href="https://AsemNajee.github.io/Portfolio"><i class="fab fa-github"></i></a>
                            <a class="linked-in" href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sum-team team">
        <div class="main-heading">
            <h2>فريق التلخيص</h2>
        </div>
        <div class="container">
            <div class="section-team">
                <div class="team-about">
                    <p>
                    يقوم فريق التلخيص بتكريس وقته وجهده في توفير محتوى من الملخصات يسهل لنا المذاكرة , نشكر هذا الفريق جزيل الشكر ونتمنى لهم النجاح والتفوق
                </p>
                </div>
                <div class="team-content">
                    <?php foreach ($authers as $auther) { ?>
                        <div class="team-info">
                            <i class="use fas <?php echo ($auther['gender'] === 'male' ? 'fa-user-tie' : 'fa-circle-user') ?>"></i>
                            <span class="name"><?php echo $auther['name'] ?></span>
                            <p class="text"><?php echo $auther['info'] ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php

    require_once 'footer.php';

    ?>
</body>

</html>