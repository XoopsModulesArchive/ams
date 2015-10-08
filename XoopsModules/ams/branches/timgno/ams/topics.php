<?php   
/**
 * ****************************************************************************
 *  - Original Copyright (TDM)
 *  - TDMCreate By TDM - TEAM DEV MODULE FOR XOOPS
 *  - Licence GPL Copyright (c) (http://www.tdmxoops.net)
 *  - Developers TEAM TDMCreate Xoops - (http://www.xoops.org)
 *  - Revision By TXMod Xoops (http://www.txmodxoops.org)
 * ****************************************************************************
 *  AMS - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  TXMod Xoops (http://www.txmodxoops.org)
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
 *  ---------------------------------------------------------------------------
 *  @copyright       TXMod Xoops (http://www.txmodxoops.org)
 *  @license         GPL see LICENSE
 *  @package         ams
 *  @author          TXMod Xoops (info@txmodxoops.org)
 *
 *  Version : 3.01 Sat 2012/01/14 6:36:53 : Timgno Exp $
 * ****************************************************************************
 */
 
include "header.php";
// SEO Url Rewrite
$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/topics'.$GLOBALS['xoopsModuleConfig']['endofurl'];
if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true&&empty($_POST)) {
	header( "HTTP/1.1 301 Moved Permanently" ); 
	header('Location: '.$url);
	exit(0);
}
$xoopsOption['template_main'] = 'ams_topics.html';	
include_once XOOPS_ROOT_PATH."/header.php";
$criteria = new CriteriaCompo();
$criteria->add( new Criteria('topics_title', '', '!='));
$criteria->setSort("topics_title");
$criteria->setOrder("ASC");
$numrows = $topicsHandler->getCount();
$topics_arr = $topicsHandler->getall($criteria);

//Table view
if ($numrows>0) 
{			
	//$class = "odd";				
	foreach (array_keys($topics_arr) as $i) 
	{	
		//$class = ($class == "even") ? "odd" : "even";
		$xoopsTpl->append('topics', array('id' => $topics_arr[$i]->getVar('topic_id'), 'pid' => $topics_arr[$i]->getVar('topic_pid'), 'imgurl' => $topics_arr[$i]->getVar('topic_imgurl'), 'title' => $topics_arr[$i]->getVar('topic_title'), 'banner' => $topics_arr[$i]->getVar('topic_banner'), 'banner_inherit' => $topics_arr[$i]->getVar('topic_banner_inherit'), 'forum_id' => $topics_arr[$i]->getVar('topic_forum_id'), 'weight' => $topics_arr[$i]->getVar('topic_weight')));								
	}
}

if($xoopsModuleConfig['act_socialnetworks']== 1){  
$social = $xoopsModuleConfig['socialnetworks'];   
$xoopsTpl->assign('social', $social); }

include_once XOOPS_ROOT_PATH."/footer.php";	
?>