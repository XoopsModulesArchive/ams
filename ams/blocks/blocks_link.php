<?php   
/**
 * ****************************************************************************
 *  - Original Copyright (TDM)
 *  - TDMCreate By TDM - TEAM DEV MODULE FOR XOOPS
 *  - Licence GPL Copyright (c) (http://www.tdmxoops.net)
 *  - Developers TEAM TDMCreate Xoops - (http://www.xoops.org)
 *  - Revision By TXMod Xoops (http://www.txmodxoops.org)
 * ****************************************************************************
 *  AMS - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  TXMod Xoops (http://www.txmodxoops.org)
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
 *  ---------------------------------------------------------------------------
 *  @copyright       TXMod Xoops (http://www.txmodxoops.org)
 *  @license         GPL see LICENSE
 *  @package         ams
 *  @author          TXMod Xoops (info@txmodxoops.org)
 *
 *  Version : 3.01 Sat 2012/01/14 6:36:53 : Timgno Exp $
 * ****************************************************************************
 */
 	
include_once XOOPS_ROOT_PATH."/modules/ams/include/functions.php";
	
function b_ams_link($options) {
include_once XOOPS_ROOT_PATH."/modules/ams/class/link.php";
$myts =& MyTextSanitizer::getInstance();

$link = array();
$type_block = $options[0];
$nb_link = $options[1];
$lenght_title = $options[2];

$linkHandler =& xoops_getModuleHandler("ams_link", "ams");
$criteria = new CriteriaCompo();
array_shift($options);
array_shift($options);
array_shift($options);

switch ($type_block) 
{
	// for the recents: link block
	case "recent":
		$criteria->add(new Criteria("link_online", 1));
		$criteria->setSort("link_created");
		$criteria->setOrder("DESC");
	break;
	// for the today: link block 
	case "day":	
		$criteria->add(new Criteria("link_online", 1));
		$criteria->add(new Criteria("link_created", strtotime(date("Y/m/d")), ">="));
		$criteria->add(new Criteria("link_created", strtotime(date("Y/m/d"))+86400, "<="));
		$criteria->setSort("link_created");
		$criteria->setOrder("ASC");
	break;
	// for the random: link block
	case "random":
		$criteria->add(new Criteria("link_online", 1));
		$criteria->setSort("RAND()");
	break;
}


$criteria->setLimit($nb_link);
$link_arr = $linkHandler->getall($criteria);
	foreach (array_keys($link_arr) as $i) 
	{
		$link[$i]["link_id"] = $link_arr[$i]->getVar("link_id");
		
	}
return $link;
}

function b_ams_link_edit($options) {
	$form = ""._MB_AMS_LINK_DISPLAY."\n";
	$form .= "<input type=\"hidden\" name=\"options[0]\" value=\"".$options[0]."\" />";
	$form .= "<input name=\"options[1]\" size=\"5\" maxlength=\"255\" value=\"".$options[1]."\" type=\"text\" />&nbsp;<br />";
	$form .= ""._MB_AMS_LINK_TITLELENGTH." : <input name=\"options[2]\" size=\"5\" maxlength=\"255\" value=\"".$options[2]."\" type=\"text\" /><br /><br />";
	array_shift($options);
	array_shift($options);
	array_shift($options);
	$form .= ""._MB_AMS_LINK_CATTODISPLAY."<br /><select name=\"options[]\" multiple=\"multiple\" size=\"5\">";
	$form .= "<option value=\"0\" " . (array_search(0, $options) === false ? "" : "selected=\"selected\"") . ">" ._MB_AMS_LINK_ALLCAT . "</option>";
	foreach (array_keys($topic_arr) as $i) {
		$form .= "<option value=\"" . $topic_arr[$i]->getVar("topic_id") . "\" " . (array_search($topic_arr[$i]->getVar("topic_id"), $options) === false ? "" : "selected=\"selected\"") . ">".$topic_arr[$i]->getVar("topic_title")."</option>";
	}
	$form .= "</select>";

	return $form;
}
	
?>