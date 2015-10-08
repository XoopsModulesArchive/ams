<?php
/**
 * MyLinks module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    mylinks
 * @subpackage:: admin
 * @since::		 2.5.0
 * @author::     Magic.Shao <magic.shao@gmail.com> - Susheng Yang <ezskyyoung@gmail.com>
 * @version::    $Id $
**/

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
require '../../../include/cp_header.php';

if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        //return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        //return false;
    }

$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
//$pathIcon16 = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
//$pathIcon32 = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$thisModDir = $xoopsModule->getVar('dirname', 'n');
xoops_loadLanguage('admin', $thisModDir);
xoops_loadLanguage('modinfo', $thisModDir);
xoops_loadLanguage('main', $thisModDir);

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . '/class/template.php' ;
    $xoopsTpl = new XoopsTpl() ;
}

// Define Stylesheet and JScript
//$xoTheme->addStylesheet( XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/css/admin.css" ) ;
//$xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
//$xoTheme->addScript("browse.php?modules/" . $xoopsModule->getVar("dirname") . "/js/admin.js");

?>
