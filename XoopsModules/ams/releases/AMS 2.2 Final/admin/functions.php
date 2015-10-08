<?php
function adminmenu($currentoption=0)
{
    global $xoopsModule, $xoopsConfig;
    $tblColors=Array();
    $tblColors[0]=$tblColors[1]=$tblColors[2]=$tblColors[3]=$tblColors[4]=$tblColors[5]='#DDE';
    if($currentoption>=0) {
    $tblColors[$currentoption]='white';
	}
    if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/modinfo.php')) {
        include_once '../language/'.$xoopsConfig['language'].'/modinfo.php';
    }
    else {
        include_once '../language/english/modinfo.php';
    }
	echo "<div id=\"navcontainer\"><ul style=\"padding: 3px 0; margin-left: 0; font: bold 12px Verdana, sans-serif; \">";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"index.php?op=topicsmanager\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[0]."; text-decoration: none; \">"._AMS_MI_NEWS_ADMENU2."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"index.php?op=newarticle\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[1]."; text-decoration: none; \">"._AMS_MI_NEWS_ADMENU3."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"groupperms.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[2]."; text-decoration: none; \">"._AMS_MI_NEWS_GROUPPERMS."</a></li>";
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule -> getVar( 'mid' )."\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[3]."; text-decoration: none; \">"._PREFERENCES."</a></li>";
	if (!table_exists('ams_article')) {
	    echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"".XOOPS_URL."/modules/AMS/upgrade/index.php\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[4]."; text-decoration: none; \">"._AMS_AM_NEWS_UPGRADE."</a></li>";
	}
	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"index.php?op=audience\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ".$tblColors[5]."; text-decoration: none; \">"._AMS_AM_MANAGEAUDIENCES."</a></li>";
	echo "</ul></div>";
}

function table_exists($tablename) {
    global $xoopsDB;
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix($tablename);
    return $xoopsDB->query($sql);
}
?>