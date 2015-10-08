<?php   
/**
 * ****************************************************************************
 *       - Original Copyright (TDM)
 *       - TDMCreate By TDM - TEAM DEV MODULE FOR XOOPS
 *       - Licence GPL Copyright (c) (http://www.tdmxoops.net)
 *       - Developers TEAM TDMCreate Xoops - (http://www.xoops.org)
 * ****************************************************************************
 *       ams - MODULE FOR XOOPS
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

class ams_setting extends XoopsObject
{ 
	//Constructor
	function __construct()
	{
		$this->XoopsObject();
		$this->initVar("settingid",XOBJ_DTYPE_INT,null,false,11);
		$this->initVar("settingvalue",XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("settingtype",XOBJ_DTYPE_TXTBOX,null,false);
	}

	function ams_setting()
	{
		$this->__construct();
	}

	function getForm($action = false)
	{
		global $xoopsDB, $xoopsModuleConfig;
	
		if ($action === false) {
			$action = $_SERVER["REQUEST_URI"];
		}
	
		$title = $this->isNew() ? sprintf(_AM_AMS_SETTING_ADD) : sprintf(_AM_AMS_SETTING_EDIT);

		include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

		$form = new XoopsThemeForm($title, "form", $action, "post", true);
		$form->setExtra('enctype="multipart/form-data"');
		
		$form->addElement(new XoopsFormRadioYN(_AM_AMS_SETTINGTYPE, "settingenable", $this->getVar("settingenable"), _YES, _NO), false);
		$form->addElement(new XoopsFormText(_AM_AMS_SETTINGVALUE, "settingvalue", 80, 255, $this->getVar("settingvalue")), true);		
		
		$form->addElement(new XoopsFormHidden("friendlyurl_enable", "settingtype"));
		$form->addElement(new XoopsFormHidden("friendlyurl_template", "settingtype"));
		$form->addElement(new XoopsFormHidden("op", "save_setting"));
		$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
		$form->display();
		return $form;
	}
}
class amsams_settingHandler extends XoopsPersistableObjectHandler 
{

	function __construct(&$db) 
	{
		parent::__construct($db, "ams_setting", "ams_setting", "settingid", "settingvalue");
	}
	
	private function readDb($setting_type) 
	{

		$myts =& MyTextSanitizer::getInstance();
		$sql = "SELECT settingvalue FROM ".$this->db->prefix('ams_setting')." WHERE settingtype='".$setting_type."'";

		$result=$this->db->query($sql,1,0);
		$row=$this->db->fetchRow($result);
		return $row;
	}

	private function updateDb($setting_type, $setting_value) 
	{
		$myts =& MyTextSanitizer::getInstance();
		$sql = "UPDATE ".$this->db->prefix('ams_setting')." SET settingvalue='".$setting_value."' WHERE settingtype='".$setting_type."'";
		if (!$this->db->query($sql)) {    
			return false;
		}
		return true;
	}

	
	function save_setting($content_parameter=null) 
	{
		//configure setting path based on XOOPS version
		include_once XOOPS_ROOT_PATH."/mainfile.php";
		if ( !defined("XOOPS_VAR_PATH") )
		{
			$ams_setting=XOOPS_ROOT_PATH. '/cache';
		} else {
			$ams_setting=XOOPS_VAR_PATH. '/configs';
		}
	
		//if nothing inside the content, fill it with default value
		if (!(is_array($content_parameter) && count($content_parameter) > 0)) 
		{
			$temp_holder=$this->readDb('friendlyurl_enable');
			$content_parameter['friendlyurl_enable']=$temp_holder[0];
		
			$temp_holder=$this->readDb('friendlyurl_template');
			$content_parameter['urltemplate']=$temp_holder[0];
		} else {
			$this->updateDb('friendlyurl_enable',$content_parameter['friendlyurl_enable']);
			$this->updateDb('friendlyurl_template',$content_parameter['urltemplate']);
		}
	
		if ( !$file = fopen( $ams_setting . '/xoops_ams_seo_setting.php', "w" ) )
		{
			print "FAIL WRITING SEO SETTING CACHE";exit;
		} else {
			$content= "<?php
			function ams_seo_setting()
			{
			   \$setting['friendlyurl_enable']=" .$content_parameter['friendlyurl_enable']. ";
			   \$setting['friendlyurl_template']='" .$content_parameter['friendlyurl_template']. "';
			   return \$setting;
			}
			?>";
	
			if ( fwrite( $file, $content ) == -1 )
			{
				print "FAIL WRITING SEO SETTING CACHE";exit;
			}
			fclose($file);
		}				
	}

	function read_setting() 
	{
		include_once XOOPS_ROOT_PATH."/mainfile.php";
	
		//configure setting path based on XOOPS version
		if ( !defined("XOOPS_VAR_PATH") )
		{
		   $ams_setting=XOOPS_ROOT_PATH. '/cache';
		} else {
		   $ams_setting=XOOPS_VAR_PATH. '/configs';
		}		

		if(!file_exists( $ams_setting . '/xoops_ams_seo_setting.php')) //if  1st time running
		{
		   $this->save_setting();
		}

		include_once $ams_setting . '/xoops_ams_seo_setting.php';
		return ams_seo_setting();
	}
}	
?>