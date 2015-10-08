<?php
if (!defined("XOOPS_ROOT_PATH")) {
     die("XOOPS root path not defined");
}

if ( !defined("XOOPS_VAR_PATH") )
{
    $ams_setting=XOOPS_ROOT_PATH. '/cache';
} else 
{
    $ams_setting=XOOPS_VAR_PATH. '/configs';
}
if (file_exists($ams_setting.'/xoops_ams_seo_setting.php')) {
unlink($ams_setting.'/xoops_ams_seo_setting.php');
}
?>