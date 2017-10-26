<?php

include __DIR__ . '/../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/class/class.newsstory.php';
if (!isset($_POST['submit'])) {
    if (!isset($_GET['storyid'])) {
        redirect_header(XOOPS_URL.'/modules/AMS/index.php', 3, _AMS_NW_NOSTORY);
        exit();
    }
    $xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0; // disable caching
    $GLOBALS['xoopsOption']['template_main'] = 'ams_version'CriteriaElement'';
    include_once XOOPS_ROOT_PATH . '/header.php';
    $story = new AmsStory((int)$_GET['storyid']);
    $gpermHandler = xoops_getHandler('groupperm');
    if (!$xoopsUser || !$gpermHandler->checkRight('ams_approve', $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
        redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, _NOPERM);
        exit();
    }
    $xoopsTpl->assign('breadcrumb', $story->getPath(true) . ' > ' . _AMS_NW_VERSION);
    $xoopsTpl->assign('lang_go', _GO);
    $xoopsTpl->assign('lang_on', _ON);
    $xoopsTpl->assign('lang_printerpage', _AMS_NW_PRINTERFRIENDLY);
    $xoopsTpl->assign('lang_sendstory', _AMS_NW_SENDSTORY);
    $xoopsTpl->assign('lang_postedby', _POSTEDBY);
    $xoopsTpl->assign('lang_reads', _READS);
    $xoopsTpl->assign('lang_morereleases', _AMS_NW_MORERELEASES);
    $xoopsTpl->assign('versions', $story->getVersions());
    $xoopsTpl->assign('story', $story->toArray(true, false, 0));
} else {
    switch ($_POST['op']) {
        case 'setversion':
            $story = new AmsStory((int)$_POST['storyid']);
            $gpermHandler = xoops_getHandler('groupperm');
            if (!$xoopsUser || !$gpermHandler->checkRight('ams_approve', $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            $version_array = explode('.', $_POST['version']);
            if (!isset($version_array[2])) {
                $version_array[2] = 0;
            }
            if ($story->setCurrentVersion($version_array[0], $version_array[1], $version_array[2])) {
                $message = sprintf(_AMS_NW_VERSIONUPDATED, implode('.', $version_array));
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, $message);
            } else {
                redirect_header(XOOPS_URL.'/modules/AMS/index.php', 3, $story->renderErrors());
            }
            break;

        case 'delversions':
            $story = new AmsStory((int)$_POST['storyid']);
            $gpermHandler = xoops_getHandler('groupperm');
            if (!$xoopsUser || !$gpermHandler->checkRight('ams_approve', $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            if (!empty($_POST['ok'])) {
                include_once XOOPS_ROOT_PATH . '/header.php';
                $story->delversions($_POST['version'], $_POST['revision'], $_POST['revisionminor']);
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, sprintf(_AMS_NW_VERSIONUPDATED, $_POST['version'] . '.'
                                                                                                                                  . $_POST['revision'] . '.'
                                                                                                                                  . $_POST['revisionminor']));
            } else {
                $version_array = explode('.', $_POST['version']);
                if (!isset($version_array[2])) {
                    $version_array[2] = 0;
                }
                include_once XOOPS_ROOT_PATH . '/header.php';
                xoops_confirm(array('op' => 'delversions', 'submit' => 1, 'ok' => 1, 'storyid' => $_POST['storyid'], 'version' => $version_array[0], 'revision' => $version_array[1], 'revisionminor' => $version_array[2]), 'versions.php', _AMS_NW_RUSUREDELVERSIONS);
            }
            break;

        case 'delallversions':
            $story = new AmsStory((int)$_POST['storyid']);
            $gpermHandler = xoops_getHandler('groupperm');
            if (!$xoopsUser || !$gpermHandler->checkRight('ams_approve', $story->topicid(), $xoopsUser->getGroups(), $xoopsModule->mid())) {
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, _NOPERM);
                exit();
            }
            if (!empty($_POST['ok'])) {
                include_once XOOPS_ROOT_PATH . '/header.php';
                $story->delallversions($_POST['version'], $_POST['revision'], $_POST['revisionminor']);
                redirect_header(XOOPS_URL.'/modules/AMS/article.php?storyid='.$story->storyid, 3, sprintf(_AMS_NW_VERSIONUPDATED, $_POST['version'] . '.'
                                                                                                                                  . $_POST['revision'] . '.'
                                                                                                                                  . $_POST['revisionminor']));
            } else {
                $version_array = explode('.', $_POST['version']);
                if (!isset($version_array[2])) {
                    $version_array[2] = 0;
                }
                include_once XOOPS_ROOT_PATH . '/header.php';
                xoops_confirm(array('op' => 'delallversions', 'submit' => 1, 'ok' => 1, 'storyid' => $_POST['storyid'], 'version' => $version_array[0], 'revision' => $version_array[1], 'revisionminor' => $version_array[2]), 'versions.php', _AMS_NW_RUSUREDELALLVERSIONS);
            }
            break;
    }
}
include __DIR__ . '/../../footer.php';
