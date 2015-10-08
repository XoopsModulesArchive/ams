<?php   
/**
 * ****************************************************************************
 *       - Original Copyright (TDM)
 *       - TDMCreate By TDM - TEAM DEV MODULE FOR XOOPS
 *       - Licence GPL Copyright (c) (http://www.tdmxoops.net)
 *       - Developers TEAM TDMCreate Xoops - (http://www.xoops.org)
 * ****************************************************************************
 *       AMS - MODULE FOR XOOPS
 *        Copyright (c) 2007 - 2011
 *       TXMod Xoops (http://www.txmodxoops.org)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  ------------------------------------------------------------------------
 *
 * @copyright       TXMod Xoops (http://www.txmodxoops.org)
 * @license         GPL see LICENSE
 * @package         ams
 * @author          TXMod Xoops (info@txmodxoops.org)
 *
 * Version : 3.01 Thu 2011/11/24 6:00:35 : Timgno Exp $
 * ****************************************************************************
 */
 include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
include_once '../include/functions.php';
include_once '../include/functions.inc.php';
include_once XOOPS_ROOT_PATH."/class/tree.php";

$pathDir = $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin');
$globlang = $GLOBALS['xoopsConfig']['language'];

if ( file_exists($pathDir.'/language/'.$globlang.'/main.php')){
        include_once $pathDir.'/language/'.$globlang.'/main.php';        
    }else{
        include_once $pathDir.'/language/english/main.php';        
    }
    
if ( file_exists($pathDir.'/moduleadmin.php')){
        include_once $pathDir.'/moduleadmin.php';
        //return true;
    }else{
        xoops_cp_header();
        echo xoops_error(_AM_ERROR_NOFRAMEWORKS);
        xoops_cp_footer();
        //return false;
    }

$module_handler =& xoops_gethandler('module');
$xoopsModule = & $module_handler->getByDirname(basename(dirname(dirname( __FILE__ ) ))); 
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');
$settingHandler=& xoops_getModuleHandler('ams_setting','ams');
$articleHandler=& xoops_getModuleHandler('ams_article','ams');
$textHandler=& xoops_getModuleHandler('ams_text','ams');
$filesHandler=& xoops_getModuleHandler('ams_files','ams');
$topicsHandler=& xoops_getModuleHandler('ams_topics','ams');
$linkHandler=& xoops_getModuleHandler('ams_link','ams');
$ratingHandler=& xoops_getModuleHandler('ams_rating','ams');
$audienceHandler=& xoops_getModuleHandler('ams_audience','ams');
$spotlightHandler=& xoops_getModuleHandler('ams_spotlight','ams');

$myts =& MyTextSanitizer::getInstance();

if ($xoopsUser) {
    $moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
    exit();
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}

$xoopsTpl->assign('pathImageIcon', $pathImageIcon);
$xoopsTpl->assign('pathImageAdmin', $pathImageAdmin);

//Load languages
xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));
