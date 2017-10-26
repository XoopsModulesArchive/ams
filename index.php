<?php

use Xmf\Module\Helper;

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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
include __DIR__ . '/../../mainfile.php';

include_once XOOPS_ROOT_PATH.'/modules/AMS/class/class.newsstory.php';

$moduleHelper = Helper::getHelper(basename(__DIR__));

if (isset($_GET['storytopic'])) {
    $xoopsOption['storytopic'] = (int)$_GET['storytopic'];
} else {
    $xoopsOption['storytopic'] = 0;
}
if (isset($_GET['storynum'])) {
    $xoopsOption['storynum'] = (int)$_GET['storynum'];
    if ($xoopsOption['storynum'] > $xoopsModuleConfig['max_items']) {
        $xoopsOption['storynum'] = $xoopsModuleConfig['max_items'];
    }
} elseif ($xoopsOption['storytopic'] > 0) {
    $xoopsOption['storynum'] = $xoopsModuleConfig['storyhome_topic'];
} else {
    $xoopsOption['storynum'] = $xoopsModuleConfig['storyhome'];
}

if (isset($_GET['start'])) {
    $start = (int)$_GET['start'];
} else {
    $start = 0;
}
if (empty($xoopsModuleConfig['newsdisplay']) || 'Classic' === $xoopsModuleConfig['newsdisplay'] || $xoopsOption['storytopic'] > 0) {
    $showclassic = 1;
} else {
    $showclassic = 0;
}

