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
 
include "admin_header.php";
xoops_cp_header();
global $xoopsModuleConfig, $pathImageIcon;

//On recupere la valeur de l argument op dans l URL$
$op = ams_CleanVars($_REQUEST, 'op', 'view_setting', 'string');

// compte le nombre de téléchargement non validé
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', 0));
$setting_waiting = $settingHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');

switch ($op) {
default:
    case "view_setting":
            $setting_admin = new ModuleAdmin();
            echo $setting_admin->addNavigation('setting.php');	
			
			//load AMS SEO setting from cache
            $thisSEO = $settingHandler->read_setting();

            $pattern = "/\[XOOPS_URL\]\//";
            $rep_pat = "";
            $thisSEO['friendlyurl_template'] = preg_replace($pattern, $rep_pat, $thisSEO['friendlyurl_template']);
			
		    $obj = $settingHandler->get(isset($_REQUEST["settingid"]));						
		    $form = $obj->getForm();
				
        break;
	
	case "save_setting":       			
		//if process form submitted
        if (isset($_POST['submit']))
        {
           ams_updateCache();
	       $myts =& MyTextSanitizer::getInstance();
	       $seo_is_Enable=intval($_POST['friendlyurl_enable']);
	       $seo_url_Template='[XOOPS_URL]/'.$myts->htmlSpecialChars($_POST['friendlyurl_template']);
	
	       //Save setting into cache
	       $thisSEO = $settingHandler->save_setting(array('friendlyurl_enable' => $seo_is_Enable, 'friendlyurl_template'=>$seo_url_Template));
		   redirect_header("setting.php", 3, _AM_AMS_FORMDELOK);
        } else {
           return false; //return false if friendlyurl is disabled
        }	

        $obj =& $settingHandler->get($_REQUEST['settingid']);	
        $obj->setVar('settingvalue', $_POST['settingvalue']);
		$settingenable = ($_REQUEST["settingenable"] == 1) ? "1" : "0";
        $obj->setVar('settingenable', $settingenable);	
        
        if ($settingHandler->insert($obj)) {
           redirect_header("setting.php?op=view_setting", 3, _AM_AMS_FORMDELOK);
        }
        
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();		
				
        break;
	
	case "delete_setting":
		$obj =& $settingHandler->get($_REQUEST["settingid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("setting.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($settingHandler->delete($obj)) {
				redirect_header("setting.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "settingid" => $_REQUEST["settingid"], "op" => "delete_setting"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("setting")));
		}
	break;
	
	case "update_setting":
		
	if (isset($_REQUEST["settingid"])) {
		$obj =& $settingHandler->get($_REQUEST["settingid"]);
	} 
	$obj->setVar("setting_enable", $_REQUEST["setting_enable"]);

	if ($settingHandler->insert($obj)) {
		redirect_header("setting.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
xoops_cp_footer();

?>