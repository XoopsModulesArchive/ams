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

	class ams_spotlight extends XoopsObject
	{ 
		//Constructor
		function __construct()
		{
			$this->XoopsObject();
			$this->initVar("spotlightid",XOBJ_DTYPE_INT,null,false,11);
			$this->initVar("showimage",XOBJ_DTYPE_INT,null,false,1);
			$this->initVar("image",XOBJ_DTYPE_TXTBOX,null,false);
			$this->initVar("teaser",XOBJ_DTYPE_TXTAREA, null, false);
			$this->initVar("autoteaser",XOBJ_DTYPE_INT,null,false,1);
			$this->initVar("maxlength",XOBJ_DTYPE_INT,null,false,5);
			$this->initVar("display",XOBJ_DTYPE_INT,null,false,1);
			$this->initVar("mode",XOBJ_DTYPE_INT,null,false,1);
			$this->initVar("storyid",XOBJ_DTYPE_INT,null,false,12);
			$this->initVar("topicid",XOBJ_DTYPE_INT,null,false,12);
			$this->initVar("weight",XOBJ_DTYPE_INT,null,false,5);
			
			// Pour autoriser le html
			$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
			
		}

		function ams_spotlight()
		{
			$this->__construct();
		}
	
		function getForm($action = false)
		{
			global $xoopsDB, $xoopsModuleConfig;
		
			if ($action === false) {
				$action = $_SERVER["REQUEST_URI"];
			}
		
			$title = $this->isNew() ? sprintf(_AM_AMS_SPOTLIGHT_ADD) : sprintf(_AM_AMS_SPOTLIGHT_EDIT);

			include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

			$form = new XoopsThemeForm($title, "form", $action, "post", true);
			$form->setExtra('enctype="multipart/form-data"');
			
			$mode_select = new XoopsFormRadio('', 'mode', $this->getVar('mode'));
            $mode_select->addOption(1, _AM_AMS_SPOTLIGHT_LATESTARTICLE);
            $mode_select->addOption(2, _AM_AMS_SPOTLIGHT_LATESTINTOPIC);
            $mode_select->addOption(3, _AM_AMS_SPOTLIGHT_SPECIFICARTICLE);
            $mode_select->addOption(4, _AM_AMS_SPOTLIGHT_CUSTOM);
			$mode_tray = new XoopsFormElementTray(_AM_AMS_SPOTLIGHT_MODE_SELECT);
            $mode_tray->addElement($mode_select);
			$form->addElement($mode_tray);
			
			// Pour faire une sous-catégorie
            $allTopics_Handler =& xoops_getModuleHandler('ams_topics', 'ams');
            $criteria = new CriteriaCompo();
            $criteria->setSort('weight ASC, topic_title');
            $criteria->setOrder('ASC');
            $allTopics = $allTopics_Handler->getall($criteria);
            $mytree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
            $form->addElement(new XoopsFormLabel(_AM_AMS_TOPIC, $mytree->makeSelBox('topic_pid', 'topic_title','--',$this->getVar('topic_pid'),true)));
			
			// 
            $allArticle_Handler =& xoops_getModuleHandler('ams_article', 'ams');
            $criteria = new CriteriaCompo();
            $criteria->setSort('weight ASC, title');
            $criteria->setOrder('ASC');
            $allArticle = $allArticle_Handler->getall($criteria);
			$article_select = new XoopsFormSelect(_AM_AMS_ARTICLE, 'storyid', $this->getVar('storyid'));
            $mytree = new XoopsObjectTree($allArticle, 'storyid', 'topicid');
            $form->addElement(new XoopsFormLabel(_AM_AMS_ARTICLE, $mytree->makeSelBox('storyid', 'title','--',$this->getVar('topicid'),true)));
			
			$showimage_select = new XoopsFormRadio(_AM_AMS_SPOTLIGHT_SHOWIMAGE, 'showimage', $this->getVar('showimage'));
            $showimage_select->addOption(0, _AM_AMS_SPOTLIGHT_SPECIFYIMAGE);
            $showimage_select->addOption(1, _AM_AMS_SPOTLIGHT_TOPICIMAGE);
            $showimage_select->addOption(2, _AM_AMS_SPOTLIGHT_AUTHORIMAGE);
            $showimage_select->addOption(3, _AM_AMS_SPOTLIGHT_NOIMAGE);
            $showimage_select->setDescription(_AM_AMS_SPOTLIGHT_SHOWIMAGE_DESC);
			$form->addElement($showimage_select); 		
			
			$image_select = new XoopsFormElementTray(_AM_AMS_SPOTLIGHT_IMAGE, '&nbsp;');
		    $image_select->addElement(new XoopsFormText('', 'imagespot', 70, 255, $this->getVar('image', 'e')));
		    $image_select->addElement(new XoopsFormLabel('', "<img onmouseover='style.cursor=\"hand\"' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=imagespot\",\"imgmanager\",400,430);' src='".XOOPS_URL."/images/image.gif' alt='image' />"));
			$form->addElement($image_select);
			
            $form->addElement( new XoopsFormRadioYN(_AM_AMS_SPOTLIGHT_AUTOTEASER, 'autoteaser', $this->getVar('autoteaser')));
			$form->addElement( new XoopsFormText(_AM_AMS_SPOTLIGHT_MAXLENGTH, 'maxlength', 10, 10, $this->getVar('maxlength')));
			$form->addElement( new XoopsFormDhtmlTextArea(_AM_AMS_SPOTLIGHT_TEASER, 'teaser', $this->getVar('teaser', 'e')));          		
			
			$display = $this->isNew() ? 1 : $this->getVar("display");
			$form->addElement(new XoopsFormRadioYN(_AM_AMS_SPOTLIGHT_DISPLAY, "display", $display, _YES, _NO), true);			
			$form->addElement(new XoopsFormText(_AM_AMS_WEIGHT, "weight", 10, 25, $this->getVar("weight")), true);
						
			$form->addElement(new XoopsFormHidden("op", "save_spotlight"));
			$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$form->display();
			return $form;
		}
	}
	
	class amsams_spotlightHandler extends XoopsPersistableObjectHandler 
	{

		function __construct(&$db) 
		{
			parent::__construct($db, "ams_spotlight", "ams_spotlight", "spotlightid", "showimage");
		}

	}
	
?>