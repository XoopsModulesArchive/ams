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
$text_waiting = $textHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');


switch ($op) {
default:
        case "list_text":
            $text_admin = new ModuleAdmin();
            echo $text_admin->addNavigation('text.php');
            if ($status_menu == 1){
                $text_admin->addItemButton(_AM_AMS_NEWRECORD, 'text.php?op=new_text', 'add');
                if ($text_waiting == 0){
                    $text_admin->addItemButton(_AM_AMS_WAIT, 'text.php?op=list&status_display=0', 'add');
                }else{
                    $text_admin->addItemButton(_AM_AMS_WAIT, 'text.php?op=list&status_display=0', 'add', ' (<span style="color : Red">text_waiting . </span>)');
                }
            }else{
                $text_admin->addItemButton(_AM_AMS_LIST, 'text.php?op=list_text', 'list');
                $text_admin->addItemButton(_AM_AMS_NEWRECORD, 'text.php?op=new_text', 'add');
            }
            echo $text_admin->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("storyid");
		$criteria->setOrder("ASC");
		$numrows = $textHandler->getCount();
		$text_arr = $textHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_VERSION."</th>
						<th align=\"center\">"._AM_AMS_REVISION."</th>
						<th align=\"center\">"._AM_AMS_REVISIONMINOR."</th>
						<th align=\"center\">"._AM_AMS_UID."</th>
						<th align=\"center\">"._AM_AMS_HOMETEXT."</th>
						<th align=\"center\">"._AM_AMS_BODYTEXT."</th>
						<th align=\"center\">"._AM_AMS_CURRENT."</th>
						<th align=\"center\">"._AM_AMS_UPDATED."</th>
						
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($text_arr) as $i) 
				{	
					if ( $text_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
						echo "<td align=\"center\">".$text_arr[$i]->getVar("version")."</td>";	
					echo "<td align=\"center\">".$text_arr[$i]->getVar("revision")."</td>";	
					echo "<td align=\"center\">".$text_arr[$i]->getVar("revisionminor")."</td>";	
					echo "<td align=\"center\">".XoopsUser::getUnameFromId($text_arr[$i]->getVar("uid"),"S")."</td>";	
					echo "<td align=\"center\">".$text_arr[$i]->getVar("hometext")."</td>";	
					echo "<td align=\"center\">".$text_arr[$i]->getVar("bodytext")."</td>";	
					
					$online = $text_arr[$i]->getVar("updated");
				
					if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./text.php?op=update_online_text&storyid=".$text_arr[$i]->getVar("storyid")."&text_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./text.php?op=update_online_text&storyid=".$text_arr[$i]->getVar("storyid")."&text_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
									echo "<td align=\"center\" width=\"10%\">
										<a href=\"text.php?op=edit_text&storyid=".$text_arr[$i]->getVar("storyid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
										<a href=\"text.php?op=delete_text&storyid=".$text_arr[$i]->getVar("storyid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
									  </td>";
						echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $textHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_text":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("text.php");
        $member_admin->addItemButton(_AM_TEST1_LIST, 'text.php?op=list_text', 'list');

        echo $member_admin->renderButton();

    $obj =& $textHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_text":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("text.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["storyid"])) {
           $obj =& $textHandler->get($_REQUEST["storyid"]);
        } else {
           $obj =& $textHandler->create();
        }
		
		//Form version
		$obj->setVar("version", $_REQUEST["version"]);
		//Form revision
		$obj->setVar("revision", $_REQUEST["revision"]);
		//Form revisionminor
		$obj->setVar("revisionminor", $_REQUEST["revisionminor"]);
		//Form uid
		$obj->setVar("uid", $_REQUEST["uid"]);
		//Form hometext
		$obj->setVar("hometext", $_REQUEST["hometext"]);
		//Form bodytext
		$obj->setVar("bodytext", $_REQUEST["bodytext"]);
		//Form current
		$obj->setVar("current", $_REQUEST["current"]);
		//Form updated
		$obj->setVar("updated", strtotime($_REQUEST["updated"]));
		
		
        if ($textHandler->insert($obj)) {
           redirect_header("text.php?op=show_list_text", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_text":
		$obj = $textHandler->get($_REQUEST["storyid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_text":
		$obj =& $textHandler->get($_REQUEST["storyid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("text.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($textHandler->delete($obj)) {
				redirect_header("text.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "storyid" => $_REQUEST["storyid"], "op" => "delete_text"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("text")));
		}
	break;
	
	case "update_online_text":
		
	if (isset($_REQUEST["storyid"])) {
		$obj =& $textHandler->get($_REQUEST["storyid"]);
	} 
	$obj->setVar("text_online", $_REQUEST["text_online"]);

	if ($textHandler->insert($obj)) {
		redirect_header("text.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
xoops_cp_footer();

?>