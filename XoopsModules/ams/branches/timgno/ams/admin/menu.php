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
$dirname = basename( dirname( dirname( __FILE__ ) ) ) ;

$module_handler =& xoops_gethandler("module");
$xoopsModule =& XoopsModule::getByDirname($dirname);
$moduleInfo =& $module_handler->get($xoopsModule->getVar("mid"));
$pathImageAdmin = $moduleInfo->getInfo("icons32");	
	
$adminmenu = array(); 

$i = 1;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU1;
$adminmenu[$i]["link"] = "admin/index.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU1_DESC; 
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/home.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU2;
$adminmenu[$i]["link"] = "admin/topics.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU2_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/category.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU3;
$adminmenu[$i]["link"] = "admin/article.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU3_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/content.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU4;
$adminmenu[$i]["link"] = "admin/permissions.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU4_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/permissions.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU7;
$adminmenu[$i]["link"] = "admin/spotlight.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU10_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/thumbnail.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU5;
$adminmenu[$i]["link"] = "admin/setting.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU6_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/services.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU6;
$adminmenu[$i]["link"] = "admin/audience.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU9_DESC
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/arts.png";
$i++;
$adminmenu[$i]["title"] = _MI_AMS_ADMENU8;
$adminmenu[$i]["link"]  = "admin/about.php";
//$adminmenu[$i]["desc"] = _MI_AMS_ADMENU11_DESC;
$adminmenu[$i]["icon"] = "../../".$pathImageAdmin."/about.png";
unset( $i );
?>