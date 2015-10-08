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
if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php')) {
	include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php';
} else {
	include_once XOOPS_ROOT_PATH.'/language/english/calendar.php';
}
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

include_once(XOOPS_ROOT_PATH."/class/tree.php");

$sform = new XoopsThemeForm(_AMS_NW_SUBMITNEWS, "storyform", XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/submit.php');
$sform->setExtra('enctype="multipart/form-data"');
$sform->addElement(new XoopsFormText(_AMS_NW_TITLE, 'title', 50, 80, $story->title('Edit')), true);

//Todo: Change to only display topics, which a user has submit privileges for
if (!isset($xt)) {
    $xt = new AmsTopic($xoopsDB->prefix("ams_topics"));
}
$alltopics = $xt->getAllTopics(true, "ams_submit");
if (count($alltopics) == 0) {
    redirect_header('index.php', 3, _AMS_NW_NOTOPICS);
}
$topic_obj_tree = new XoopsObjectTree($alltopics, 'topic_id', 'topic_pid');
$sform->addElement(new XoopsFormLabel(_AMS_NW_TOPIC, $topic_obj_tree->makeSelBox('topic_id', 'topic_title', '--', $story->topicid())));

//If admin - show admin form
//TODO: Change to "If submit privilege"
if ($approveprivilege) {
    //Show topic image?
    $topic_img = new XoopsFormRadio(_AMS_AM_TOPICDISPLAY, 'topicdisplay', $story->topicdisplay());
    $topic_img->addOption(0, _AMS_AM_NONE);
    $topic_img->addOption(1, _AMS_AM_TOPIC);
    $topic_img->addOption(2, _AMS_AM_AUTHOR);
    $sform->addElement($topic_img);
    //Select image position
    $posselect = new XoopsFormSelect(_AMS_AM_TOPICALIGN, 'topicalign', $story->topicalign());
    $posselect->addOption('R', _AMS_AM_RIGHT);
    $posselect->addOption('L', _AMS_AM_LEFT);
    $sform->addElement($posselect);
    //Publish in home?
    //TODO: Check that pubinhome is 0 = no and 1 = yes (currently vice versa)
    $sform->addElement(new XoopsFormRadioYN(_AMS_AM_PUBINHOME, 'ihome', $story->ihome(), _NO, _YES));
    $audience_handler =& xoops_getmodulehandler('audience', 'AMS');
    $audiences = $audience_handler->getAllAudiences();
    $audience_select = new XoopsFormSelect(_AMS_NW_AUDIENCE, 'audience', $story->audienceid);
    if (is_array($audiences) && count($audiences) > 0) {
        foreach ($audiences as $aid => $audience) {
            $audience_select->addOption($aid, $audience->getVar('audience'));
        }
    }
    $sform->addElement($audience_select);
}
if(file_exists(XOOPS_ROOT_PATH."/class/wysiwyg/formwysiwygtextarea.php"))
{
	$url="/class/wysiwyg";
}elseif(file_exists(XOOPS_ROOT_PATH."/class/xoopseditor/koivi/formwysiwygtextarea.php"))
{
	$url="/class/xoopseditor/koivi";

}else
{
	$url="";
}
if ($xoopsModuleConfig['editor'] == "koivi" && $url !=""){

	include_once XOOPS_ROOT_PATH."$url/formwysiwygtextarea.php";
	if(file_exists(XOOPS_ROOT_PATH.$url."/language/".$xoopsConfig['language'].".php")) 
	include_once ''.XOOPS_ROOT_PATH.$url."/language/".$xoopsConfig['language'].".php";
	else include_once ''.XOOPS_ROOT_PATH.$url."/language/english.php"; 
	
	$myts =& MyTextSanitizer::getInstance();
	if($url=="/class/wysiwyg")
	{
		$wysiwyg_text_area= new XoopsFormWysiwygTextArea( _AMS_NW_THESCOOP,'hometext', $myts->stripSlashesGPC($story->hometext),'100%', '200px', 'hiddenHometext');
		$wysiwyg_text_area2= new XoopsFormWysiwygTextArea( _AMS_AM_EXTEXT, 'bodytext', $myts->stripSlashesGPC($story->bodytext),'100%', '200px', 'hiddenBodytext');
	}else
	{
		$wysiwyg_text_area= new XoopsFormWysiwygTextArea( array('caption'=>_AMS_NW_THESCOOP, 'name'=>'hometext', 'value'=>$myts->stripSlashesGPC($story->hometext), 'width'=>'100%', 'height'=>'200px'), 'hiddenHometext');
		$wysiwyg_text_area2= new XoopsFormWysiwygTextArea( array('caption'=>_AMS_AM_EXTEXT, 'name'=>'bodytext', 'value'=>$myts->stripSlashesGPC($story->bodytext), 'width'=>'100%', 'height'=>'200px'), 'hiddenBodytext');
	}
	//NOW WE MAKE A WYSIWYG OBJECT
	//(if the last parameter is empty '', the full toolbar will be loaded)
	
	//SPECIFY THE WYSIWYG FILES RELATIVE PATH(this parameter is optative if the editor is allocated in /class/wysiwyg)
	$wysiwyg_text_area->setUrl("$url");
	$wysiwyg_text_area2->setUrl("$url");

	//SPECIFY A SKIN (this parameter is optative)(The new skin must be inside "skins" folder. You must specify the skin's folder name)
	//$wysiwyg_text_area->setSkin('xp');

	//ADD THE WYSIWYG OBJECT TO THE FORM
	$sform->addElement( $wysiwyg_text_area,false );
	$sform->addElement( (new XoopsFormLabel('','* '._MULTIPLE_PAGE_GUIDE)),false );
	$sform->addElement( $wysiwyg_text_area2,false );
	$sform->addElement( (new XoopsFormLabel('','* '._MULTIPLE_PAGE_GUIDE)),false );
		
}
else {
	$sform->addElement(new XoopsFormDhtmlTextArea(_AMS_NW_THESCOOP, 'hometext', $story->hometext("Edit"), 15, 60, 'hiddenHometext'));
	$sform->addElement( (new XoopsFormLabel('','* '._MULTIPLE_PAGE_GUIDE)),false );
	$sform->addElement(new XoopsFormDhtmlTextArea(_AMS_AM_EXTEXT, 'bodytext', $story->bodytext("Edit"), 15, 60, 'hiddenBodytext'));
	$sform->addElement( (new XoopsFormLabel('','* '._MULTIPLE_PAGE_GUIDE)),false );
}

$myts =& MyTextSanitizer::getInstance();
$sform->addElement(new XoopsFormTextArea(_AMS_NW_BANNER, 'banner', $myts->htmlSpecialChars($story->banner)));

if ($edit && (!isset($_GET['approve']))) {
    $change_radio = new XoopsFormRadio(_AMS_NW_MAJOR, 'change', $story->change);
    $change_radio->addOption(0, _AMS_NW_NOVERSIONCHANGE);
    $change_radio->addOption(1, _AMS_NW_VERSION);
    $change_radio->addOption(2, _AMS_NW_REVISION);
    $change_radio->addOption(3, _AMS_NW_MINOR);
    $change_radio->addOption(4, _AMS_NW_AUTO);
    $change_radio->setDescription(_AMS_NW_VERSIONDESC);
    $change_radio->setValue(4);
    $sform->addElement($change_radio);
    $sform->addElement(new XoopsFormRadioYN(_AMS_NW_SWITCHAUTHOR." (".$story->uname.")", 'newauthor', 0));
}

// Manage upload(s)
$allowupload = false;
switch ($xoopsModuleConfig['uploadgroups']) 
{ 
	case 1: //Submitters and Approvers        
		$allowupload = true;        
		break;    
	case 2: //Approvers only        
		$allowupload = $approveprivilege ? true : false;
		break;    
	case 3: //Upload Disabled
		$allowupload = false;        
		break;
}

if($allowupload) 
{
	if($edit) {
		$sfiles = new sFiles();	
		$filesarr=Array();
		$filesarr=$sfiles->getAllbyStory($story->storyid());
		if(count($filesarr)>0) {
			$upl_tray = new XoopsFormElementTray(_AMS_AM_UPLOAD_ATTACHFILE,'<br />');
			$upl_checkbox=new XoopsFormCheckBox('', 'delupload[]');
			
			foreach ($filesarr as $onefile) 
			{
				$link=sprintf("<a href='%s/%s' target='_blank'>%s</a>\n",XOOPS_UPLOAD_URL,$onefile->getDownloadname('S'),$onefile->getFileRealName('S'));
				$upl_checkbox->addOption($onefile->getFileid(),$link);
			}			
			$upl_tray->addElement($upl_checkbox,false);
			$dellabel=new XoopsFormLabel(_AMS_AM_DELETE_SELFILES,'');
			$upl_tray->addElement($dellabel,false);			
			$sform->addElement($upl_tray);
		}
	}
	$sform->addElement(new XoopsFormFile(_AMS_AM_SELFILE, 'attachedfile', $xoopsModuleConfig['maxuploadsize']), false);
}


$option_tray = new XoopsFormElementTray(_OPTIONS,'<br />');
//Set date of publish/expiration
if ($approveprivilege) {
    $approve_checkbox = new XoopsFormCheckBox('', 'approve', $story->approved);
    $approve_checkbox->addOption(1, _AMS_AM_APPROVE);
    $option_tray->addElement($approve_checkbox);

    $published_checkbox = new XoopsFormCheckBox('', 'autodate');
    $published_checkbox->addOption(1, _AMS_AM_SETDATETIME);
    $option_tray->addElement($published_checkbox);

    $option_tray->addElement(new XoopsFormDateTime(_AMS_AM_SETDATETIME, 'publish_date', 15, $story->published()));

    $expired_checkbox = new XoopsFormCheckBox('', 'autoexpdate');
    $expired_checkbox->addOption(1, _AMS_AM_SETEXPDATETIME);
    $option_tray->addElement($expired_checkbox);

    $option_tray->addElement(new XoopsFormDateTime(_AMS_AM_SETEXPDATETIME, 'expiry_date', 15, $story->expired()));
}

if (is_object($xoopsUser)) {
	$notify_checkbox = new XoopsFormCheckBox('', 'notifypub', $story->notifypub());
	$notify_checkbox->addOption(1, _AMS_NW_NOTIFYPUBLISH);
	$option_tray->addElement($notify_checkbox);
	if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
		$nohtml_checkbox = new XoopsFormCheckBox('', 'nohtml', $story->nohtml());
		$nohtml_checkbox->addOption(1, _DISABLEHTML);
		$option_tray->addElement($nohtml_checkbox);
	}
}
$smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $story->nosmiley());
$smiley_checkbox->addOption(1, _DISABLESMILEY);
$option_tray->addElement($smiley_checkbox);


$sform->addElement($option_tray);

//TODO: Approve checkbox + "Move to top" if editing + Edit indicator

//Submit buttons
$button_tray = new XoopsFormElementTray('' ,'');
$preview_btn = new XoopsFormButton('', 'preview', _PREVIEW, 'submit');
$preview_btn->setExtra('accesskey="p"');
$button_tray->addElement($preview_btn);
$submit_btn = new XoopsFormButton('', 'post', _AMS_NW_POST, 'submit');
$submit_btn->setExtra('accesskey="s"');
$button_tray->addElement($submit_btn);
$sform->addElement($button_tray);

//Hidden variables
if($story->storyid() > 0){
    $storyid_hidden = new XoopsFormHidden('storyid', $story->storyid());
    $sform->addElement($storyid_hidden);
}
if (!($story->type())) {
    if ($approveprivilege) {
        $type = "admin";
    }
    else {
        $type = "user";
    }
}
$type_hidden = new XoopsFormHidden('type', $type);
$sform->addElement($type_hidden);
$sform->display();
?>