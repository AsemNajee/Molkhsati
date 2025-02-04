<?php

require_once 'php/config.php';
require_once 'php/functions.php';


if (!isset($_GET['id'])) {
    // exit;
}
$res = get_summarie($_GET['id']);
if ($res['succes']) {
    $data = $res['data'];
} else {
    $data = [];
}

require_once 'header.php';

?>

<body>
    <div class="summary-description">
        <div class="container">
            <h3 class="name-descrp"><?php echo $data['name'] ?></h3>
            <div class="descrp">
                <?php echo $data['info'] ?>
            </div>
            <div class="descrp-info">
                <div class="box-descrp">
                    <p>المقرر : </p>
                    <span class="names"><?php echo $data['subject'] ?></span>
                </div>
                <!-- <div class="box-descrp">
                    <p>المدرس : </p>
                    <span class="names"><?php #echo '$data[\'teacher\']' ?></span>
                </div> -->
                <div class="box-descrp">
                    <p>القسم : </p>
                    <span class="names"><?php echo $data['section'] ?></span>
                </div>
                <div class="publisher-info">
                    <span class="publisher">تلخيص : <span class="publisher-name"><?php echo $data['auther'] ?></span></span>
                    <span class="time"><?php echo $data['published_at'] ?></span>
                </div>
            </div>
            <a href="<?php echo $data['link'] ?>" class="descrp-link">تحميل</a>
        </div>
    </div>
</body>

</html>