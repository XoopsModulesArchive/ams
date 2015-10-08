<?php 
include '../../../include/cp_header.php';
include_once 'class/class.newsstory.php';
include_once "class/class.newstopic.php";
include_once "class/newsupgrade.php";
xoops_cp_header();
set_magic_quotes_runtime(1);
if (isset($_POST['submit']) && $_POST['submit'] == "Import") {
    //echo NewsUpgrade::prepare2upgrade();
    echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
    echo "<font color='009900'><b>Green text indicates the item was successfully migrated.</font> <br /> <br /> <font color='CC3333'>Red text indicates the item was NOT migrated successfully.</b></font>";
    echo"</td></tr></table><br /> <br />";
    $topics = OldNewsTopic::getAllTopics();
    $error = 0;
    foreach ($topics as $key => $topic) {
        if ($topic->upgrade()) {
            echo "<font color='006600'>".$topic->topic_title." Inserted successfully<br /></font>";
        }
        else {
            echo "<font color='CC3333'>".$topic->topic_title." NOT Inserted <br /></font>";
            $error = 1;
        }
    }
    if ($error==0) {
        $stories = OldNewsStory::getAll();
        foreach ($stories as $key => $story) {
            if (!$story->upgrade()) {
                echo "<font color='006600'>".$story->title." Inserted successfully<br /></font>";
                $success=1;
            }
            else {
                echo "<font color='CC3333'>".$story->title." NOT inserted <br /></font>";
            }
        }
    }
}
elseif (isset($_POST['submit']) && $_POST['submit'] == "Clean") {
    if (OldNewsStory::cleanUp()) {
        echo "Old <b>story</b> data removed";
        if (OldNewsTopic::cleanUp()) {
            echo "<br />Old <b>Topic</b> data removed";
            echo "<br />Don't forget to remove the upgrade folder from modules/AMS";
        }
        else {
            echo "Error removing topic data";
        }
    }
    else {
        echo "Error removing story data";
    }
}

elseif (isset($_POST['submit']) && $_POST['submit'] == "Update") {
    header('location: '.XOOPS_URL.'/modules/system/admin.php?fct=modulesadmin&op=update&module=AMS');
    exit();
}

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$upgrade_form = new XoopsThemeForm('Upgrade', 'upgradeform', 'index.php');
if (!isset($_POST['submit'])) {
    $upgrade_form->addElement(new XoopsFormButton('Import Data from News 1.1', 'submit', 'Import', 'submit'));
}
else {
    //$upgrade_form->addElement(new XoopsFormButton('Remove old data tables', 'submit', 'Clean', 'submit'));
    $upgrade_form->addElement(new XoopsFormButton('Update Article Management System', 'submit', 'Update', 'submit'));
}
$upgrade_form->display();


xoops_cp_footer();
?>