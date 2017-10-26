<?php
include __DIR__ . '/../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/AMS/class/class.newsstory.php';
if (empty($_POST['submit'])) {
    $_POST['submit'] = '';
}
$storyid = isset($_POST['storyid']) ? (int)$_POST['storyid'] : (isset($_GET['storyid']) ? (int)$_GET['storyid'] : 0);
if ($storyid > 0) {
    $article = new AmsStory($storyid);
} else {
    redirect_header(XOOPS_URL.'/modules/AMS/index.php', 3, _AMS_NW_NOSTORY);
    exit();
}
if ('' != $_POST['submit'] && $storyid > 0) {
    if ($article->rateStory($_POST['rating'])) {
        $ratemessage = _AMS_NW_RATING_SUCCESSFUL;
    } else {
        $ratemessage = $article->renderErrors();
    }
    redirect_header(XOOPS_URL . '/modules/AMS/article.php?storyid=' . $article->storyid(), 3, $ratemessage);
    exit();
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'ams_ratearticle.tpl';
    include XOOPS_ROOT_PATH . '/header.php';
    include __DIR__ . '/include/ratingform.inc.php';
}
$xoopsTpl->assign('breadcrumb', $article->getPath(true) . ' > ' . _AMS_NW_RATE);
include __DIR__ . '/../../footer.php';
