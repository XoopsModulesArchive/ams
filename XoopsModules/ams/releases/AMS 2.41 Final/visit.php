<?php
include "../../mainfile.php";
include_once 'class/class.sfiles.php';

$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
$fileid = (isset($_GET['fileid'])) ? intval($_GET['fileid']) : 0;
if (empty($fileid)) {
    redirect_header("index.php",2,_ERRORS);
    exit();
}

$sfiles = new sFiles($fileid);
$sfiles->updateCounter();
$url=XOOPS_UPLOAD_URL.'/'.$sfiles->getDownloadname();
if (!preg_match("/^ed2k*:\/\//i", $url)) {
	Header("Location: $url");
}
echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL=".$myts->oopsHtmlSpecialChars($url)."\"></meta></head><body></body></html>";
exit();
?>