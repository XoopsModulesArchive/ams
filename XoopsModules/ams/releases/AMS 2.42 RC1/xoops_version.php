<?php
// $Id$
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
//  Based on standard News module v1.2 with several changes by Mithrandir    //

$modversion['name'] = _AMS_MI_NEWS_NAME;
$modversion['version'] = 2.42;
$modversion['description'] = _AMS_MI_NEWS_DESC;
$modversion['author'] = "NovaSmart Technology, Jan Keller Pedersen (Mithrandir)<br>Dominic Ryan (Brashquido)<br>Jeffrey Tindillier (jctsup1)";
$modversion['credits'] = "The XOOPS Project<br><br>Herv� Thouzard for his work with the News 1.2 module on which AMS is based. Also to Feichtl and speedbit for contributing language files.<br><br>Also a very big thank you to all who donated to the AMS development costs. Without your financial support a public release of this module would not have been possible!";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "images/ams_slogo.png";
$modversion['dirname'] = "AMS";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
//$modversion['sqlfile']['postgresql'] = "sql/pgsql.sql";

$modversion['onUpdate'] = "include/update.php";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "ams_article";
$modversion['tables'][1] = "ams_topics";
$modversion['tables'][2] = "ams_files";
$modversion['tables'][3] = "ams_link";
$modversion['tables'][4] = "ams_text";
$modversion['tables'][5] = "ams_rating";
$modversion['tables'][6] = "ams_audience";
$modversion['tables'][7] = "ams_spotlight";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'ams_item.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'ams_archive.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'ams_article.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'ams_index.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'ams_by_topic.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'ams_ratearticle.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'ams_version.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'ams_searchform.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'ams_block_spotlight_center.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'ams_block_spotlight_left.html';
$modversion['templates'][10]['description'] = '';
$modversion['templates'][11]['file'] = 'ams_block_spotlight_right.html';
$modversion['templates'][11]['description'] = '';

// Blocks
$modversion['blocks'][1]['file'] = "ams_topics.php";
$modversion['blocks'][1]['name'] = _AMS_MI_NEWS_BNAME1;
$modversion['blocks'][1]['description'] = "Shows news topics";
$modversion['blocks'][1]['show_func'] = "b_ams_topics_show";
$modversion['blocks'][1]['template'] = 'ams_block_topics.html';

$modversion['blocks'][2]['file'] = "ams_bigstory.php";
$modversion['blocks'][2]['name'] = _AMS_MI_NEWS_BNAME3;
$modversion['blocks'][2]['description'] = "Shows most read story of the day";
$modversion['blocks'][2]['show_func'] = "b_ams_bigstory_show";
$modversion['blocks'][2]['template'] = 'ams_block_bigstory.html';

$modversion['blocks'][3]['file'] = "ams_top.php";
$modversion['blocks'][3]['name'] = _AMS_MI_NEWS_BNAME4;
$modversion['blocks'][3]['description'] = "Shows top read news articles";
$modversion['blocks'][3]['show_func'] = "b_ams_top_show";
$modversion['blocks'][3]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][3]['options'] = "counter|10|25|0";
$modversion['blocks'][3]['template'] = 'ams_block_top.html';

$modversion['blocks'][4]['file'] = "ams_top.php";
$modversion['blocks'][4]['name'] = _AMS_MI_NEWS_BNAME5;
$modversion['blocks'][4]['description'] = "Shows recent articles";
$modversion['blocks'][4]['show_func'] = "b_ams_top_show";
$modversion['blocks'][4]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][4]['options'] = "published|10|25|0";
$modversion['blocks'][4]['template'] = 'ams_block_top.html';

$modversion['blocks'][5]['file'] = "ams_moderate.php";
$modversion['blocks'][5]['name'] = _AMS_MI_NEWS_BNAME6;
$modversion['blocks'][5]['description'] = "Shows a block to moderate articles";
$modversion['blocks'][5]['show_func'] = "b_ams_topics_moderate";
$modversion['blocks'][5]['template'] = 'ams_block_moderate.html';

