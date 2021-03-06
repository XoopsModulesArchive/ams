<?php
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                                    //
// Copyright (c) 2000 XOOPS.org                                             //
// <http://www.xoops.org/>                                                  //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //

use Xmf\Request;

require __DIR__ . '/admin_header.php';

include_once XOOPS_ROOT_PATH . '/modules/AMS/class/class.newsstory.php';
include_once XOOPS_ROOT_PATH . '/modules/AMS/class/class.newstopic.php';
include_once XOOPS_ROOT_PATH . '/modules/AMS/class/class.sfiles.php';
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . '/modules/AMS/include/functions.inc.php';

//if (isset($_POST)) {
//    foreach ($_POST as $k => $v) {
//        ${$k} = $v;
//    }
//}

$op = Request::getString('op', 'default');
$storyid = Request::getInt('storyid', 0);

/*
* Show new submissions
*/
function newSubmissions()
{
    $storyarray = AmsStory :: getAllSubmitted();
    if (count($storyarray) > 0) {
        echo '<table width="100%" border="0" cellspacing="1" class="outer">';
        echo '<tr><th colspan="4">' . _AMS_AM_NEWSUB . '</th></tr>';
        echo '<tr><th>' . _AMS_AM_TITLE . '</th><th>' . _AMS_AM_POSTED . '</th><th>' . _AMS_AM_POSTER . '</th><th>' . _AMS_AM_ACTION . '</th></tr>';
        foreach ($storyarray as $newstory) {
            $uids[] = $newstory->uid();
        }
        $memberHandler = xoops_getHandler('member');
        $users = $memberHandler->getUsers(new Criteria('uid', '(' . implode(',', array_keys($uids)) . ')', 'IN'), true);
        $i = 0;
        foreach ($storyarray as $newstory) {
            $newstory -> uname($users);
            echo '<tr class="' . ((++$i % 2) ? 'even' : 'odd') . '"><td>';
            $title = $newstory->title();
            if (!isset($title) || ('' == $title)) {
                echo '<a href="articles.php?op=edit&amp;storyid=' . $newstory -> storyid() . '">' . _AMS_AM_NOSUBJECT . '</a>';
            } else {
                echo '&nbsp;<a href="../submit.php?op=edit&amp;storyid=' . $newstory -> storyid() . '">' . $title . "</a>\n";
            }
            echo '</td><td align="center">' . formatTimestamp($newstory -> created(), 's') . '</td>'
                . '<td align="center"><a href="' . XOOPS_URL . '/userinfo.php?uid=' . $newstory -> uid() . '">' . $newstory -> uname . '</a></td>'
                . '<td align="right"><a href="articles.php?op=delete&amp;storyid=' . $newstory -> storyid() . '">' . _AMS_AM_DELETE . '</a></td></tr>';
        }
        echo '</td></tr></table>';
        echo '<br />';
    }
}

