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
$audience_waiting = $audienceHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');


switch ($op) {
default:
        case "list_audience":
            $audience_admin = new ModuleAdmin();
            echo $audience_admin->addNavigation('audience.php');
            if ($status_menu == 1){
                $audience_admin->addItemButton(_AM_AMS_AUDIENCE_NEW, 'audience.php?op=new_audience', 'add');                
            }else{
                $audience_admin->addItemButton(_AM_AMS_AUDIENCE_LIST, 'audience.php?op=list_audience', 'list');
                $audience_admin->addItemButton(_AM_AMS_AUDIENCE_NEW, 'audience.php?op=new_audience', 'add');
            }
            echo $audience_admin->renderButton();
		    $criteria = new CriteriaCompo();
		    $criteria->setSort("audienceid");
		    $criteria->setOrder("ASC");
		    $numrows = $audienceHandler->getCount();
		    $audience_arr = $audienceHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_AUDIENCE_ID."</th>
						<th align=\"center\">"._AM_AMS_AUDIENCE."</th>
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($audience_arr) as $i) 
				{	
					if ( $audience_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
					echo "<td align=\"center\">".$audience_arr[$i]->getVar("audienceid")."</td>";
                    echo "<td align=\"center\">".$audience_arr[$i]->getVar("audience")."</td>";					
					//$online = $audience_arr[$i]->getVar("audience");
				
					/*if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./audience.php?op=update_online_audience&audienceid=".$audience_arr[$i]->getVar("audienceid")."&audience_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./audience.php?op=update_online_audience&audienceid=".$audience_arr[$i]->getVar("audienceid")."&audience_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}*/
					echo "<td align=\"center\" width=\"10%\">
					    	<a href=\"audience.php?op=edit_audience&audienceid=".$audience_arr[$i]->getVar("audienceid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
							<a href=\"audience.php?op=delete_audience&audienceid=".$audience_arr[$i]->getVar("audienceid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
							  </td>";
					echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $audienceHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_audience":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("audience.php");
        $member_admin->addItemButton(_AM_AMS_AUDIENCE_LIST, 'audience.php?op=list_audience', 'list');

        echo $member_admin->renderButton();

    $obj =& $audienceHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_audience":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("audience.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["audienceid"])) {
           $obj =& $audienceHandler->get($_REQUEST["audienceid"]);
        } else {
           $obj =& $audienceHandler->create();
        }
		
		//Form audience
		$obj->setVar("audience", $_REQUEST["audience"]);
		
		
        if ($audienceHandler->insert($obj)) {
           redirect_header("audience.php?op=show_list_audience", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_audience":
		$obj = $audienceHandler->get($_REQUEST["audienceid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_audience":
		$obj =& $audienceHandler->get($_REQUEST["audienceid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("audience.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($audienceHandler->delete($obj)) {
				redirect_header("audience.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "audienceid" => $_REQUEST["audienceid"], "op" => "delete_audience"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("audience")));
		}
	break;
	
	case "update_online_audience":
		
	if (isset($_REQUEST["audienceid"])) {
		$obj =& $audienceHandler->get($_REQUEST["audienceid"]);
	} 
	$obj->setVar("audience_online", $_REQUEST["audience_online"]);

	if ($audienceHandler->insert($obj)) {
		redirect_header("audience.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
include "admin_footer.php";

?>