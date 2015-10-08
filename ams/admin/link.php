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
include_once "../include/functions.php";
xoops_cp_header();
global $xoopsModuleConfig, $pathImageIcon;

//On recupere la valeur de l argument op dans l URL$
$op = ams_CleanVars($_REQUEST, 'op', 'list', 'string');

// compte le nombre de téléchargement non validé
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', 0));
$link_waiting = $linkHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');


switch ($op) {
default:
        case "list_link":
            $link_admin = new ModuleAdmin();
            echo $link_admin->addNavigation('link.php');
            if ($status_menu == 1){
                $link_admin->addItemButton(_AM_AMS_NEWRECORD, 'link.php?op=new_link', 'add');
                if ($link_waiting == 0){
                    $link_admin->addItemButton(_AM_AMS_WAIT, 'link.php?op=list&status_display=0', 'add');
                }else{
                    $link_admin->addItemButton(_AM_AMS_WAIT, 'link.php?op=list&status_display=0', 'add', ' (<span style="color : Red">link_waiting . </span>)');
                }
            }else{
                $link_admin->addItemButton(_AM_AMS_LIST, 'link.php?op=list_link', 'list');
                $link_admin->addItemButton(_AM_AMS_NEWRECORD, 'link.php?op=new_link', 'add');
            }
            echo $link_admin->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("linkid");
		$criteria->setOrder("ASC");
		$numrows = $linkHandler->getCount();
		$link_arr = $linkHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_STORYID."</th>
						<th align=\"center\">"._AM_AMS_LINK_MODULE."</th>
						<th align=\"center\">"._AM_AMS_LINK_LINK."</th>
						<th align=\"center\">"._AM_AMS_LINK_TITLE."</th>
						<th align=\"center\">"._AM_AMS_LINK_COUNTER."</th>
						<th align=\"center\">"._AM_AMS_LINK_POSITION."</th>
						
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($link_arr) as $i) 
				{	
					if ( $link_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
						echo "<td align=\"center\">".$link_arr[$i]->getVar("link_module")."</td>";	
					echo "<td align=\"center\">".$link_arr[$i]->getVar("link_link")."</td>";	
					echo "<td align=\"center\">".$link_arr[$i]->getVar("link_title")."</td>";	
					
					$online = $link_arr[$i]->getVar("link_position");
				
					if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./link.php?op=update_online_link&linkid=".$link_arr[$i]->getVar("linkid")."&link_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./link.php?op=update_online_link&linkid=".$link_arr[$i]->getVar("linkid")."&link_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
									echo "<td align=\"center\" width=\"10%\">
										<a href=\"link.php?op=edit_link&linkid=".$link_arr[$i]->getVar("linkid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
										<a href=\"link.php?op=delete_link&linkid=".$link_arr[$i]->getVar("linkid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
									  </td>";
						echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $linkHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_link":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("link.php");
        $member_admin->addItemButton(_AM_TEST1_LIST, 'link.php?op=list_link', 'list');

        echo $member_admin->renderButton();

    $obj =& $linkHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_link":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("link.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["linkid"])) {
           $obj =& $linkHandler->get($_REQUEST["linkid"]);
        } else {
           $obj =& $linkHandler->create();
        }
		
		//Form storyid
		$obj->setVar("storyid", $_REQUEST["storyid"]);
		//Form link_module
		$obj->setVar("link_module", $_REQUEST["link_module"]);
		//Form link_link
		$obj->setVar("link_link", $_REQUEST["link_link"]);
		//Form link_title
		$obj->setVar("link_title", $_REQUEST["link_title"]);
		//Form link_counter
		$obj->setVar("link_counter", $_REQUEST["link_counter"]);
		//Form link_position
		$obj->setVar("link_position", $_REQUEST["link_position"]);
		
		
        if ($linkHandler->insert($obj)) {
           redirect_header("link.php?op=show_list_link", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_link":
		$obj = $linkHandler->get($_REQUEST["linkid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_link":
		$obj =& $linkHandler->get($_REQUEST["linkid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("link.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($linkHandler->delete($obj)) {
				redirect_header("link.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "linkid" => $_REQUEST["linkid"], "op" => "delete_link"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("link")));
		}
	break;
	
	case "update_online_link":
		
	if (isset($_REQUEST["linkid"])) {
		$obj =& $linkHandler->get($_REQUEST["linkid"]);
	} 
	$obj->setVar("link_online", $_REQUEST["link_online"]);

	if ($linkHandler->insert($obj)) {
		redirect_header("link.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
xoops_cp_footer();

?>