$modversion['blocks'][6]['file'] = "ams_topicsnav.php";
$modversion['blocks'][6]['name'] = _AMS_MI_NEWS_BNAME7;
$modversion['blocks'][6]['description'] = "Shows a block to navigate topics";
$modversion['blocks'][6]['show_func'] = "b_ams_topicsnav_show";
$modversion['blocks'][6]['edit_func'] = "b_ams_topicsnav_edit";
$modversion['blocks'][6]['options'] = 0;
$modversion['blocks'][6]['template'] = 'ams_block_topicnav.html';

$modversion['blocks'][7]['file'] = "ams_author.php";
$modversion['blocks'][7]['name'] = _AMS_MI_NEWS_BNAME8;
$modversion['blocks'][7]['description'] = "Shows top authors";
$modversion['blocks'][7]['show_func'] = "b_ams_author_show";
$modversion['blocks'][7]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][7]['options'] = "count|5|uname";
$modversion['blocks'][7]['template'] = 'ams_block_authors.html';

$modversion['blocks'][8]['file'] = "ams_author.php";
$modversion['blocks'][8]['name'] = _AMS_MI_NEWS_BNAME9;
$modversion['blocks'][8]['description'] = "Shows top authors";
$modversion['blocks'][8]['show_func'] = "b_ams_author_show";
$modversion['blocks'][8]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][8]['options'] = "read|5|uname";
$modversion['blocks'][8]['template'] = 'ams_block_authors.html';

$modversion['blocks'][9]['file'] = "ams_author.php";
$modversion['blocks'][9]['name'] = _AMS_MI_NEWS_BNAME10;
$modversion['blocks'][9]['description'] = "Shows top authors";
$modversion['blocks'][9]['show_func'] = "b_ams_author_show";
$modversion['blocks'][9]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][9]['options'] = "rating|5|uname";
$modversion['blocks'][9]['template'] = 'ams_block_authors.html';

$modversion['blocks'][10]['file'] = "ams_top.php";
$modversion['blocks'][10]['name'] = _AMS_MI_NEWS_BNAME11;
$modversion['blocks'][10]['description'] = "Shows top rated articles";
$modversion['blocks'][10]['show_func'] = "b_ams_top_show";
$modversion['blocks'][10]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][10]['options'] = "rating|10|25|0";
$modversion['blocks'][10]['template'] = 'ams_block_top.html';

$modversion['blocks'][11]['file'] = "ams_spotlight.php";
$modversion['blocks'][11]['name'] = _AMS_MI_NEWS_BNAME12;
$modversion['blocks'][11]['description'] = "Spotlight articles";
$modversion['blocks'][11]['show_func'] = "b_ams_spotlight_show";
$modversion['blocks'][11]['edit_func'] = "b_ams_spotlight_edit";
$modversion['blocks'][11]['options'] = "10|1|ams_block_spotlight_center.html";
$modversion['blocks'][11]['template'] = 'ams_block_spotlight.html';


// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _AMS_MI_NEWS_SMNAME2;
$modversion['sub'][1]['url'] = "archive.php";

global $xoopsModule;
if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsUser;
    if (is_object($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
    } else {
        $groups = XOOPS_GROUP_ANONYMOUS;
    }
    $gperm_handler =& xoops_gethandler('groupperm');
    if ($gperm_handler->checkRight("ams_submit", 0, $groups, $xoopsModule->getVar('mid'))) {
        $modversion['sub'][2]['name'] = _AMS_MI_NEWS_SMNAME1;
        $modversion['sub'][2]['url'] = "submit.php";
    }
}


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "ams_search";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'article.php';
$modversion['comments']['itemName'] = 'storyid';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'ams_com_approve';
$modversion['comments']['callback']['update'] = 'ams_com_update';

// Config Settings (only for modules that need config settings generated automatically)

// name of config option for accessing its specified value. i.e. $xoopsModuleConfig['storyhome']
$modversion['config'][1]['name'] = 'storyhome';

