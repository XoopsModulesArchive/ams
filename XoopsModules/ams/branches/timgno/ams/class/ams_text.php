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
		include_once XOOPS_ROOT_PATH."/modules/ams/class/object.php";
	}

	class ams_text extends XoopsObject
	{ 
		//Constructor
		function __construct()
		{
			$this->XoopsObject();
			$this->initVar("storyid",XOBJ_DTYPE_INT,null,false,8);
			$this->initVar("version",XOBJ_DTYPE_INT,null,false,8);
			$this->initVar("revision",XOBJ_DTYPE_INT,null,false,8);
			$this->initVar("revisionminor",XOBJ_DTYPE_INT,null,false,8);
			$this->initVar("uid",XOBJ_DTYPE_INT,null,false,5);
			 $this->initVar("hometext",XOBJ_DTYPE_TXTAREA, null, false);
			 $this->initVar("bodytext",XOBJ_DTYPE_TXTAREA, null, false);
			$this->initVar("current",XOBJ_DTYPE_INT,null,false,2);
			$this->initVar("updated",XOBJ_DTYPE_INT,null,false,10);
			
			// Pour autoriser le html
			$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
			
		}

		function ams_text()
		{
			$this->__construct();
		}
	
		function getForm($action = false)
		{
			global $xoopsDB, $xoopsModuleConfig;
		
			if ($action === false) {
				$action = $_SERVER["REQUEST_URI"];
			}
		
			$title = $this->isNew() ? sprintf(_AM_AMS_TEXT_ADD) : sprintf(_AM_AMS_TEXT_EDIT);

			include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

			$form = new XoopsThemeForm($title, "form", $action, "post", true);
			$form->setExtra('enctype="multipart/form-data"');
			
			$form->addElement(new XoopsFormText(_AM_AMS_VERSION, "version", 50, 255, $this->getVar("version")), true);
			$form->addElement(new XoopsFormText(_AM_AMS_REVISION, "revision", 50, 255, $this->getVar("revision")), true);
			$form->addElement(new XoopsFormText(_AM_AMS_REVISIONMINOR, "revisionminor", 50, 255, $this->getVar("revisionminor")), true);
			$form->addElement(new XoopsFormSelectUser(_AM_AMS_UID, "uid", false, $this->getVar("uid"), 1, false), true);
			$editor_configs=array();
			$editor_configs["name"] ="hometext";
			$editor_configs["value"] = $this->getVar("hometext", "e");
			$editor_configs["rows"] = 20;
			$editor_configs["cols"] = 80;
			$editor_configs["width"] = "100%";
			$editor_configs["height"] = "400px";
			$editor_configs["editor"] = $xoopsModuleConfig["ams_editor"];				
			$form->addElement( new XoopsFormEditor(_AM_AMS_HOMETEXT, "hometext", $editor_configs), true );
			$editor_configs=array();
			$editor_configs["name"] ="bodytext";
			$editor_configs["value"] = $this->getVar("bodytext", "e");
			$editor_configs["rows"] = 20;
			$editor_configs["cols"] = 80;
			$editor_configs["width"] = "100%";
			$editor_configs["height"] = "400px";
			$editor_configs["editor"] = $xoopsModuleConfig["ams_editor"];				
			$form->addElement( new XoopsFormEditor(_AM_AMS_BODYTEXT, "bodytext", $editor_configs), true );
			
			$XoopsFormTablesHandler =& xoops_getModuleHandler("ams_XoopsFormTables", "ams");
			$XoopsFormTables_select = new XoopsFormSelect(_AM_AMS_CURRENT, "current", $this->getVar("current"));
			$XoopsFormTables_select->addOptionArray($XoopsFormTablesHandler->getList());
			$form->addElement($XoopsFormTables_select, true);
			$form->addElement(new XoopsFormTextDateSelect(_AM_AMS_UPDATED, "updated", "", $this->getVar("updated")));
			
			$form->addElement(new XoopsFormHidden("op", "save_text"));
			$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$form->display();
			return $form;
		}
	}
	class amsams_textHandler extends XoopsPersistableObjectHandler 
	{

		function __construct(&$db) 
		{
			parent::__construct($db, "ams_text", "ams_text", "text_id", "version");
		}

	}
	
?>