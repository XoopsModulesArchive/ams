<?php
include "../../mainfile.php";
include_once 'class/class.sfiles.php';
include_once 'class/class.newsstory.php';

$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
$fileid = (isset($_GET['fileid'])) ? intval($_GET['fileid']) : 0;
if (empty($fileid)) {
    redirect_header("index.php",2,_ERRORS);
    exit();
}
$sfiles = new sFiles($fileid);

// Do we have the right to see the file ?
$article = new AmsStory($sfiles->getStoryid());
$gperm_handler =& xoops_gethandler('groupperm');
if (is_object($xoopsUser)) {
$groups = $xoopsUser->getGroups();
} else {
$groups = XOOPS_GROUP_ANONYMOUS;
}
if (!$gperm_handler->checkRight("ams_audience", $article->audienceid, $groups, $xoopsModule->getVar('mid'))) {
redirect_header('index.php', 3, _NOPERM);
exit();
}



$sfiles->updateCounter();
$url=XOOPS_UPLOAD_URL.'/'.$sfiles->getDownloadname();
if (!preg_match("/^ed2k*:\/\//i", $url)) {
	Header("Location: $url");
}
echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL=".$myts->oopsHtmlSpecialChars($url)."\"></meta></head><body></body></html>";
exit();
?>