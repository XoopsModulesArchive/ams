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
 
	
	if (!defined("XOOPS_ROOT_PATH")) {
		die("XOOPS root path not defined");
	}

	if (!class_exists("XoopsPersistableObjectHandler")) {
		include_once XOOPS_ROOT_PATH."/kernel/object.php";
	}

	class ams_topics extends XoopsObject
	{ 
	    var $banner = "";
        var $banner_inherit;
        var $forum_id;
        var $weight = 1; 
		var $_var;
		
		//Constructor
		function __construct()
		{
			$this->XoopsObject();
			$this->initVar("topic_id",XOBJ_DTYPE_INT,null,false,4);
			$this->initVar("topic_pid",XOBJ_DTYPE_INT,null,false,4);
			$this->initVar("topic_imgurl",XOBJ_DTYPE_TXTBOX,null,false);
			$this->initVar("topic_title",XOBJ_DTYPE_TXTBOX,null,false);
			$this->initVar("banner",XOBJ_DTYPE_TXTAREA, null, false);
			$this->initVar("banner_inherit",XOBJ_DTYPE_INT,null,false,2);
			$this->initVar("forum_id",XOBJ_DTYPE_INT,null,false,12);
			$this->initVar("weight",XOBJ_DTYPE_INT,null,false,5);
			$this->initVar("online",XOBJ_DTYPE_INT, null, false,1);
			
			// Pour autoriser le html
			$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
			
		}

		function ams_topics()
		{			        
			$this->__construct();
		}
	
		function getForm($action = false)
		{
			global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
		
			if ($action === false) {
				$action = $_SERVER["REQUEST_URI"];
			}
		
			$title = $this->isNew() ? sprintf(_AM_AMS_TOPICS_ADD) : sprintf(_AM_AMS_TOPICS_EDIT);

			include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

			$form = new XoopsThemeForm($title, "form", $action, "post", true);
			$form->setExtra('enctype="multipart/form-data"');
		
			$form->addElement(new XoopsFormText(_AM_AMS_TOPICTITLE, "topic_title", 50, 255, $this->getVar("topic_title")), true);
			
			// Pour faire une sous-catégorie
            $topicsHandler =& xoops_getModuleHandler('ams_topics', 'ams');
            $criteria = new CriteriaCompo();
            $criteria->setSort('weight ASC, topic_title');
            $criteria->setOrder('ASC');
            $topicspid_arr = $topicsHandler->getall($criteria);
            $mytree = new XoopsObjectTree($topicspid_arr, 'topic_id', 'topic_pid');
            $form->addElement(new XoopsFormLabel(_AM_AMS_TOPICSMNGR, $mytree->makeSelBox('topic_pid', 'topic_title','--',$this->getVar('topic_pid'),true)));
			
			// ********** Picture
			$topic_img = $this->getVar('topic_imgurl') ? $this->getVar('topic_imgurl') : 'blank.gif';
			if(is_dir(XOOPS_ROOT_PATH . "/uploads/ams/topics/topic_imgurl")){
		       $uploadirectory = "/uploads/ams/topics/topic_imgurl";
		    }else{
		       $uploadirectory = "/modules/".$xoopsModule->dirname()."/images/topics/topic_imgurl";
		    }
            //$uploadirectory = '/uploads/ams/topics/topic_imgurl';
            $imgtray = new XoopsFormElementTray(_AM_AMS_FORMIMG,'<br />');
            $imgpath = sprintf(_AM_AMS_FORMPATH, ".".$uploadirectory."/" );
            $imageselect = new XoopsFormSelect($imgpath, 'topic_imgurl', $topic_img);
            $topics_array = XoopsLists :: getImgListAsArray( XOOPS_ROOT_PATH . $uploadirectory );
            foreach( $topics_array as $image ) {
                $imageselect->addOption("$image", $image);
            }
            $imageselect->setExtra( "onchange='showImgSelected(\"image3\", \"topic_imgurl\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'" );
            $imgtray->addElement($imageselect,false);
            $imgtray->addElement( new XoopsFormLabel( '', "<br /><img src='" . XOOPS_URL .  $uploadirectory . "/" . $topic_img . "' name='image3' id='image3' alt='' />" ) );
			
            $fileseltray = new XoopsFormElementTray('','<br />');			
            $fileseltray->addElement(new XoopsFormFile(_AM_AMS_FORMUPLOAD , 'attachedfile', $xoopsModuleConfig['maxuploadsize']), false);
            $fileseltray->addElement(new XoopsFormLabel(''), false);
            $imgtray->addElement($fileseltray);
            $form->addElement($imgtray);	

     		$form->addElement(new XoopsFormTextArea(_AM_AMS_BANNER, "banner", $this->getVar("banner"), 4, 47), false);
			$banner_inherit = $this->isNew() ? 0 : $this->getVar("banner_inherit");			
			$banner_inherit_checkbox = new XoopsFormCheckBox(_AM_AMS_BANNER_INHERIT, 'banner_inherit', $this->getVar("banner_inherit")?1:0);
            $banner_inherit_checkbox->addOption(1, _YES);
            $form->addElement($banner_inherit_checkbox);
			
			//Forum linking
            $module_handler =& xoops_gethandler('module');
            $forum_module =& $module_handler->getByDirname('newbb');
            if (is_object($forum_module) && $forum_module->getVar('version') >= 3.00) {
                $forum_handler =& xoops_getmodulehandler('forum', 'newbb', true);
                if (is_object($forum_handler)) {
                    $forums = $forum_handler->getForums();
                    if (count($forums) > 0) {
                        $forum_tree = new XoopsObjectTree($forums, 'forum_id', 'parent_forum');
                        $form->addElement(new XoopsFormLabel(_AM_AMS_LINKEDFORUM, $forum_tree->makeSelBox('forum_id', 'forum_name', '--', $forum, true)));
                    }
                }
            }
			$form->addElement(new XoopsFormText(_AM_AMS_WEIGHT, "weight", 5, 20, $this->getVar("weight")), true);
			
			// Permissions
            $member_handler = & xoops_gethandler('member');
            $group_list = &$member_handler->getGroupList();
            $gperm_handler = &xoops_gethandler('groupperm');
	        $group_type_ref = &$member_handler->getGroups(null,true);

	        $admin_list = array();
	        $user_list = array();
	        $full_list = array();
	        $admincount=1;
	        $usercount=1;
	        $fullcount=1;
	        foreach (array_keys($group_type_ref) as $i) {		
		        if ($group_type_ref[$i]->getVar('group_type') == 'Admin')
		        {
			        $admin_list[$i]=$group_list[$i];
			        $admincount++;
			        $user_list[$i]=$group_list[$i];
			        $usercount++;			
		        }
		        if ($group_type_ref[$i]->getVar('group_type') == 'User')
		        {
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
			//$topic_id = isset( $_GET['topic_id'] ) ? intval( $_GET['topic_id'] ) : 0;
            if($topic_id > 0) {		// Edit mode
    	       $groups_ids = $gperm_handler->getGroupIds('ams_approve', $topic_id, $xoopsModule->getVar('mid'));
    	       $groups_ids = array_values($groups_ids);
    	       $groups_ams_can_approve_checkbox = new XoopsFormCheckBox(_AM_AMS_APPROVEFORM, 'groups_ams_can_approve[]', $groups_ids);
            } else {	// Creation mode
    	       $groups_ams_can_approve_checkbox = new XoopsFormCheckBox(_AM_AMS_APPROVEFORM, 'groups_ams_can_approve[]', $admin_list);
            }
            $groups_ams_can_approve_checkbox->addOptionArray($group_list);
            $form->addElement($groups_ams_can_approve_checkbox);

	        $groups_ids = array();
            if($topic_id > 0) {		// Edit mode
    	       $groups_ids = $gperm_handler->getGroupIds('ams_submit', $topic_id, $xoopsModule->getVar('mid'));
    	       $groups_ids = array_values($groups_ids);
    	       $groups_ams_can_submit_checkbox = new XoopsFormCheckBox(_AM_AMS_SUBMITFORM, 'groups_ams_can_submit[]', $groups_ids);
            } else {	// Creation mode
    	       $groups_ams_can_submit_checkbox = new XoopsFormCheckBox(_AM_AMS_SUBMITFORM, 'groups_ams_can_submit[]', $user_list);
            }
            $groups_ams_can_submit_checkbox->addOptionArray($group_list);
            $form->addElement($groups_ams_can_submit_checkbox);

	        $groups_ids = array();
            if($topic_id > 0) {		// Edit mode
    	       $groups_ids = $gperm_handler->getGroupIds('ams_view', $topic_id, $xoopsModule->getVar('mid'));
    	       $groups_ids = array_values($groups_ids);
    	       $groups_ams_can_view_checkbox = new XoopsFormCheckBox(_AM_AMS_VIEWFORM, 'groups_ams_can_view[]', $groups_ids);
            } else {	// Creation mode
    	       $groups_ams_can_view_checkbox = new XoopsFormCheckBox(_AM_AMS_VIEWFORM, 'groups_ams_can_view[]', $full_list);
            }
            $groups_ams_can_view_checkbox->addOptionArray($group_list);
            $form->addElement($groups_ams_can_view_checkbox);
			
			$online = $this->isNew() ? 1 : $this->getVar("online");
			$check_online = new XoopsFormCheckBox(_AM_AMS_ONLINE, "online", $online);
			$check_online->addOption(1, " ");
			$form->addElement($check_online);
			
			$form->addElement(new XoopsFormHidden("op", "save_topics"));
			$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$form->display();
			return $form;
		}		
	}
	
	class amsams_topicsHandler extends XoopsPersistableObjectHandler 
	{
		function __construct(&$db) 
		{
			parent::__construct($db, "ams_topics", "ams_topics", "topic_id", "topic_pid");
		}
	}	
?>