$myts = MyTextSanitizer::getInstance();
$pagetitle = $myts->htmlSpecialChars($xoopsModule->name());
$column_count = $xoopsModuleConfig['columnmode'];
if ($showclassic) {
    $GLOBALS['xoopsOption']['template_main'] = 'ams_index.tpl';
} else {
    $GLOBALS['xoopsOption']['template_main'] = 'ams_by_topic.tpl';
}
include XOOPS_ROOT_PATH.'/header.php';
$xoopsTpl->assign('columnwidth', (int)(1 / $column_count * 100));
if (1 == $xoopsModuleConfig['displaynav']) {
    $xoopsTpl->assign('displaynav', true);
    $xt = new AmsTopic($xoopsDB->prefix('ams_topics'));
    $allTopics = $xt->getAllTopics(true);
    include_once XOOPS_ROOT_PATH . '/class/tree.php';
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $topic_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
    $topic_form = new XoopsThemeForm('', 'topic_form', 'index.php', 'get');
    $topic_form->addElement($topic_tree->makeSelectElement('storytopic', 'topic_title', '-', $xoopsOption['storytopic'], true));
    // Make number options
    $i = 1;
    while ($i <= $xoopsModuleConfig['max_items']) {
        $options[$i] = $i;
        if (1 == $i) {
            $i = 5;
        } else {
            $i += 5;
        }
    }
    $storynum_select = new XoopsFormSelect('', 'storynum', $xoopsOption['storynum']);
    $storynum_select->addOptionArray($options);

    $submit_btn = new XoopsFormButton('', 'submit', _GO, 'submit');

    $topic_form->addElement($storynum_select);
    $topic_form->addElement($submit_btn);
    $topic_form->assign($xoopsTpl);
} else {
    $xoopsTpl->assign('displaynav', false);
}
if ($showclassic) {
    $ihome = $xoopsOption['storytopic'] > 0 ? 1 : 0;

    $sortColumn = $moduleHelper->getConfig('index_sort_column', 'published');
    $sortOrder  = $moduleHelper->getConfig('index_sort_order', 'DESC');

    $sarray = AmsStory::getAllPublished($xoopsOption['storynum'], $start, $xoopsModuleConfig['restrictindex'], $xoopsOption['storytopic'], $ihome, true, $sortColumn, false, $sortOrder);
    $scount = count($sarray);
    $xoopsTpl->assign('story_count', $scount);
    if ($scount > 0) {
        $uids = array();
        foreach ($sarray as $storyid => $thisstory) {
            $uids[$thisstory->uid()] = $thisstory->uid();
        }
        $memberHandler = xoops_getHandler('member');
        $user_arr = $memberHandler->getUsers(new Criteria('uid', '(' . implode(',', array_keys($uids)) . ')', 'IN'), true);
        foreach ($sarray as $storyid => $thisstory) {
            $stories[] = $thisstory->toArray(false, false, 0, $user_arr);
        }
        $xoopsTpl->assign('stories', $stories);
    } else {
        $xoopsTpl->assign('stories', array());
    }
    $xoopsTpl->assign('columns', $column_count);

    $totalcount = AmsStory::countPublishedByTopic($xoopsOption['storytopic'], $xoopsModuleConfig['restrictindex']);
    if ($totalcount > $scount) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalcount, $xoopsOption['storynum'], $start, 'start', 'storytopic='.$xoopsOption['storytopic']);
        $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    } else {
        $xoopsTpl->assign('pagenav', '');
    }

    if ($xoopsOption['storytopic'] > 0) {
        if (!isset($xt)) {
            $xt = new AmsTopic($xoopsDB->prefix('ams_topics'));
        }
        $xt->getTopic($xoopsOption['storytopic']);
        $pagetitle .= ' - ' . $xt->topic_title();
        $xoopsTpl->assign('breadcrumb', $xt->getTopicPath(true));
    } else {
        $xoopsTpl->assign('breadcrumb', false);
    }
} else {
    include_once XOOPS_ROOT_PATH . '/class/tree.php';
    $xt = new AmsTopic($xoopsDB -> prefix('ams_topics'));
    $allTopics = $xt->getAllTopics($xoopsModuleConfig['restrictindex']);
    $topic_obj_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
    $alltopics = $topic_obj_tree->getFirstChild(0);

    $article_counts = AmsStory::countPublishedOrderedByTopic();

    $smarty_topics = array();
    foreach (array_keys($alltopics) as $i) {
        $allstories[$i] = AmsStory::getAllPublished($xoopsOption['storynum'], 0, false, $i, 0);
        if (count($allstories[$i]) > 0) {
            foreach ($allstories[$i] as $thisstory) {
                $uids[$thisstory->uid()] = $thisstory->uid();
            }
        }
        if (!isset($article_counts[$i])) {
            $article_counts[$i] = 0;
        }
    }
    if (count($uids) > 0) {
        $memberHandler = xoops_getHandler('member');
        $user_arr = $memberHandler->getUsers(new Criteria('uid', '(' . implode(',', array_keys($uids)) . ')', 'IN'), true);
        foreach ($alltopics as $topicid => $topic) {
            $topicstories = array();
            foreach ($allstories[$topicid] as $thisstory) {
                $topicstories[] = $thisstory->toArray(false, false, 0, $user_arr);
            }
            $subcount = 0;
            $subs = array();
            //$key = findKey($smarty_topics, $topicstories[0]['posttimestamp']);
            $subtopics = $topic_obj_tree->getFirstChild($topicid);
            $subcount = count($subtopics);
            foreach (array_keys($subtopics) as $i) {
                $subs[$i] = array('id' => $i, 'title' => $subtopics[$i]->topic_title(), 'imageurl' => $subtopics[$i]->topic_imgurl());
            }
            $smarty_topics[] = array('title'         => $topic->topic_title(),
                                     'stories'       => $topicstories,
                                     'id'            => $topicid,
                                     'subtopics'     => $subs,
                                     'articlecount'  => $article_counts[$topicid],
                                     'subtopiccount' => $subcount
            );
            unset($subs);
        }
    }
    //krsort($smarty_topics);
    $xoopsTpl->assign('topics', $smarty_topics);
    $xoopsTpl->assign('columns', $column_count);
    $xoopsTpl->assign('breadcrumb', false);
}
if (XOOPS_COMMENT_APPROVENONE != $xoopsModuleConfig['com_rule']) {
    $showcomments = 1;
} else {
    $showcomments = 0;
}
$xoopsTpl->assign('showcomments', $showcomments);
$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
$xoopsTpl->assign('lang_go', _GO);
$xoopsTpl->assign('lang_on', _ON);
$xoopsTpl->assign('lang_printerpage', _AMS_NW_PRINTERFRIENDLY);
$xoopsTpl->assign('lang_sendstory', _AMS_NW_SENDSTORY);
$xoopsTpl->assign('lang_postedby', _POSTEDBY);
$xoopsTpl->assign('lang_reads', _READS);
$xoopsTpl->assign('lang_morereleases', _AMS_NW_MORERELEASES);
$xoopsTpl->assign('lang_postnewarticle', _AMS_NW_POSTNEWARTICLE);
if ($xoopsOption['storytopic'] > 0) {
    $topic = new AmsTopic($xoopsDB->prefix('ams_topics'), $xoopsOption['storytopic']);
    $xoopsTpl->assign('topicbanner', $myts->displayTarea($topic->getBanner(), 1));
}
include_once XOOPS_ROOT_PATH.'/footer.php';


function findKey($array, $suggested_key)
{
    if (isset($array[$suggested_key])) {
        return findKey($array, $suggested_key +1);
    }
    return $suggested_key;
}
