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
 
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

global $xoopsConfig, $xoopsModule;

// module information
$mod_url = XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname');
$mod_path = XOOPS_ROOT_PATH . "/modules/".$xoopsModule->getVar('dirname');
$mod_img = XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/txmodxoops_logo.png";
// Attention: if don&#39;t have declared ( _ADMIN ) variable, you can do in languages/yourlanguage/global.php
$mod_admin = "<a href='".$mod_url."/admin/index.php'><strong>"._MD_AMS_ADMIN."</strong></a>";
$mod_copyright = "<a href='http://www.txmodxoops.org' title='TXMod Xoops' target='_blank'>
                     <img src='".$mod_img."' alt='TXMod Xoops' /></a>";

// global language file
if ( file_exists( $mod_path."/language/".$xoopsConfig['language']."/main.php" ) ) {
	include_once $mod_path."/language/".$xoopsConfig['language']."/main.php" ;
} else {
	include_once $mod_path."/language/english/main.php" ;
}
?>