/*
* Shows last x published stories
*/
function lastStories()
{
    global $xoopsModule, $xoopsModuleConfig;
    $start = Request::getInt('start', 0, 'GET');

    $title = Request::getString('title', '');
    $topicid = Request::getInt('topicid', 0);
    $status = Request::getString('status', 'none');
    $author = Request::getArray('author', array());

    $criteria = new CriteriaCompo();
    $querystring = 'op=newarticle';
    if (isset($title) && '' != $title) {
        $criteria->add(new Criteria('n.title', '%' . $title . '%', 'LIKE'));
        $querystring .= '&amp;title=' . $title;
    }
    if (isset($author) && is_array($author) && 0 != count($author)) {
        $criteria->add(new Criteria('t.uid', '(' . implode($author) . ')', 'IN'));
        foreach ($author as $uid) {
            $querystring .= '&amp;author[]=' . $uid;
        }
    }

    if (isset($status) && 'none' !== $status) {
        if ('published' === $status) {
            $status_crit = new CriteriaCompo(new Criteria('n.published', 0, '>'));
            $status_crit->add(new Criteria('n.published', time(), '<='));
            $status_exp= new CriteriaCompo(new Criteria('n.expired', 0));
            $status_exp->add(new Criteria('n.expired', time(), '>='), 'OR');
            $status_crit->add($status_exp);
            $criteria->add($status_crit);
        } elseif ('expired' === $status) {
            $criteria->add(new Criteria('n.expired', 0, '!='));
            $criteria->add(new Criteria('n.expired', time(), '<'));
        }
    }

    if (isset($topicid) && 0 != $topicid) {
        $criteria->add(new Criteria('n.topicid', $topicid));
    }

    $order = isset($_POST['order']) ? $_POST['order'] : (isset($_GET['order']) ? $_GET['order'] : 'DESC');
    $revOrder = 'DESC' === $order ? 'ASC' : 'DESC';
    $criteria->setOrder($order);

    $sort = Request::getString('sort', 'n.published');
    $validSorts = array(
        'n.storyid',
        'n.title',
        'n.published',
        'n.counter',
        'n.rating',
        'n.comments',
    );
    if (!in_array($sort, $validSorts, true)) {
        $sort = 'n.published';
    }

    $criteria->setSort($sort);
    $revString = $querystring . '&amp;sort=' . $sort . '&amp;order=' . $revOrder;
    $querystring .= '&amp;order=' . $order;

    require __DIR__ . '/filterform.php';
    $fform->display();

    echo '<table width="100%" border="0" cellspacing="1" class="outer">';
    echo '<tr><th colspan="11">' . _AMS_AM_PUBLISHEDARTICLES . '</th></tr>';

    echo '<tr><th><a href="?'. $querystring . '&amp;sort=n.storyid">' . _AMS_AM_STORYID . '</a></th>'
        . '<th><a href="?'.$querystring.'&amp;sort=n.title">' . _AMS_AM_TITLE . '</a></th>'
        . '<th>' . _AMS_AM_VERSION . '</th>'
        . '<th>' . _AMS_AM_TOPIC . '</th>'
        . '<th>' . _AMS_AM_POSTER . '</th>'
        . '<th><a href="?'.$querystring.'&amp;sort=n.published">' . _AMS_AM_PUBLISHED . '</a></th>'
        . '<th>'._AMS_AM_VERSIONCOUNT.'</th>'
        . '<th><a href="?'.$querystring.'&amp;sort=n.counter">' . _AMS_AM_HITS . '</a></th>'
        . '<th><a href="?'.$querystring.'&amp;sort=n.rating">' . _AMS_AM_RATING . '</a></th>'
        . '<th><a href="?'.$querystring.'&amp;sort=n.comments">' . _AMS_AM_COMMENTS . '</a></th>'
        . '<th>' . _AMS_AM_ACTION . '</th></tr>';

    $storyarray = AmsStory :: getAllNews($xoopsModuleConfig['storycountadmin'], $start, $criteria);
    $storyids = array_keys($storyarray);
    $versioncount_arr = AmsStory::getVersionCounts($storyids);
    foreach ($storyarray as $eachstory) {
        $uids[] = $eachstory->uid();
    }
    if (!empty($uids)) {
        $memberHandler = xoops_getHandler('member');
        $users = $memberHandler->getUsers(new Criteria('uid', '(' . implode(',', array_keys($uids)) . ')', 'IN'), true);
        $i = 0;
        foreach ($storyarray as $storyid => $eachstory) {
            $eachstory -> uname($users);
            $published = formatTimestamp($eachstory -> published(), 's');
            //$expired = ( $eachstory -> expired() > 0 ) ? formatTimestamp( $eachstory -> expired(), 's' ) : '---';
            //$topic = $eachstory->topic();
            echo '<tr class="' . ((++$i % 2) ? 'even' : 'odd') . '"><td align="center">' . $storyid . '</b></td>'
                . '<td><a href="' . XOOPS_URL . '/modules/' . $xoopsModule -> dirname() . '/article.php?storyid=' . $eachstory->storyid() . '">' . $eachstory -> title() . '</a></td>'
                . '<td>'.$eachstory->version().'</td>'
                . '<td align="center">' . $eachstory->topic(true)->topic_title() . '</td>'
                . '<td align="center"><a href="' . XOOPS_URL . '/userinfo.php?uid=' . $eachstory->uid() . '">' . $eachstory->uname . '</a></td>'
                . '<td align="center">' . $published . '</td>'
                . '<td align="center">' . $versioncount_arr[$eachstory->storyid()].'</td>'
                . '<td align="center">' . $eachstory->counter() . '</td>'
                . '<td align="center">' . $eachstory->rating . '</td>'
                . '<td align="center">' . $eachstory->comments() . '</td>'
                . '<td align="center"><a href="../submit.php?op=edit&amp;storyid=' . $eachstory->storyid() . '">' . _AMS_AM_EDIT . '</a>'
                . ' - <a href="articles.php?op=delete&amp;storyid=' . $eachstory->storyid() . '">' . _AMS_AM_DELETE . '</a></td>'
                . '</tr>';
        }
    }
    echo '</table><br />';
    $totalPublished = AmsStory::countPublishedByTopic();
    if ($totalPublished > $xoopsModuleConfig['storycountadmin']) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalPublished, $xoopsModuleConfig['storycountadmin'], $start, 'start', $querystring);
        echo $pagenav->renderNav();
    }
}

