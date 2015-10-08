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
include "admin_header.php";
xoops_cp_header();
    $indexAdmin = new ModuleAdmin();	
	//compte "total"
	$count_topics = $topicsHandler->getCount();
	//compte "attente"
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria("topics_online", 1));
	$topics_online = $topicsHandler->getCount($criteria);
	
	//compte "total"
	$count_article = $articleHandler->getCount();
	//compte "attente"
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria("article_online", 1));
	$article_online = $articleHandler->getCount($criteria);	

	//compte "total"
	$count_spotlight = $spotlightHandler->getCount();
	//compte "attente"
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria("spotlight_online", 1));
	$spotlight_online = $spotlightHandler->getCount($criteria);
    
	$indexAdmin->addInfoBox(_AM_AMS_TOPICS);
    $indexAdmin->addInfoBoxLine(_AM_AMS_TOPICS,_AM_AMS_THEREARE_TOPICS, $count_topics) ;
    //$indexAdmin->addInfoBoxLine(_AM_AMS_TOPICS,_AM_AMS_THEREARE_TOPICS_ONLINE, $topics_online) ;  	

  	$indexAdmin->addInfoBox(_AM_AMS_ARTICLES);
    $indexAdmin->addInfoBoxLine(_AM_AMS_ARTICLES,_AM_AMS_THEREARE_ARTICLE, $count_article) ;
    $indexAdmin->addInfoBoxLine(_AM_AMS_ARTICLES,_AM_AMS_THEREARE_ARTICLE_ONLINE, $article_online) ;    	

  	$indexAdmin->addInfoBox(_AM_AMS_SPOTLIGHTS);
    $indexAdmin->addInfoBoxLine(_AM_AMS_SPOTLIGHTS,_AM_AMS_THEREARE_SPOTLIGHT, $count_spotlight) ;
    //$indexAdmin->addInfoBoxLine(_AM_AMS_SPOTLIGHTS,_AM_AMS_THEREARE_SPOTLIGHT_ONLINE, $spotlight_online) ;
	
	$folder = array( XOOPS_ROOT_PATH . '/uploads/ams', 
					 XOOPS_ROOT_PATH . '/uploads/ams/topics',
                     XOOPS_ROOT_PATH . '/uploads/ams/topics/topic_imgurl', 
					 XOOPS_ROOT_PATH . '/uploads/ams/spotlight', 
					 XOOPS_ROOT_PATH . '/uploads/ams/spotlight/spotlight_img');
	
	foreach (array_keys( $folder) as $i) {
        $indexAdmin->addConfigBoxLine($folder[$i], 'folder');
        $indexAdmin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
    }

    echo $indexAdmin->addNavigation("index.php");
    echo $indexAdmin->renderIndex();

include "admin_footer.php";
?>