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

	class ams_audience extends XoopsObject
	{ 
		//Constructor
		function __construct()
		{
			$this->XoopsObject();
			$this->initVar("audienceid",XOBJ_DTYPE_INT,null,false,11);
			$this->initVar("audience",XOBJ_DTYPE_TXTBOX,null,false);
			
			// Pour autoriser le html
			$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
			
		}

		function ams_audience()
		{
			$this->__construct();
		}
	
		function getForm($action = false)
		{
			global $xoopsDB, $xoopsModuleConfig;
		
			if ($action === false) {
				$action = $_SERVER["REQUEST_URI"];
			}
			
			$id = intval(isset($_REQUEST["audienceid"]));
			if ($id > 0) {
               global $xoopsModule;
               $audience_handler =& xoops_getmodulehandler('audience', 'ams');
               $thisaudience =& $audience_handler->get($id);
               $audience = $thisaudience->getVar('audience');
               $gperm_handler =& xoops_gethandler('groupperm');
               $groups = $gperm_handler->getGroupIds("ams_audience", $id, $xoopsModule->getVar('mid'));
            } else {
               $audience = "";
               $groups = array();
            }
		
			$title = $this->isNew() ? sprintf(_AM_AMS_AUDIENCE_ADD) : sprintf(_AM_AMS_AUDIENCE_EDIT);

			include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

			$form = new XoopsThemeForm($title, "form", $action, "post", true);
			$form->setExtra('enctype="multipart/form-data"');
			
			$form->addElement(new XoopsFormText(_AM_AMS_AUDIENCE, "audience", 50, 255, $this->getVar("audience")), true);
			$form->addElement(new XoopsFormSelectGroup(_AM_AMS_AUDIENCE_ACCESS, 'groups', true, $groups, 5, true), true);
			
			$form->addElement(new XoopsFormHidden("op", "save_audience"));
			$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
			$form->display();
			return $form;
		}
	}
	class amsams_audienceHandler extends XoopsPersistableObjectHandler 
	{

		function __construct(&$db) 
		{
			parent::__construct($db, "ams_audience", "ams_audience", "audienceid", "audience");
		}

	}
	
?>