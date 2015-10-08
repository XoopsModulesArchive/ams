<?php
// $Id: menu.php,v 1.3 2004/02/28 01:35:23 mithyt2 Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$xoopsModule = $module_handler->getByDirname($dirname);
$pathIcon32 = $xoopsModule->getInfo('icons32');

$i=1;
$adminmenu[$i]['title'] = _AMS_MI_NEWS_ADMIN_HOME ;
$adminmenu[$i]['link'] = 'admin/index.php' ;
$adminmenu[$i]['desc'] = _AMS_MI_NEWS_ADMIN_HOME_DESC ;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/home.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_NEWS_ADMENU2;
$adminmenu[$i]['link'] = "admin/main.php?op=topicsmanager";
$adminmenu[$i]['icon'] = 'images/admin/arguments.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_NEWS_ADMENU3;
$adminmenu[$i]['link'] = "admin/main.php?op=newarticle";
$adminmenu[$i]['icon'] = 'images/admin/article.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_NEWS_GROUPPERMS;
$adminmenu[$i]['link'] = "admin/groupperms.php";
$adminmenu[$i]['icon'] = 'images/admin/lock.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_SPOTLIGHT;
$adminmenu[$i]['link'] = "admin/spotlight.php";
$adminmenu[$i]['icon'] = 'images/admin/see.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_AUDIENCE;
$adminmenu[$i]['link'] = "admin/main.php?op=audience";
$adminmenu[$i]['icon'] = 'images/admin/level.png' ;
$i++;
$adminmenu[$i]['title'] = "SEO";
$adminmenu[$i]['link'] = "admin/seo.php";
$adminmenu[$i]['icon'] = 'images/admin/seo.png' ;
$i++;
$adminmenu[$i]['title'] = _AMS_MI_NEWS_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _AMS_MI_NEWS_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/about.png';
