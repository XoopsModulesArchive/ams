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
include_once '../../mainfile.php';
include_once 'class/class.newsstory.php';
include_once 'class/class.newstopic.php';
include_once 'class/class.sfiles.php';
include_once XOOPS_ROOT_PATH.'/class/uploader.php';
include_once XOOPS_ROOT_PATH.'/header.php';
if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/admin.php')) {
    include_once 'language/'.$xoopsConfig['language'].'/admin.php';
}
else {
    include_once 'language/english/admin.php';
}

$module_id = $xoopsModule->getVar('mid');
$groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

$gperm_handler =& xoops_gethandler('groupperm');
$perm_itemid = isset($_POST['topic_id']) ? intval($_POST['topic_id']) : 0;

//If no access
if (!$gperm_handler->checkRight("ams_submit", $perm_itemid, $groups, $module_id)) {
    redirect_header('index.php', 3, _NOPERM);
}

$op = 'form';
foreach ( $_POST as $k => $v ) {
	${$k} = $v;
}

//If approve privileges
$approveprivilege = 0;
if ($xoopsUser && $gperm_handler->checkRight("ams_approve", $perm_itemid, $groups, $module_id)) {
    $approveprivilege = 1;
}

if ( isset($_POST['preview'] )) {
	$op = 'preview';
} elseif ( isset($_POST['post']) ) {
	$op = 'post';
}
elseif ( isset($_GET['op']) && isset($_GET['storyid'])) {
    if ($approveprivilege && $_GET['op'] == 'edit') {
        $op = 'edit';
    }
    elseif ($approveprivilege && $_GET['op'] == 'delete') {
        $op = 'delete';
    }
    else {
        redirect_header("index.php", 0, _NOPERM);
        exit();
    }
    $storyid = intval($_GET['storyid']);
}
switch ($op) {
    case "delete":
        if ( !empty( $ok ) )
        {
            if ( empty( $storyid ) )
            {
                redirect_header( 'index.php?op=newarticle', 2, _AMS_AM_EMPTYNODELETE );
                exit();
            }
            $story = new AmsStory( $storyid );
            $story -> delete();
			$sfiles = new sFiles();	
			$filesarr=Array();
			$filesarr=$sfiles->getAllbyStory($storyid);
			if(count($filesarr)>0) 
			{
				foreach ($filesarr as $onefile) 
				{
					$onefile->delete();				
				}
			}            
            xoops_comment_delete( $xoopsModule -> getVar( 'mid' ), $storyid );
            xoops_notification_deletebyitem( $xoopsModule -> getVar( 'mid' ), 'story', $storyid );
            redirect_header( 'index.php?op=newarticle', 1, _AMS_AM_DBUPDATED );
            exit();
        }
        else
        {
            xoops_cp_header();
            echo "<h4>" . _AMS_AM_CONFIG . "</h4>";
            xoops_confirm( array( 'op' => 'delete', 'storyid' => $storyid, 'ok' => 1 ), 'submit.php', _AMS_AM_RUSUREDEL );
        }
        break;
        
    case 'edit':
        if (!$approveprivilege) {
            redirect_header('index.php', 0, _NOPERM);
            break;
        }
        echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
        echo "<h4>" . _AMS_AM_EDITARTICLE . "</h4>";
        $story = new AmsStory( $storyid );
        $title = $story -> title( "Edit" );
        $hometext = $story -> hometext( "Edit" );
        $bodytext = $story -> bodytext( "Edit" );
        $nohtml = $story -> nohtml();
        $nosmiley = $story -> nosmiley();
        $ihome = $story -> ihome();
        $notifypub = 0;
        $topicid = $story -> topicid();
        $approve = 0;
        $published = $story->published();
        $banner = $story->banner;
        if (isset($published) && $published > 0) {
            $approve = 1;
        }
        if ( $story -> published() != 0)
        {
            $published = $story -> published();
        }
		if ( $story -> expired() != 0)
        {
            $expired = $story -> expired();
        }
        else {
            $expired = 0;
        }
        $edit = true;
		$type = $story -> type();
        $topicdisplay = $story -> topicdisplay();
        $topicalign = $story -> topicalign( false );
        $isedit = 1;
        $audience = $story -> audienceid;
        include "include/storyform.inc.php";
        echo"</td></tr></table>";
        break;

case "preview":
	$xt = new AmsTopic($xoopsDB->prefix("ams_topics"), $_POST['topic_id']);
	$text = explode("[extend]", $hometext);
	$hometext = $text[0];
	$bodytext = isset($text[1]) ? $text[1] : "";
	if ( isset( $storyid ) ) {
	    $story = new AmsStory( $storyid );
	    $published = $story -> published();
	    $expired = $story -> expired();
	    $edit = true;
	}
	else {
	    $story = new AmsStory();
	    $published = 0;
	    $expired = 0;
	    $edit = false;
	}
	$topicid = $topic_id;
	$story->setTitle($title);
	$story->setHometext($hometext);
	$story->banner = isset($_POST['banner']) ? $_POST['banner'] : 0;
	if ($approveprivilege) {
	    $story->setTopicdisplay($topicdisplay);
	    $story->setTopicalign($topicalign);
	    $story->setBodytext($bodytext);
	    $story->audienceid = $_POST['audience'];
	}
	else {
	    $noname = isset($noname) ? intval($noname) : 0;
	}
	$notifypub = isset($notifypub) ? intval($notifypub) : 0;

	if ( isset( $nosmiley ) && ( $nosmiley == 0 || $nosmiley == 1 ) ) {
	    $story -> setNosmiley( $nosmiley );
	}
	else {
	    $nosmiley = 0;
	}
	if ($approveprivilege) {
	    $nohtml = isset($nohtml) ? intval($nohtml) : 0;
		$story->setNohtml($nohtml);
		if (!isset($approve)) {
		    $approve = 0;
		}
	} else {
		$story->setNohtml = 1;
	}

	$title = $story->title("InForm");
  	$hometext = $story->hometext("InForm");
  	if ($approveprivilege) {
  	    $bodytext = $story->bodytext("InForm");
  	    $ihome = $story -> ihome();
  	}

	//Display post preview
	$p_title = $story->title("Preview");
	$p_hometext = $story->hometext("Preview");
	$p_hometext .= $story->bodytext("Preview");
	if (isset($change)) {
	    $edit = true;
	}
	$topversion = ($story->revision == 0 && $story->revisionminor == 0) ? 1 : 0;
	$topicalign = isset($story->topicalign) ? 'align="'.$story->topicalign().'"' : "";
	$p_hometext = (($xt->topic_imgurl() != '') && $topicdisplay) ? '<img src="images/topics/'.$xt->topic_imgurl().'" '.$topicalign.' alt="" />'.$p_hometext : $p_hometext;
	themecenterposts($p_title, $p_hometext);
	$audience = $story->audienceid;

	//Display post edit form
	include 'include/storyform.inc.php';
	break;

case "post":
    $text = explode("[extend]", $hometext);
	$hometext = $text[0];
	$bodytext = isset($text[1]) ? $text[1] : "";
	$nohtml_db = 1;
	if ( is_object($xoopsUser) ) {
		$uid = $xoopsUser->getVar('uid');
		if ( $approveprivilege ) {
		    $nohtml_db = empty($nohtml) ? 0 : 1;
		}
	} else {
	    $uid = 0;
	}
	if ( empty( $storyid ) ) {
	    $story = new AmsStory();
	    $story -> setUid( $uid );
	}
	else {
	    $story = new AmsStory( $storyid );
        $story->setChange($change);
        if ($newauthor && $approveprivilege) {
            $story->setUid($uid);
        }
	}
	$story->banner = isset($_POST['banner']) ? $_POST['banner'] : 0;
	$story->setTitle($title);
	$story->setHometext($hometext);
	if ($bodytext) {
	    $story->setBodytext($bodytext);
	}
	else {
	    $story->setBodytext(' ');
	}
	$story->setTopicId($topic_id);
	$story->setHostname(xoops_getenv('REMOTE_ADDR'));
	$story->setNohtml($nohtml_db);
	$nosmiley = isset($nosmiley) ? intval($nosmiley) : 0;
	$notifypub = isset($notifypub) ? intval($notifypub) : 0;
	$story->setNosmiley($nosmiley);
	$story->setNotifyPub($notifypub);
	$story->setType($type);
	if ($approveprivilege) {
	    if ( !empty( $autodate )) {
	        $pubdate = strtotime($publish_date['date']) + $publish_date['time'];
	        $offset = $xoopsUser -> timezone() - $xoopsConfig['server_TZ'];
	        $pubdate = $pubdate - ( $offset * 3600 );
	        $story -> setPublished( $pubdate );
	    }
	    if ( !empty( $autoexpdate )) {
	        $expiry_date = strtotime($expiry_date['date']) + $expiry_date['time'];
	        $offset = $xoopsUser -> timezone() - $xoopsConfig['server_TZ'];
	        $expiry_date = $expiry_date - ( $offset * 3600 );
	        $story -> setExpired( $expiry_date );
	    }
	    $story->setTopicdisplay($topicdisplay);
	    $story->setTopicalign($topicalign);
	    $story->setIhome($ihome);
	    $approve = isset($approve) ? $approve : 0;
	    if (!$story->published()) {
	        $story->setPublished(time());
	    }
	    if (!$story->expired()) {
	        $story->setExpired(0);
	    }
	    if(!$approve) {
	    	$story->setPublished(0);
	    }
	    $story->audienceid = intval($_POST['audience']);
	}
    elseif ( $xoopsModuleConfig['autoapprove'] == 1 && !$approveprivilege) {
		$approve = 1;
    	$story->setPublished(time());
    	$story->setExpired(0);
		$story->setTopicalign('R');
	}
	else {
	    $story->setPublished(0);
	    $approve = 0;
	    $story -> setExpired( 0 );
	}
	$story->setApproved($approve);
	$result = $story->store();
	
	if ($result) {
	    // Notification
	    $notification_handler =& xoops_gethandler('notification');
	    $tags = array();
	    $tags['STORY_NAME'] = $title;
	    $tags['STORY_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/article.php?storyid=' . $story->storyid();
	    if ( $approve == 1) {
	        $notification_handler->triggerEvent('global', 0, 'new_story', $tags);
	    } else {
	        $tags['WAITINGSTORIES_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=newarticle';
	        $notification_handler->triggerEvent('global', 0, 'story_submit', $tags);
	    }
	    // If notify checkbox is set, add subscription for approve
	    if ($notifypub) {
	        include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
	        $notification_handler->subscribe('story', $story->storyid(), 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
	    }
	    
	    // Manage upload(s)
	    if(isset($_POST['delupload']) && count($_POST['delupload'])>0 )
	    {
	        foreach ($_POST['delupload'] as $onefile)
	        {
	            $sfiles = new sFiles($onefile);
	            $sfiles->delete();
	        }
	    }
	    
	    if(isset($_POST['xoops_upload_file'])&& isset($_FILES[$_POST['xoops_upload_file'][0]]))
	    {
	        $fldname = $_FILES[$_POST['xoops_upload_file'][0]];
	        $fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname['name']) : $fldname['name'];
	        if(trim($fldname!=''))
	        {
	            $sfiles = new sFiles();
	            $destname=$sfiles->createUploadName(XOOPS_UPLOAD_PATH,$fldname);
	            // Actually : Web pictures (png, gif, jpeg), zip, doc, xls, pdf, gtar, tar
	            $permittedtypes=array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png' ,'application/x-zip-compressed','application/msword', 'application/vnd.ms-excel', 'application/pdf', 'application/x-gtar', 'application/x-tar');
	            $uploader = new XoopsMediaUploader( XOOPS_UPLOAD_PATH, $permittedtypes, $xoopsModuleConfig['maxuploadsize']);
	            $uploader->setTargetFileName($destname);
	            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0]))
	            {
	                if ($uploader->upload())
	                {
	                    $sfiles->setFileRealName($uploader->getMediaName());
	                    $sfiles->setStoryid($story->storyid());
	                    $sfiles->setMimetype($sfiles->giveMimetype(XOOPS_UPLOAD_PATH.'/'.$uploader->getMediaName()));
	                    $sfiles->setDownloadname($destname);
	                    if(!$sfiles->store())
	                    {
	                        echo _AMS_AM_UPLOAD_DBERROR_SAVE;
	                    }
	                }
	                else
	                {
	                    echo _AMS_AM_UPLOAD_ERROR;
	                }
	            } else {
	                echo $uploader->getErrors();
	            }
	        }
	    }
	}
	else {
	    if ($story->versionConflict == true) {
	        include ('include/versionconflict.inc.php');
	        break;
	    }
	    else {
	        $message = $story->renderErrors();
	    }
	}
	if (!isset($message)) {
	    $message = _AMS_NW_THANKS;
	}
	redirect_header("index.php",2, $message);
	break;
	
	case _AMS_NW_OVERRIDE:
	   if (!$approveprivilege || !$xoopsUser) {
	       redirect_header('index.php', 3, _NOPERM);
	   }
	   $hiddens = array('bodytext' => $_POST['bodytext'], 
	                    'hometext' => $_POST['hometext'],
	                    'storyid' => $_POST['storyid'],
	                    'change' => $_POST['change'],
	                    'op' => 'override_ok');
	   $story = new AmsStory($_POST['storyid']);
	   $story->setChange($_POST['change']);
	   
	   $message = "";
	   $story->calculateVersion();
	   $message .= _AMS_NW_TRYINGTOSAVE." ".$story->version.".".$story->revision.".".$story->revisionminor." <br />";
	   $higher_versions = $story->getVersions(true);
	   if (count($higher_versions) > 0) {
	       $message .= sprintf(_AMS_NW_VERSIONSEXIST, count($higher_versions));
	       $message .= "<br />";
	       foreach ($higher_versions as $key => $version) {
	           $message .= $version['version'].".".$version['revision'].".".$version['revisionminor']."<br />";
	       }
	   }
	   $message .= _AMS_NW_AREYOUSUREOVERRIDE;
	   xoops_confirm($hiddens, 'submit.php', $message, _YES);
	   break;
	
	case 'override_ok':
	   if (!$approveprivilege || !$xoopsUser) {
	       redirect_header('index.php', 3, _NOPERM);
	   }
	   $story = new AmsStory($_POST['storyid']);
	   $story->setChange($_POST['change']);
	   $story->setUid($xoopsUser->getVar('uid'));
	   $story->setHometext($_POST['hometext']);
	   $story->setBodytext($_POST['bodytext']);
	   $story->calculateVersion();
	   if ($story->overrideVersion()) {
	       $message = sprintf(_AMS_NW_VERSIONUPDATED, $story->version.".".$story->revision.".".$story->revisionminor);
	   }
	   else {
	       $message = $story->renderErrors();
	   }
	   redirect_header('article.php?storyid='.$story->storyid, 3, $message);
	   break;
	   
	   
	case _AMS_NW_FINDVERSION:
	   if (!$approveprivilege || !$xoopsUser) {
	       redirect_header('index.php', 3, _NOPERM);
	       exit();
	   }
	   $story = new AmsStory($_POST['storyid']);
	   $story->setUid($xoopsUser->getVar('uid'));
	   $story->setHometext($_POST['hometext']);
	   $story->setBodytext($_POST['bodytext']);
	   $story->setChange($_POST['change']);
	   if ($story->calculateVersion(true)) {
	       if ($story->updateVersion()) {
	           $message = sprintf(_AMS_NW_VERSIONUPDATED, $story->version.".".$story->revision.".".$story->revisionminor);
	           //redirect_header('article.php?storyid='.$story->storyid(), 3, $message);
	           //exit();
	       }
	       else {
	           $message = $story->renderErrors();
	       }
	   }
	   else {
	       $message = $story->renderErrors();
	   }
	   redirect_header('article.php?storyid='.$story->storyid(), 3, $message);
	   break;

    case 'form':
    default:
    	$title = '';
    	$hometext = '';
    	$noname = 0;
    	$nohtml = 0;
    	$nosmiley = 0;
    	$notifypub = 1;
    	$topicid = 0;
    	if ($approveprivilege) {
    	    $topicdisplay = 0;
    	    $topicalign = 'R';
    	    $ihome = 0;
    	    $bodytext = ' ';
    	    $approve = 1;
    	    $autodate = '';
    	    $expired = 0;
    	    $published = 0;
    	    $audience = 0;
    	}
    	$banner = "";
    	$edit = false;
    	include 'include/storyform.inc.php';
    	break;
}
include XOOPS_ROOT_PATH.'/footer.php';
?>
