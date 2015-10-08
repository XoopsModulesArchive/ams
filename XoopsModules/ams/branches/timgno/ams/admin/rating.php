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
$rating_waiting = $ratingHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');


switch ($op) {
default:
        case "list_rating":
            $rating_admin = new ModuleAdmin();
            echo $rating_admin->addNavigation('rating.php');
            if ($status_menu == 1){
                $rating_admin->addItemButton(_AM_AMS_NEWRECORD, 'rating.php?op=new_rating', 'add');
                if ($rating_waiting == 0){
                    $rating_admin->addItemButton(_AM_AMS_WAIT, 'rating.php?op=list&status_display=0', 'add');
                }else{
                    $rating_admin->addItemButton(_AM_AMS_WAIT, 'rating.php?op=list&status_display=0', 'add', ' (<span style="color : Red">rating_waiting . </span>)');
                }
            }else{
                $rating_admin->addItemButton(_AM_AMS_LIST, 'rating.php?op=list_rating', 'list');
                $rating_admin->addItemButton(_AM_AMS_NEWRECORD, 'rating.php?op=new_rating', 'add');
            }
            echo $rating_admin->renderButton();
		    $criteria = new CriteriaCompo();
		    $criteria->setSort("ratingid");
		    $criteria->setOrder("ASC");
		    $numrows = $ratingHandler->getCount();
		    $rating_arr = $ratingHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_STORYID."</th>
						<th align=\"center\">"._AM_AMS_RATINGUSER."</th>
						<th align=\"center\">"._AM_AMS_RATING."</th>
						<th align=\"center\">"._AM_AMS_RATINGHOSTNAME."</th>
						<th align=\"center\">"._AM_AMS_RATINGTIMESTAMP."</th>
						
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($rating_arr) as $i) 
				{	
					if ( $rating_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
						echo "<td align=\"center\">".XoopsUser::getUnameFromId($rating_arr[$i]->getVar("ratinguser"),"S")."</td>";	
					echo "<td align=\"center\">".$rating_arr[$i]->getVar("ratinghostname")."</td>";	
					
					$online = $rating_arr[$i]->getVar("ratingtimestamp");
				
					if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./rating.php?op=update_online_rating&ratingid=".$rating_arr[$i]->getVar("ratingid")."&rating_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./rating.php?op=update_online_rating&ratingid=".$rating_arr[$i]->getVar("ratingid")."&rating_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
									echo "<td align=\"center\" width=\"10%\">
										<a href=\"rating.php?op=edit_rating&ratingid=".$rating_arr[$i]->getVar("ratingid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
										<a href=\"rating.php?op=delete_rating&ratingid=".$rating_arr[$i]->getVar("ratingid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
									  </td>";
						echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $ratingHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_rating":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("rating.php");
        $member_admin->addItemButton(_AM_TEST1_LIST, 'rating.php?op=list_rating', 'list');

        echo $member_admin->renderButton();

    $obj =& $ratingHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_rating":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("rating.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["ratingid"])) {
           $obj =& $ratingHandler->get($_REQUEST["ratingid"]);
        } else {
           $obj =& $ratingHandler->create();
        }
		
		//Form storyid
		$obj->setVar("storyid", $_REQUEST["storyid"]);
		//Form ratinguser
		$obj->setVar("ratinguser", $_REQUEST["ratinguser"]);
		//Form rating
		$obj->setVar("rating", $_REQUEST["rating"]);
		//Form ratinghostname
		$obj->setVar("ratinghostname", $_REQUEST["ratinghostname"]);
		//Form ratingtimestamp
		$obj->setVar("ratingtimestamp", strtotime($_REQUEST["ratingtimestamp"]));
		
		
        if ($ratingHandler->insert($obj)) {
           redirect_header("rating.php?op=list_rating", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_rating":
		$obj = $ratingHandler->get($_REQUEST["ratingid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_rating":
		$obj =& $ratingHandler->get($_REQUEST["ratingid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("rating.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($ratingHandler->delete($obj)) {
				redirect_header("rating.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "ratingid" => $_REQUEST["ratingid"], "op" => "delete_rating"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("rating")));
		}
	break;
	
	case "update_online_rating":
		
	if (isset($_REQUEST["ratingid"])) {
		$obj =& $ratingHandler->get($_REQUEST["ratingid"]);
	} 
	$obj->setVar("rating_online", $_REQUEST["rating_online"]);

	if ($ratingHandler->insert($obj)) {
		redirect_header("rating.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
include "admin_footer.php";

?>