/*
* Display a list of all the existing topics and enable the user to add or modify an existing topic
*/
function topicsmanager()
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsDB;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    //$uploadfolder=sprintf(_AMS_AM_UPLOAD_WARNING,XOOPS_URL . "/modules/" . $xoopsModule -> dirname().'/assets/images/topics');
    $uploadirectory= '/modules/' . $xoopsModule-> dirname() . '/assets/images/topics';
    $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;

    include_once XOOPS_ROOT_PATH . '/class/tree.php';
    $xt = new AmsTopic($xoopsDB -> prefix('ams_topics'));
    $allTopics = $xt->getAllTopics();
    $totaltopics = count($allTopics);
    if ($totaltopics > 0) {
        $topic_obj_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
        $topics_arr = $topic_obj_tree->getAllChild(0);
    }
    echo "<form action='articles.php' method='POST'>";
    echo '<table width="100%" border="0" cellspacing="1" class="outer">';
    echo '<tr><th colspan="5">' . _AMS_AM_TOPICSMNGR . ' (' . ($start +1) .'-'
        . (($start + $xoopsModuleConfig['storycountadmin']) > $totaltopics ? $totaltopics : $start + $xoopsModuleConfig['storycountadmin'])
        . ' '._AMS_AM_OF.' '. $totaltopics . ')' .'</th></tr>';
    echo '<tr><th>' . _AMS_AM_TOPIC . '</th><th>' . _AMS_AM_TOPICNAME . '</th><th>' . _AMS_AM_PARENTTOPIC . '</th>'
        . '<th>' . _AMS_AM_WEIGHT . '</th><th>' . _AMS_AM_ACTION . '</th></tr>';

    //If topic not empty
    if ($totaltopics > 0) {
        $i = 0;
        foreach ($topics_arr as $thisTopic) {
            $i++;
            if ($i > $start && $i - $start <= $xoopsModuleConfig['storycountadmin']) {
                $linkedit = XOOPS_URL . '/modules/'.$xoopsModule->dirname() . '/admin/articles.php?op=topicsmanager&amp;topic_id=' . $thisTopic->topic_id();
                $linkdelete = XOOPS_URL . '/modules/'.$xoopsModule->dirname() . '/admin/articles.php?op=delTopic&amp;topic_id=' . $thisTopic->topic_id();
                $action=sprintf("<a href='%s'>%s</a> - <a href='%s'>%s</a>", $linkedit, _AMS_AM_EDIT, $linkdelete, _AMS_AM_DELETE);
                $parent='&nbsp;';
                $pid = $thisTopic->topic_pid();
                if ($pid  > 0) {
                    $parent = $topics_arr[$pid]->topic_title();
                    $thisTopic->prefix = str_replace('.', '-', $thisTopic->prefix) . '&nbsp;&nbsp;';
                } else {
                    $thisTopic->prefix = str_replace('.', '', $thisTopic->prefix);
                }
                echo '<tr class="' . (($i % 2) ? 'even' : 'odd') . '"><td>' . $thisTopic->topic_id() . '</td>'
                    . '<td align="left">' . $thisTopic->prefix() . $thisTopic->topic_title() . '</td>'
                    . '<td align="left">' . $parent . '</td>'
                    . '<td align="center"><input type="text" name="weight['.$thisTopic->topic_id().']" value="'.$thisTopic->weight.'" size="10" maxlength="10" /></td>'
                    . '<td>' . $action . '</td></tr>';
            }
        }
        echo "<tr><td colspan='3'></td><td><input type='hidden' name='op' value='reorder' />
                <input type='submit' name='submit' value='"._AMS_AM_SUBMIT."' /></td><td></td></tr>";
    }

    echo '</table></div></div></form>';
    if ($totaltopics > $xoopsModuleConfig['storycountadmin']) {
        $pagenav = new XoopsPageNav($totaltopics, $xoopsModuleConfig['storycountadmin'], $start, 'start', 'op=topicsmanager');
        echo "<div align='right'>";
        echo $pagenav->renderNav().'</div><br />';
    }

    $topic_id = isset($_GET['topic_id']) ? (int)$_GET['topic_id'] : 0;
    if ($topic_id>0) {
        $xtmod = $topics_arr[$topic_id];
        $topic_title=$xtmod->topic_title('E');
        $op='modTopicS';
        if ('' != trim($xtmod->topic_imgurl())) {
            $topicimage=$xtmod->topic_imgurl();
        } else {
            $topicimage= 'blank.png';
        }
        $btnlabel=_AMS_AM_MODIFY;
        $parent=$xtmod->topic_pid();
        $formlabel=_AMS_AM_MODIFYTOPIC;
        $banner = $xtmod->banner;
        $banner_inherit = $xtmod->banner_inherit;
        $forum = $xtmod->forum_id;
        unset($xtmod);
    } else {
        $topic_title='';
        $op='addTopic';
        $topicimage='xoops.gif';
        $btnlabel=_AMS_AM_ADD;
        $parent=0;
        $formlabel=_AMS_AM_ADD_TOPIC;
        $banner = '';
        $banner_inherit = 0;
        $forum = 0;
    }

    $sform = new XoopsThemeForm($formlabel, 'topicform', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/articles.php', 'post');
    $sform->setExtra('enctype="multipart/form-data"');
    $sform->addElement(new XoopsFormText(_AMS_AM_TOPICNAME . ' ' . _AMS_AM_MAX40CHAR, 'topic_title', 40, 50, $topic_title), true);
    $sform->addElement(new XoopsFormHidden('op', $op), false);
    $sform->addElement(new XoopsFormHidden('topic_id', $topic_id), false);

    if ($totaltopics > 0) {
        $sform->addElement($topic_obj_tree->makeSelectElement('topic_pid', 'topic_title', '--', $parent, true, 0, '', _AMS_AM_PARENTTOPIC));
    } else {
        $sform->addElement(new XoopsFormHidden('topic_pid', 0));
    }
    // ********** Picture
    $imgtray = new XoopsFormElementTray(_AMS_AM_TOPICIMG, '<br />');

    $imgpath=sprintf(_AMS_AM_IMGNAEXLOC, 'modules/' . $xoopsModule-> dirname() . '/assets/images/topics/');
    $imageselect= new XoopsFormSelect($imgpath, 'topic_imgurl', $topicimage);
    $topics_array = XoopsLists :: getImgListAsArray(XOOPS_ROOT_PATH . '/modules/AMS/assets/images/topics/');
    foreach ($topics_array as $image) {
        $imageselect->addOption("$image", $image);
    }
    $imageselect->setExtra("onchange='showImgSelected(\"image3\", \"topic_imgurl\", \"" . $uploadirectory . '", "", "' . XOOPS_URL . "\")'");
    $imgtray->addElement($imageselect, false);
    $imgtray -> addElement(new XoopsFormLabel('', "<br /><img src='" . XOOPS_URL . '/'
                                                  . $uploadirectory . '/'
                                                  . $topicimage . "' name='image3' id='image3' alt='' />"));


    $uploadfolder=sprintf(_AMS_AM_UPLOAD_WARNING, XOOPS_URL . '/modules/' . $xoopsModule-> dirname() . '/assets/images/topics');
    $fileseltray= new XoopsFormElementTray('', '<br />');
    $fileseltray->addElement(new XoopsFormFile(_AMS_AM_TOPIC_PICTURE, 'attachedfile', $xoopsModuleConfig['maxuploadsize']), false);
    $fileseltray->addElement(new XoopsFormLabel($uploadfolder), false);
    $imgtray->addElement($fileseltray);
    $sform->addElement($imgtray);

    //Forum linking
    $moduleHandler = xoops_getHandler('module');
    $forum_module = $moduleHandler->getByDirname('newbb');
    if (is_object($forum_module) && $forum_module->getVar('version') >= 200) {
        $forumHandler = xoops_getModuleHandler('forum', 'newbb', true);
        if (is_object($forumHandler)) {
            $forums = $forumHandler->getForums();
            if (count($forums) > 0) {
                $forum_tree = new XoopsObjectTree($forums, 'forum_id', 'parent_forum');
                $sform->addElement($forum_tree->makeSelectElement('forum_id', 'forum_name', '--', $forum, true, 0, '', _AMS_AM_LINKEDFORUM));
            }
        }
    }


    //Banner
    $sform->addElement(new XoopsFormDhtmlTextArea(_AMS_AM_TOPICBANNER, 'banner', $banner));
    $inherit_checkbox = new XoopsFormCheckBox(_AMS_AM_BANNERINHERIT, 'banner_inherit', $banner_inherit);
    $inherit_checkbox->addOption(1, _YES);
    $sform->addElement($inherit_checkbox);

    //Added in AMS 2.50 Final. Use News 1.62 permission style
    //Enhance in AMS 3.0 Beta 1. Add default permission for approval=admin, submit=admin,User.
    // Permissions
    $memberHandler = xoops_getHandler('member');
    $group_list = $memberHandler->getGroupList();
    $gpermHandler = xoops_getHandler('groupperm');
    $group_type_ref = $memberHandler->getGroups(null, true);

    $admin_list = array();
    $user_list = array();
    $full_list = array();
    $admincount=1;
    $usercount=1;
    $fullcount=1;
    foreach (array_keys($group_type_ref) as $i) {
        if ('Admin' === $group_type_ref[$i]->getVar('group_type')) {
            $admin_list[$i]=$group_list[$i];
            $admincount++;
            $user_list[$i]=$group_list[$i];
            $usercount++;
        }
        if ('User' === $group_type_ref[$i]->getVar('group_type')) {
            $user_list[$i]=$group_list[$i];
            $usercount++;
        }

        $full_list[$i]=$group_list[$i];
        $fullcount++;
    }

    $admin_list=array_keys($admin_list);
    $user_list=array_keys($user_list);
    $full_list = array_keys($full_list);

    $groups_ids = array();
    if ($topic_id > 0) {        // Edit mode
        $groups_ids = $gpermHandler->getGroupIds('ams_approve', $topic_id, $xoopsModule->getVar('mid'));
        $groups_ids = array_values($groups_ids);
        $groups_AMS_can_approve_checkbox = new XoopsFormCheckBox(_AMS_AM_APPROVEFORM, 'groups_AMS_can_approve[]', $groups_ids);
    } else {    // Creation mode
        $groups_AMS_can_approve_checkbox = new XoopsFormCheckBox(_AMS_AM_APPROVEFORM, 'groups_AMS_can_approve[]', $admin_list);
    }
    $groups_AMS_can_approve_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_AMS_can_approve_checkbox);

    $groups_ids = array();
    if ($topic_id > 0) {        // Edit mode
        $groups_ids = $gpermHandler->getGroupIds('ams_submit', $topic_id, $xoopsModule->getVar('mid'));
        $groups_ids = array_values($groups_ids);
        $groups_AMS_can_submit_checkbox = new XoopsFormCheckBox(_AMS_AM_SUBMITFORM, 'groups_AMS_can_submit[]', $groups_ids);
    } else {    // Creation mode
        $groups_AMS_can_submit_checkbox = new XoopsFormCheckBox(_AMS_AM_SUBMITFORM, 'groups_AMS_can_submit[]', $user_list);
    }
    $groups_AMS_can_submit_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_AMS_can_submit_checkbox);

    $groups_ids = array();
    if ($topic_id > 0) {        // Edit mode
        $groups_ids = $gpermHandler->getGroupIds('ams_view', $topic_id, $xoopsModule->getVar('mid'));
        $groups_ids = array_values($groups_ids);
        $groups_AMS_can_view_checkbox = new XoopsFormCheckBox(_AMS_AM_VIEWFORM, 'groups_AMS_can_view[]', $groups_ids);
    } else {    // Creation mode
        $groups_AMS_can_view_checkbox = new XoopsFormCheckBox(_AMS_AM_VIEWFORM, 'groups_AMS_can_view[]', $full_list);
    }
    $groups_AMS_can_view_checkbox->addOptionArray($group_list);
    $sform->addElement($groups_AMS_can_view_checkbox);

    // Submit buttons
    $button_tray = new XoopsFormElementTray('', '');
    $submit_btn = new XoopsFormButton('', 'post', $btnlabel, 'submit');
    $button_tray->addElement($submit_btn);
    $sform->addElement($button_tray);
    $sform->display();
}

