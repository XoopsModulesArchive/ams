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
$spotlight_waiting = $spotlightHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');


switch ($op) {
default:
        case "list_spotlight":
            $spotlight_admin = new ModuleAdmin();
            echo $spotlight_admin->addNavigation('spotlight.php');
            if ($status_menu == 1){
                $spotlight_admin->addItemButton(_AM_AMS_SPOTLIGHT_NEW, 'spotlight.php?op=new_spotlight', 'add');                
            }else{
                $spotlight_admin->addItemButton(_AM_AMS_SPOTLIGHT_LIST, 'spotlight.php?op=list_spotlight', 'list');
                $spotlight_admin->addItemButton(_AM_AMS_SPOTLIGHT_NEW, 'spotlight.php?op=new_spotlight', 'add');
            }
            echo $spotlight_admin->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("spotlightid");
		$criteria->setOrder("ASC");
		$numrows = $spotlightHandler->getCount();
		$spotlight_arr = $spotlightHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_TOPICID."</th>
						<th align=\"center\">"._AM_AMS_STORYID."</th>						
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_TOPICIMAGE."</th>
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_TEASER."</th>
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_AUTOTEASER."</th>
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_MAXLENGTH."</th>
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_DISPLAY."</th>
						<th align=\"center\">"._AM_AMS_SPOTLIGHT_MODE_SELECT."</th>					
						<th align=\"center\">"._AM_AMS_WEIGHT."</th>
						<th align=\"center\">"._AM_AMS_ONLINE."</th>
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($spotlight_arr) as $i) 
				{	
					if ( $spotlight_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
					
                    echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("topicid")."</td>";	
					echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("storyid")."</td>";					
					
					echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("image")."</td>";	
					echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("teaser")."</td>";	
					
					$verif_autoteaser = ( $spotlight_arr[$i]->getVar("autoteaser") == 1 ) ? _YES : _NO;
					echo "<td align=\"center\">".$verif_autoteaser."</td>";	
					echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("maxlength")."</td>";	
					
					$verif_display = ( $spotlight_arr[$i]->getVar("display") == 1 ) ? _YES : _NO;
					echo "<td align=\"center\">".$verif_display."</td>";	
					
					$verif_mode = ( $spotlight_arr[$i]->getVar("mode") == 1 ) ? _YES : _NO;
					echo "<td align=\"center\">".$verif_mode."</td>";	
					echo "<td align=\"center\">".$spotlight_arr[$i]->getVar("weight")."</td>";
					$online = $spotlight_arr[$i]->getVar("online");
				
					if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./spotlight.php?op=update_online_spotlight&spotlightid=".$spotlight_arr[$i]->getVar("spotlightid")."&spotlight_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./spotlight.php?op=update_online_spotlight&spotlightid=".$spotlight_arr[$i]->getVar("spotlightid")."&spotlight_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
									echo "<td align=\"center\" width=\"10%\">
										<a href=\"spotlight.php?op=edit_spotlight&spotlightid=".$spotlight_arr[$i]->getVar("spotlightid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
										<a href=\"spotlight.php?op=delete_spotlight&spotlightid=".$spotlight_arr[$i]->getVar("spotlightid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
									  </td>";
						echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $spotlightHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_spotlight":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("spotlight.php");
        $member_admin->addItemButton(_AM_AMS_SPOTLIGHT_LIST, 'spotlight.php?op=list_spotlight', 'list');

        echo $member_admin->renderButton();

    $obj =& $spotlightHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_spotlight":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("spotlight.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["spotlightid"])) {
           $obj =& $spotlightHandler->get($_REQUEST["spotlightid"]);
        } else {
           $obj =& $spotlightHandler->create();
        }
		
		//Form showimage
		$verif_showimage = ($_REQUEST["showimage"] == 1) ? "1" : "0";
		$obj->setVar("showimage", $verif_showimage);
		//Form image
		$obj->setVar("image", $_REQUEST["image"]);
		//Form teaser
		$obj->setVar("teaser", $_REQUEST["teaser"]);
		//Form autoteaser
		$verif_autoteaser = ($_REQUEST["autoteaser"] == 1) ? "1" : "0";
		$obj->setVar("autoteaser", $verif_autoteaser);
		//Form maxlength
		$obj->setVar("maxlength", $_REQUEST["maxlength"]);
		//Form display
		$verif_display = ($_REQUEST["display"] == 1) ? "1" : "0";
		$obj->setVar("display", $verif_display);
		//Form mode
		$verif_mode = ($_REQUEST["mode"] == 1) ? "1" : "0";
		$obj->setVar("mode", $verif_mode);
		//Form storyid
		$obj->setVar("storyid", $_REQUEST["storyid"]);
		//Form topicid
		$obj->setVar("topicid", $_REQUEST["topicid"]);
		//Form weight
		$obj->setVar("weight", $_REQUEST["weight"]);
		
		
        if ($spotlightHandler->insert($obj)) {
           redirect_header("spotlight.php?op=show_list_spotlight", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_spotlight":
		$obj = $spotlightHandler->get($_REQUEST["spotlightid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_spotlight":
		$obj =& $spotlightHandler->get($_REQUEST["spotlightid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("spotlight.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($spotlightHandler->delete($obj)) {
				redirect_header("spotlight.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "spotlightid" => $_REQUEST["spotlightid"], "op" => "delete_spotlight"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("spotlight")));
		}
	break;
	
	case "update_online_spotlight":
		
	if (isset($_REQUEST["spotlightid"])) {
		$obj =& $spotlightHandler->get($_REQUEST["spotlightid"]);
	} 
	$obj->setVar("spotlight_online", $_REQUEST["spotlight_online"]);

	if ($spotlightHandler->insert($obj)) {
		redirect_header("spotlight.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
xoops_cp_footer();

?>