// title of this config option displayed in config settings form
$modversion['config'][1]['title'] = '_AMS_MI_STORYHOME';

// description of this config option displayed under title
$modversion['config'][1]['description'] = '_AMS_MI_STORYHOMEDSC';

// form element type used in config form for this option. can be one of either textbox, textarea, select, select_multi, yesno, group, group_multi
$modversion['config'][1]['formtype'] = 'select';

// value type of this config option. can be one of either int, text, float, array, or other
// form type of group_multi, select_multi must always be value type of array
$modversion['config'][1]['valuetype'] = 'int';

// the default value for this option
// ignore it if no default
// 'yesno' formtype must be either 0(no) or 1(yes)
$modversion['config'][1]['default'] = 5;

// options to be displayed in selection box
// required and valid for 'select' or 'select_multi' formtype option only
// language constants can be used for array key, otherwise use integer
$modversion['config'][1]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);

$modversion['config'][2]['name'] = 'storycountadmin';
$modversion['config'][2]['title'] = '_AMS_MI_STORYCOUNTADMIN';
$modversion['config'][2]['description'] = '_AMS_MI_STORYCOUNTADMIN_DESC';
$modversion['config'][2]['formtype'] = 'select';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 10;
$modversion['config'][2]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);

$modversion['config'][3]['name'] = "storyhome_topic";
$modversion['config'][3]['title'] = '_AMS_MI_STORYCOUNTTOPIC';
$modversion['config'][3]['description'] = '_AMS_MI_STORYCOUNTTOPIC_DESC';
$modversion['config'][3]['formtype'] = 'select';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 10;
$modversion['config'][3]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);

$modversion['config'][4]['name'] = 'max_items';
$modversion['config'][4]['title'] = '_AMS_MI_MAXITEMS';
$modversion['config'][4]['description'] = '_AMS_MI_MAXITEMDESC';
$modversion['config'][4]['formtype'] = 'text';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 30;

$modversion['config'][5]['name'] = 'spotlight_art_num';
$modversion['config'][5]['title'] = '_AMS_MI_SPOTLIGHT_ITEMS';
$modversion['config'][5]['description'] = '_AMS_MI_SPOTLIGHT_ITEMDESC';
$modversion['config'][5]['formtype'] = 'select';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = 20;
$modversion['config'][5]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50, '100' => 100, '500' => 500);

$modversion['config'][6]['name'] = 'displaynav';
$modversion['config'][6]['title'] = '_AMS_MI_DISPLAYNAV';
$modversion['config'][6]['description'] = '_AMS_MI_DISPLAYNAVDSC';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 1;

$modversion['config'][7]['name'] = 'autoapprove';
$modversion['config'][7]['title'] = '_AMS_MI_AUTOAPPROVE';
$modversion['config'][7]['description'] = '_AMS_MI_AUTOAPPROVEDSC';
$modversion['config'][7]['formtype'] = 'yesno';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 0;

$modversion['config'][8]['name'] = 'uploadgroups';
$modversion['config'][8]['title'] = '_AMS_MI_UPLOADGROUPS';
$modversion['config'][8]['description'] = '_AMS_MI_UPLOADGROUPS_DESC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 2;
$modversion['config'][8]['options'] = array('_AMS_MI_UPLOAD_GROUP1' => 1, '_AMS_MI_UPLOAD_GROUP2' => 2, '_AMS_MI_UPLOAD_GROUP3' => 3);

$modversion['config'][9]['name'] = 'maxuploadsize';
$modversion['config'][9]['title'] = '_AMS_MI_UPLOADFILESIZE';
$modversion['config'][9]['description'] = '_AMS_MI_UPLOADFILESIZE_DESC';
$modversion['config'][9]['formtype'] = 'texbox';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 1048576;

