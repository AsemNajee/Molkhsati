<?php

require_once 'php/config.php';
require_once 'php/functions.php';

if (!isset($_GET['subject']) or !is_numeric($_GET['subject'])) {
    // stop page 
    header('Location: index.php');
    exit;
}
$res = get_summaries($_GET['subject']);
$data['summaries'] = [];
if ($res['succes']) {
    $data['summaries'] = $res['data'];
} else {
    // stoping page
}
$res = get_sections();
if ($res['succes']) {
    $sections = $res['data'];
} else {
    $sections = [];
}

$res = get_subject($_GET['subject']);
if ($res['succes']) {
    $subject = $res['data'];
} else {
    $subject = [];
}

require_once 'header.php';

?>

<body>
    <header class="header">
        <div class="container">
            <ul class="nav" id="sections">
                <li><a id="all" class="active" onclick="get_summaries('<?php echo $_GET['subject'] ?>', 'all')">الكل</a></li>
                <?php foreach ($sections as $section) { ?>
                    <li><a id="<?php echo $section['id'] ?>" onclick="get_summaries(<?php echo $_GET['subject'] . ',' . $section['id'] ?> )"><?php echo $section['name'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </header>
    <div class="summaries">
        <div class="text">
            <p>ملخصات مقرر <span class="name-of-doctor"><?php echo $subject['name'] ?></span> للدكتور <span class="name-of-doctor"><?php echo $subject['teacher'] ?></span></p>
            <span id="section-info"><?php echo $subject['info'] ?></span>
            <!-- <span>عندما ينتهي الطالب او الطالبة من تلخيص المحاضرة يتم انزالها على الفور</span> -->
        </div>
        <div class="container">
            <div class="content-info" id="summaries">
                <?php foreach ($data['summaries'] as $temp) { ?>
                    <div class="box-info" onclick="location = '<?php echo 'summary_info.php?id=' . $temp['id'] ?>'">
                        <h3><?php echo $temp['name'] ?></h3>
                        <p><?php echo $temp['info'] ?></p>
                        <span class="auther"><?php echo $temp['auther_name'] ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="asem.js"></script>
    </div>
</body>

<?php

require_once 'footer.php';

?>

</html>