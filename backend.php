<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *  Xoops Backend
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @since           2.0.0
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @version         $Id$
 */
include 'mainfile.php';

$GLOBALS['xoopsLogger']->activated = false;
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
header('Content-Type:text/xml; charset=utf-8');

include_once XOOPS_ROOT_PATH.'/class/template.php';
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(3600);
$cache_file='db:system_rss.html';
if(defined('XOOPS_CUBE_LEGACY') && (XOOPS_CUBE_LEGACY==true))
{
	$cache_file='db:legacy_rss.html';
}
if (!$tpl->is_cached($cache_file)) {

	$tpl->assign('channel_title', xoops_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
    $tpl->assign('channel_link', XOOPS_URL . '/');
	$tpl->assign('channel_desc', xoops_utf8_encode(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
    $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
	$tpl->assign('channel_editor', $xoopsConfig['adminmail']);
    $tpl->assign('channel_category', 'News');
    $tpl->assign('channel_generator', 'XOOPS');
    $tpl->assign('channel_language', _LANGCODE);
	if(file_exists(XOOPS_ROOT_PATH . '/images/logo.png'))
	{
		$tpl->assign('image_url', XOOPS_URL . '/images/logo.png');
		$dimention = getimagesize(XOOPS_ROOT_PATH . '/images/logo.png');
	} elseif(file_exists(XOOPS_ROOT_PATH . '/images/logo.gif'))
	{
		$tpl->assign('image_url', XOOPS_URL . '/images/logo.gif');
		$dimention = getimagesize(XOOPS_ROOT_PATH . '/images/logo.gif');
	}
    if (empty($dimention[0])) {
        $width = 88;
    } else {
        $width = ($dimention[0] > 144) ? 144 : $dimention[0];
    }
    if (empty($dimention[1])) {
        $height = 31;
    } else {
        $height = ($dimention[1] > 400) ? 400 : $dimention[1];
    }
    $tpl->assign('image_width', $width);
    $tpl->assign('image_height', $height);

    if (file_exists($fileinc = XOOPS_ROOT_PATH.'/modules/AMS/class/class.newsstory.php')) {
        include $fileinc;
        $sarray = AmsStory::getAllPublished(10, 0, true);
    
	    if (!empty($sarray) && is_array($sarray)) {
	        foreach ($sarray as $story) {
			//print $story->friendlyurl_enable;exit;
				if(1 == $story->friendlyurl_enable)
				{
					$story_link = $story->friendlyurl ;
					$story_guid = $story->friendlyurl ;
				}else
				{
					$story_link = XOOPS_URL . '/modules/AMS/article.php?storyid=' . $story->storyid() ;
					$story_guid = XOOPS_URL . '/modules/AMS/article.php?storyid=' . $story->storyid() ;
				}		
	            $tpl->append('items', array(
	                'title' => xoops_utf8_encode(htmlspecialchars($story->title(), ENT_QUOTES)) ,
					'link' => $story_link ,
					'guid' => $story_guid  ,
	                'pubdate' => formatTimestamp($story->published(), 'rss') ,
	                'description' => xoops_utf8_encode(htmlspecialchars($story->hometext(), ENT_QUOTES))));
	        }
	    }
	}

    if (file_exists($fileinc = XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php')) {
        include $fileinc;
        $sarray = NewsStory::getAllPublished(10, 0, true);
    
	    if (!empty($sarray) && is_array($sarray)) {
	        foreach ($sarray as $story) {
	            $tpl->append('items', array(
	                'title' => xoops_utf8_encode(htmlspecialchars($story->title(), ENT_QUOTES)) ,
	                'link' => XOOPS_URL . '/modules/news/article.php?storyid=' . $story->storyid() ,
	                'guid' => XOOPS_URL . '/modules/news/article.php?storyid=' . $story->storyid() ,
	                'pubdate' => formatTimestamp($story->published(), 'rss') ,
	                'description' => xoops_utf8_encode(htmlspecialchars($story->hometext(), ENT_QUOTES))));
	        }
	    }
	}	


}
$tpl->display($cache_file);
