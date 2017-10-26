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

// get path to icons
$pathIcon32='';
if (class_exists('Xmf\Module\Admin', true)) {
    $pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
}

$adminmenu=array();

$adminmenu[] = array(
    'title' => _AMS_MI_HOME ,
    'link'  => 'admin/index.php' ,
    'icon'  => $pathIcon32.'home.png'
);

$adminmenu[] = array(
    'title' => _AMS_MI_NEWS_ADMENU2,
    'link'  => 'admin/articles.php?op=topicsmanager',
    'icon'  => $pathIcon32.'category.png',
);

$adminmenu[] = array(
    'title' => _AMS_MI_NEWS_ADMENU3,
    'link'  => 'admin/articles.php?op=newarticle',
    'icon'  => $pathIcon32.'content.png',
);

$adminmenu[] = array(
    'title' => _AMS_MI_NEWS_GROUPPERMS,
    'link'  => 'admin/groupperms.php',
    'icon'  => $pathIcon32.'permissions.png',
);

$adminmenu[] = array(
    'title' => _AMS_MI_SPOTLIGHT,
    'link'  => 'admin/spotlight.php',
    'icon'  => $pathIcon32.'insert_table_row.png',
);

$adminmenu[] = array(
    'title' => _AMS_MI_AUDIENCE,
    'link'  => 'admin/articles.php?op=audience',
    'icon'  => $pathIcon32.'users.png',
);

$adminmenu[] = array(
    'title' => 'SEO',
    'link'  => 'admin/seo.php',
    'icon'  => $pathIcon32.'search.png',
);

$adminmenu[] = array(
    'title' => _AMS_MI_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32.'about.png',
);