/*
* Save a topic after it has been modified
*/
function modTopicS()
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $xt = new AmsTopic($xoopsDB -> prefix('ams_topics'), $_POST['topic_id']);
    if ($_POST['topic_pid'] == $_POST['topic_id']) {
        redirect_header('articles.php?op=topicsmanager', 2, _AMS_AM_ADD_TOPIC_ERROR1);
    }
    $xt -> setTopicPid($_POST['topic_pid']);
    if (empty($_POST['topic_title'])) {
        redirect_header('articles.php?op=topicsmanager', 2, _AMS_AM_ERRORTOPICNAME);
    }
    $xt -> setTopicTitle($_POST['topic_title']);
    if (isset($_POST['topic_imgurl']) && '' != $_POST['topic_imgurl']) {
        $xt -> setTopicImgurl($_POST['topic_imgurl']);
    }

    $xt->banner_inherit = isset($_POST['banner_inherit']) ? 1 : 0;
    $xt->banner = $_POST['banner'];
    $xt->forum_id = isset($_POST['forum_id']) ? (int)$_POST['forum_id'] : 0;

    if (isset($_POST['xoops_upload_file'])) {
        $fldname = $_FILES[$_POST['xoops_upload_file'][0]];
        $fldname = get_magic_quotes_gpc() ? stripslashes($fldname['name']) : $fldname['name'];
        if (trim('' != $fldname)) {
            $sfiles = new sFiles();
            $dstpath = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule-> dirname() . '/assets/images/topics';
            $destname=$sfiles->createUploadName($dstpath, $fldname, true);
            $permittedtypes=array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
            $uploader = new XoopsMediaUploader($dstpath, $permittedtypes, $xoopsModuleConfig['maxuploadsize']);
            $uploader->setTargetFileName($destname);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                if ($uploader->upload()) {
                    $xt->setTopicImgurl(basename($destname));
                } else {
                    echo _AMS_AM_UPLOAD_ERROR;
                }
            } else {
                echo $uploader->getErrors();
            }
        }
    }

    $xt -> store();

    //Added in AMS 2.50 Final. Use News 1.62 permission style
    // Permissions
    $gpermHandler = xoops_getHandler('groupperm');
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
    $criteria->add(new Criteria('gperm_name', 'ams_approve', '='));
    $gpermHandler->deleteAll($criteria);

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
    $criteria->add(new Criteria('gperm_name', 'ams_submit', '='));
    $gpermHandler->deleteAll($criteria);

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('gperm_itemid', $xt->topic_id(), '='));
    $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
    $criteria->add(new Criteria('gperm_name', 'ams_view', '='));
    $gpermHandler->deleteAll($criteria);

    if (isset($_POST['groups_AMS_can_approve'])) {
        foreach ($_POST['groups_AMS_can_approve'] as $onegroup_id) {
            $gpermHandler->addRight('ams_approve', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    if (isset($_POST['groups_AMS_can_submit'])) {
        foreach ($_POST['groups_AMS_can_submit'] as $onegroup_id) {
            $gpermHandler->addRight('ams_submit', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    if (isset($_POST['groups_AMS_can_view'])) {
        foreach ($_POST['groups_AMS_can_view'] as $onegroup_id) {
            $gpermHandler->addRight('ams_view', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
        }
    }

    AMS_updateCache();

    redirect_header('articles.php?op=topicsmanager', 1, _AMS_AM_DBUPDATED);
    exit();
}

function delTopic()
{
    if (!isset($_REQUEST['topic_id']) || 0 == $_REQUEST['topic_id']) {
        redirect_header('articles.php?op=topicsmanager', 3, _AMS_AM_NOTOPICSELECTED);
    }
    global $xoopsDB, $xoopsModule;
    if (!isset($_POST['ok'])) {
        echo '<h4>' . _AMS_AM_CONFIG . '</h4>';
        $xt = new XoopsTopic($xoopsDB -> prefix('ams_topics'), (int)$_GET['topic_id']);
        xoops_confirm(array('op' => 'delTopic', 'topic_id' => (int)$_GET['topic_id'], 'ok' => 1 ), 'articles.php', _AMS_AM_WAYSYWTDTTAL . '<br />' . $xt->topic_title('S'));
    } else {
        $xt = new XoopsTopic($xoopsDB -> prefix('ams_topics'), (int)$_POST['topic_id']);
        // get all subtopics under the specified topic
        $topic_arr = $xt -> getAllChildTopics();
        array_push($topic_arr, $xt);
        foreach ($topic_arr as $eachtopic) {
            // get all stories in each topic
            $story_arr = AmsStory :: getByTopic($eachtopic -> topic_id());
            foreach ($story_arr as $eachstory) {
                if (false !== $eachstory->delete()) {
                    xoops_comment_delete($xoopsModule -> getVar('mid'), $eachstory -> storyid());
                    xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'story', $eachstory->storyid());
                }
            }
            // all stories for each topic is deleted, now delete the topic data
            $eachtopic -> delete();
            // Delete also the notifications and permissions
            xoops_notification_deletebyitem($xoopsModule -> getVar('mid'), 'category', $eachtopic -> topic_id);
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'ams_approve', $eachtopic -> topic_id);
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'ams_submit', $eachtopic -> topic_id);
            xoops_groupperm_deletebymoditem($xoopsModule->getVar('mid'), 'ams_view', $eachtopic -> topic_id);
        }
        redirect_header('articles.php?op=topicsmanager', 1, _AMS_AM_DBUPDATED);
        exit();
    }
}

function addTopic()
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $topicpid = isset($_POST['topic_pid']) ? (int)$_POST['topic_pid'] : 0;
    $xt = new AmsTopic($xoopsDB -> prefix('ams_topics'));
    if (!$xt -> topicExists($topicpid, $_POST['topic_title'])) {
        $xt -> setTopicPid($topicpid);
        if (empty($_POST['topic_title']) || '' == trim($_POST['topic_title'])) {
            redirect_header('articles.php?op=topicsmanager', 2, _AMS_AM_ERRORTOPICNAME);
        }
        $xt -> setTopicTitle($_POST['topic_title']);
        if (isset($_POST['topic_imgurl']) && '' != $_POST['topic_imgurl']) {
            $xt -> setTopicImgurl($_POST['topic_imgurl']);
        }

        if (isset($_POST['xoops_upload_file'])) {
            $fldname = $_FILES[$_POST['xoops_upload_file'][0]];
            $fldname = get_magic_quotes_gpc() ? stripslashes($fldname['name']) : $fldname['name'];
            if (trim('' != $fldname)) {
                $sfiles = new sFiles();
                $dstpath = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule-> dirname() . '/assets/images/topics';
                $destname=$sfiles->createUploadName($dstpath, $fldname, true);
                $permittedtypes=array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
                $uploader = new XoopsMediaUploader($dstpath, $permittedtypes, $xoopsModuleConfig['maxuploadsize']);
                $uploader->setTargetFileName($destname);
                if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                    if ($uploader->upload()) {
                        $xt->setTopicImgurl(basename($destname));
                    } else {
                        echo _AMS_AM_UPLOAD_ERROR;
                    }
                } else {
                    echo $uploader->getErrors();
                }
            }
        }

        $xt->banner_inherit = isset($_POST['banner_inherit']) ? 1 : 0;
        $xt->banner = $_POST['banner'];
        $xt->forum_id = isset($_POST['forum_id']) ? (int)$_POST['forum_id'] : 0;
        if ($xt -> store()) {
            //This will set default audience
            global $xoopsModule;
            $allTopics = $xt->getAllTopics();
            $totaltopics = count($allTopics);
            if ($totaltopics=1) {
                //Make sure xoopsModule is AMS.
                if (!isset($xoopsModule) || 'AMS' !== $xoopsModule->getVar('dirname')) {
                    $moduleHandler = xoops_getHandler('module');
                    $amsModule = $moduleHandler->getByDirname('AMS');
                } else {
                    $amsModule = $xoopsModule;
                }

                // Check audience, and set default value if not yet exist
                if (!ams_isaudiencesetup($amsModule->getVar('mid'))) {
                    $gpermHandler = xoops_getHandler('groupperm');
                    $memberHandler = xoops_getHandler('member');
                    $group_id_ref = $memberHandler->getGroups(null, true);
                    //insert all groups into default audience
                    foreach (array_keys($group_id_ref) as $i) {
                        $gpermHandler->addRight('ams_audience', 1, (int)$group_id_ref[$i]->getVar('groupid'), (int)$amsModule->getVar('mid'));
                    }
                }
            }

            //Added in AMS 2.50 Final. Use News 1.62 permission style
            // Permissions
            $gpermHandler = xoops_getHandler('groupperm');
            if (isset($_POST['groups_AMS_can_approve'])) {
                foreach ($_POST['groups_AMS_can_approve'] as $onegroup_id) {
                    $gpermHandler->addRight('ams_approve', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }

            if (isset($_POST['groups_AMS_can_submit'])) {
                foreach ($_POST['groups_AMS_can_submit'] as $onegroup_id) {
                    $gpermHandler->addRight('ams_submit', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }

            if (isset($_POST['groups_AMS_can_view'])) {
                foreach ($_POST['groups_AMS_can_view'] as $onegroup_id) {
                    $gpermHandler->addRight('ams_view', $xt->topic_id(), $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }
            AMS_updateCache();

            $notificationHandler = xoops_getHandler('notification');
            $tags = array();
            $tags['TOPIC_NAME'] = $_POST['topic_title'];
            $notificationHandler -> triggerEvent('global', 0, 'new_category', $tags);
            redirect_header('articles.php?op=topicsmanager', 1, _AMS_AM_DBUPDATED);
            exit();
        }
    } else {
        redirect_header('articles.php?op=topicsmanager', 2, _AMS_AM_ADD_TOPIC_ERROR);
        exit();
    }
}

function listAudience()
{
    $audienceHandler = xoops_getModuleHandler('audience', 'AMS');
    $all_audiences = $audienceHandler->getAllAudiences();
    $output = '';
    if (is_array($all_audiences) && count($all_audiences) > 0) {
        $output = '<table>';
        foreach ($all_audiences as $audid => $audience) {
            $output .= "<tr><td class='odd'>".$audid."</td>
            <td class='even'><a href='?op=audience&amp;audid=".$audid."'>".$audience->getVar('audience')."</a></td>
            <td class='even'>";
            if (1 != $audid) {
                $output .= "<a href='?op=delaudience&amp;audienceid=".$audid."'>"._AMS_AM_DELETE . '</a>';
            }
            $output .= '</td>
            </tr>';
        }
        $output .= '</table>';
    }
    return $output;
}

function audienceForm($id = 0)
{
    $id = (int)$id;
    if ($id > 0) {
        global $xoopsModule;
        $audienceHandler = xoops_getModuleHandler('audience', 'AMS');
        $thisaudience = $audienceHandler->get($id);
        $audience = $thisaudience->getVar('audience');
        $gpermHandler = xoops_getHandler('groupperm');
        $groups = $gpermHandler->getGroupIds('ams_audience', $id, $xoopsModule->getVar('mid'));
    } else {
        $audience = '';
        $groups = array();
    }
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $aform = new XoopsThemeForm(_AMS_AM_MANAGEAUDIENCES, 'audienceform', 'articles.php', 'post');
    if ($id > 0) {
        $aform->addElement(new XoopsFormHidden('aid', $id));
    }
    $aform->addElement(new XoopsFormHidden('op', 'audience'));
    $aform->addElement(new XoopsFormText(_AMS_AM_AUDIENCENAME, 'aname', 12, 20, $audience), true);
    $aform->addElement(new XoopsFormSelectGroup(_AMS_AM_ACCESSRIGHTS, 'groups', true, $groups, 5, true), true);
    $aform->addElement(new XoopsFormButton('', 'submitaud', _AMS_AM_SAVE, 'submit'));
    $aform->display();
}

$moduleAdmin = \Xmf\Module\Admin::getInstance();

switch ($op) {
    case 'newarticle':
        $moduleAdmin->displayNavigation('articles.php?op=newarticle');
        $moduleAdmin->addItemButton(_AMS_AM_POSTNEWARTICLE, XOOPS_URL . '/modules/' .$xoopsModule->getVar('dirname') . '/submit.php', 'add');
        $moduleAdmin->displayButton('right', '');
        include_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
        newSubmissions();
        lastStories();
        break;

    case 'audience':
        $moduleAdmin->displayNavigation('articles.php?op=audience');
        if (isset($_POST['submitaud'])) {
            $audienceHandler = xoops_getModuleHandler('audience', 'AMS');
            $gpermHandler = xoops_getHandler('groupperm');
            if (isset($_POST['aid'])) {
                $audience = $audienceHandler->get($_POST['aid']);
            } else {
                $audience = $audienceHandler->create();
            }
            $audience->setVar('audience', $_POST['aname']);
            if ($audienceHandler->insert($audience)) {
                $audid = $audience->getVar('audienceid');
                global $xoopsModule;
                $criteria = new CriteriaCompo(new Criteria('gperm_name', 'ams_audience'));
                $criteria->add(new Criteria('gperm_modid', (int)$xoopsModule->getVar('mid')));
                $criteria->add(new Criteria('gperm_itemid', (int)$audid));
                $gpermHandler->deleteAll($criteria);
                foreach ($_POST['groups'] as $groupid) {
                    $gpermHandler->addRight('ams_audience', $audid, $groupid, $xoopsModule->getVar('mid'));
                }
                echo "<div class='confirmMsg'><h3>" . $audience->getVar('audience') . ' Saved</h3></div>';
            }
        }
        $audid = isset($_GET['audid']) ? (int)$_GET['audid'] : 0;
        audienceForm($audid);
        echo listAudience();
        break;

    case 'delete':
        if (!empty($_POST['ok'])) {
            if (empty($storyid)) {
                redirect_header('articles.php?op=newarticle', 2, _AMS_AM_EMPTYNODELETE);
                exit();
            }
            $story = new AmsStory($storyid);
            $story->delete();
            $sfiles = new sFiles();
            $filesarr = array();
            $filesarr = $sfiles->getAllbyStory($storyid);
            if (count($filesarr) > 0) {
                foreach ($filesarr as $onefile) {
                    $onefile->delete();
                }
            }
            xoops_comment_delete($xoopsModule->getVar('mid'), $storyid);
            xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'story', $storyid);
            redirect_header('articles.php?op=newarticle', 1, _AMS_AM_DBUPDATED);
            exit();
        } else {
            $story = new AmsStory($storyid);
            echo '<h4>' . _AMS_AM_CONFIG . '</h4>';
            xoops_confirm(array('op' => 'delete', 'storyid' => $storyid, 'ok' => 1), 'articles.php', _AMS_AM_RUSUREDEL . '<br />' . $story->title());
        }
        break;

    case 'default':
    default:
    case 'topicsmanager':
        $moduleAdmin->displayNavigation('articles.php?op=topicsmanager');
        topicsmanager();
        break;

    case 'addTopic':
        addTopic();
        break;

    case 'delTopic':
        delTopic();
        break;
    case 'modTopicS':
        modTopicS();
        break;

    case 'edit':
        include __DIR__ . '/../submit.php';
        break;

    case 'delaudience':
        if (1 == $_GET['audienceid']) {
            redirect_header('articles.php?op=audience', 2, _AMS_AM_CANNOTDELETEDEFAULTAUDIENCE);
        }
        $audienceHandler = xoops_getModuleHandler('audience', 'AMS');
        $audiences = $audienceHandler->getAllAudiences();
        $thisaudience = $audiences[$_GET['audienceid']];
        unset($audiences[$_GET['audienceid']]);
        foreach ($audiences as $id => $audience) {
            $newaudiences[$audience->getVar('audience')] = $id;
        }
        $storycount = $audienceHandler->getStoryCountByAudience($thisaudience);
        if ($storycount > 0) {
            xoops_confirm(array('op' => 'delaudienceok', 'audienceid' => $_GET['audienceid'], 'newaudience' => $newaudiences), 'articles.php', $thisaudience->getVar('audience') . '<br />'
                                                                                                                                               . sprintf(_AMS_AM_AUDIENCEHASSTORIES, $storycount));
        } else {
            xoops_confirm(array('op' => 'delaudienceok', 'audienceid' => $_GET['audienceid'], 'newaudience' => 1), 'articles.php', $thisaudience->getVar('audience') . '<br />'
                                                                                                                                   . _AMS_AM_RUSUREDELAUDIENCE);
        }
        break;

    case 'delaudienceok':
        if (!isset($_POST['audienceid']) || !isset($_POST['newaudience'])) {
            redirect_header('javascript:history.go(-1)', 2, _AMS_AM_PLEASESELECTNEWAUDIENCE);
        }
        $audienceHandler = xoops_getModuleHandler('audience', 'AMS');
        $thisaudience = $audienceHandler->get($_POST['audienceid']);
        if ($audienceHandler->deleteReplace($thisaudience, $_POST['newaudience'])) {
            redirect_header('articles.php?op=audience', 3, _AMS_AM_AUDIENCEDELETED);
        } else {
            redirect_header('articles.php?op=audience', 3, _AMS_AM_ERROR_AUDIENCENOTDELETED);
        }
        break;

    case 'reorder':
        if (!isset($_POST['weight']) || !is_array($_POST['weight']) || (0 == count($_POST['weight']))) {
            header('location:articles.php?op=topicsmanager');
        }
        $topics = AmsTopic::getAllTopics();
        $errors = 0;
        foreach ($_POST['weight'] as $topicid => $weight) {
            $topics[$topicid]->weight = $weight;

            //Added in AMS 2.50 Final. Fix bug: Topic name with an ' (apostrophe) in it, cannot change the weight of that Topic
            if (get_magic_quotes_gpc()) {
                $topics[$topicid]->topic_title = addslashes($topics[$topicid]->topic_title);
            }

            if (!$topics[$topicid]->store()) {
                $errors++;
            }
        }
        if ($errors) {
            redirect_header('articles.php?op=topicsmanager', 3, _AMS_AM_ERROR_REORDERERROR);
        } else {
            redirect_header('articles.php?op=topicsmanager', 3, _AMS_AM_REORDERSUCCESSFUL);
        }
        break;

}

require __DIR__ . '/admin_footer.php';