$modversion['config'][10]['name'] = 'editor';
$modversion['config'][10]['title'] = '_AMS_MI_EDITOR';
$modversion['config'][10]['description'] = '_AMS_MI_EDITOR_DESC';
$modversion['config'][10]['formtype'] = 'select';
$modversion['config'][10]['valuetype'] = 'text';
$modversion['config'][10]['default'] = 0;
$modversion['config'][10]['options'] = array('_AMS_MI_EDITOR_DEFAULT' => 'default', '_AMS_MI_EDITOR_KOIVI' => 'koivi');

$modversion['config'][11]['name'] = 'newsdisplay';
$modversion['config'][11]['title'] = '_AMS_MI_NEWSDISPLAY';
$modversion['config'][11]['description'] = '_AMS_MI_NEWSDISPLAYDESC';
$modversion['config'][11]['formtype'] = 'select';
$modversion['config'][11]['valuetype'] = 'text';
$modversion['config'][11]['default'] = "Classic";
$modversion['config'][11]['options'] = array('_AMS_MI_NEWSCLASSIC' => 'Classic',
                                            '_AMS_MI_NEWSBYTOPIC' => 'Bytopic');

// For Author's name
$modversion['config'][12]['name'] = 'displayname';
$modversion['config'][12]['title'] = '_AMS_MI_NAMEDISPLAY';
$modversion['config'][12]['description'] = '_AMS_MI_ADISPLAYNAMEDSC';
$modversion['config'][12]['formtype'] = 'select';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 1;
$modversion['config'][12]['options']	= array('_AMS_MI_DISPLAYNAME1' => 1, '_AMS_MI_DISPLAYNAME2' => 2, '_AMS_MI_DISPLAYNAME3' => 3);

$modversion['config'][13]['name'] = 'columnmode';
$modversion['config'][13]['title'] = '_AMS_MI_COLUMNMODE';
$modversion['config'][13]['description'] = '_AMS_MI_COLUMNMODE_DESC';
$modversion['config'][13]['formtype'] = 'select';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 1;
$modversion['config'][13]['options'] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);

$modversion['config'][14]['name'] = 'restrictindex';
$modversion['config'][14]['title'] = '_AMS_MI_RESTRICTINDEX';
$modversion['config'][14]['description'] = '_AMS_MI_RESTRICTINDEXDSC';
$modversion['config'][14]['formtype'] = 'yesno';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 0;

$modversion['config'][15]['name'] = 'anonymous_vote';
$modversion['config'][15]['title'] = '_AMS_MI_ANONYMOUS_VOTE';
$modversion['config'][15]['description'] = '_AMS_MI_ANONYMOUS_VOTE_DESC';
$modversion['config'][15]['formtype'] = 'yesno';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 0;

$modversion['config'][16]['name'] = 'index_name';
$modversion['config'][16]['title'] = '_AMS_MI_INDEX_NAME';
$modversion['config'][16]['description'] = '_AMS_MI_INDEX_DESC';
$modversion['config'][16]['formtype'] = 'textbox';
$modversion['config'][16]['valuetype'] = 'text';
$modversion['config'][16]['default'] = "Index";

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'ams_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _AMS_MI_NEWS_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _AMS_MI_NEWS_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'article.php');

$modversion['notification']['category'][2]['name'] = 'story';
$modversion['notification']['category'][2]['title'] = _AMS_MI_NEWS_STORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _AMS_MI_NEWS_STORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('article.php');
$modversion['notification']['category'][2]['item_name'] = 'storyid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'story_submit';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_storysubmit_notify';
$modversion['notification']['event'][2]['mail_subject'] = _AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_story';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newstory_notify';
$modversion['notification']['event'][3]['mail_subject'] = _AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'approve';
$modversion['notification']['event'][4]['category'] = 'story';
$modversion['notification']['event'][4]['invisible'] = 1;
$modversion['notification']['event'][4]['title'] = _AMS_MI_NEWS_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _AMS_MI_NEWS_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _AMS_MI_NEWS_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][4]['mail_subject'] = _AMS_MI_NEWS_STORY_APPROVE_NOTIFYSBJ;
?>