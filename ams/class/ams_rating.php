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

	class ams_rating extends XoopsObject
	{ 
		//Constructor
		function __construct()
		{
			$this->XoopsObject();
			$this->initVar("ratingid",XOBJ_DTYPE_INT,null,false,11);
			$this->initVar("storyid",XOBJ_DTYPE_INT,null,false,11);
			$this->initVar("ratinguser",XOBJ_DTYPE_INT,null,false,11);
			$this->initVar("rating",XOBJ_DTYPE_INT,null,false,5);
			$this->initVar("ratinghostname",XOBJ_DTYPE_TXTBOX,null,false);
			$this->initVar("ratingtimestamp",XOBJ_DTYPE_INT,null,false,10);
			
			// Pour autoriser le html
			$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
			
		}

		function ams_rating()
		{
			$this->__construct();
		}
	
		function getForm($action = false)
		{
			global $xoopsDB, $xoopsModuleConfig;
		
			if ($action === false) {
				$action = $_SERVER["REQUEST_URI"];
			}
		
			$title = $this->isNew() ? sprintf(_AM_AMS_RATING_ADD) : sprintf(_AM_AMS_RATING_EDIT);

			include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

			$form = new XoopsThemeForm($title, "form", $action, "post", true);
			$form->setExtra('enctype="multipart/form-data"');
			
			
			$XoopsFormTablesHandler =& xoops_getModuleHandler("ams_XoopsFormTables", "ams");
			$XoopsFormTables_select = new XoopsFormSelect(_AM_AMS_STORYID, "storyid", $this->getVar("storyid"));
			$XoopsFormTables_select->addOptionArray($XoopsFormTablesHandler->getList());
			$form->addElement($XoopsFormTables_select, true);
			$form->addElement(new XoopsFormSelectUser(_AM_AMS_RATINGUSER, "ratinguser", false, $this->getVar("ratinguser"), 1, false), true);
			
			$NullHandler =& xoops_getModuleHandler("ams_Null", "ams");
			$Null_select = new XoopsFormSelect(_AM_AMS_RATING, "rating", $this->getVar("rating"));
			$Null_select->addOptionArray($NullHandler->getList());
			$form->addElement($Null_select, false);
			$form->addElement(new XoopsFormText(_AM_AMS_RATINGHOSTNAME, "ratinghostname", 50, 255, $this->getVar("ratinghostname")), true);
			$form->addElement(new XoopsFormTextDateSelect(_AM_AMS_RATINGTIMESTAMP, "ratingtimestamp", "", $this->getVar("ratingtimestamp")));
			
			$form->addElement(new XoopsFormHidden("op", "save_rating"));
			$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$form->display();
			return $form;
		}
	}
	class amsams_ratingHandler extends XoopsPersistableObjectHandler 
	{

		function __construct(&$db) 
		{
			parent::__construct($db, "ams_rating", "ams_rating", "rating_id", "storyid");
		}

	}
	
?>