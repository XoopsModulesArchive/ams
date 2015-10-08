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
$files_waiting = $filesHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');

switch ($op) {
default:
        case "list_files":
            $files_admin = new ModuleAdmin();
            echo $files_admin->addNavigation('files.php');
            if ($status_menu == 1){
                $files_admin->addItemButton(_AM_AMS_NEWRECORD, 'files.php?op=new_files', 'add');
                if ($files_waiting == 0){
                    $files_admin->addItemButton(_AM_AMS_WAIT, 'files.php?op=list&status_display=0', 'add');
                }else{
                    $files_admin->addItemButton(_AM_AMS_WAIT, 'files.php?op=list&status_display=0', 'add', ' (<span style="color : Red">files_waiting . </span>)');
                }
            }else{
                $files_admin->addItemButton(_AM_AMS_LIST, 'files.php?op=list_files', 'list');
                $files_admin->addItemButton(_AM_AMS_NEWRECORD, 'files.php?op=new_files', 'add');
            }
            echo $files_admin->renderButton();
		    $criteria = new CriteriaCompo();
		    $criteria->setSort("fileid");
		    $criteria->setOrder("ASC");
		    $numrows = $filesHandler->getCount();
		    $files_arr = $filesHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_FILEREALNAME."</th>
						<th align=\"center\">"._AM_AMS_STORYID."</th>
						<th align=\"center\">"._AM_AMS_DATE."</th>
						<th align=\"center\">"._AM_AMS_MIMETYPE."</th>
						<th align=\"center\">"._AM_AMS_DOWNLOADNAME."</th>
						<th align=\"center\">"._AM_AMS_COUNTER."</th>
						
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";
				
				foreach (array_keys($files_arr) as $i) 
				{	
					if ( $files_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
						echo "<td align=\"center\">".$files_arr[$i]->getVar("filerealname")."</td>";	
					echo "<td align=\"center\">".formatTimeStamp($files_arr[$i]->getVar("date"),"S")."</td>";	
					echo "<td align=\"center\">".$files_arr[$i]->getVar("downloadname")."</td>";	
					
					$online = $files_arr[$i]->getVar("counter");
				
					if( $online == 1 ) {
						echo "<td align=\"center\"><a href=\"./files.php?op=update_online_files&fileid=".$files_arr[$i]->getVar("fileid")."&files_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td align=\"center\"><a href=\"./files.php?op=update_online_files&fileid=".$files_arr[$i]->getVar("fileid")."&files_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
									echo "<td align=\"center\" width=\"10%\">
										<a href=\"files.php?op=edit_files&fileid=".$files_arr[$i]->getVar("fileid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
										<a href=\"files.php?op=delete_files&fileid=".$files_arr[$i]->getVar("fileid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
									  </td>";
						echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}
		
		// Affichage du formulaire
//    	$obj =& $filesHandler->create();
//    	$form = $obj->getForm();
        break;

case "new_files":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("files.php");
        $member_admin->addItemButton(_AM_TEST1_LIST, 'files.php?op=list_files', 'list');

        echo $member_admin->renderButton();

    $obj =& $filesHandler->create();
    $form = $obj->getForm();
    break;
	
	
		case "save_files":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("files.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["fileid"])) {
           $obj =& $filesHandler->get($_REQUEST["fileid"]);
        } else {
           $obj =& $filesHandler->create();
        }
		
		//Form filerealname	
		include_once XOOPS_ROOT_PATH."/class/uploader.php";
		$uploaddir_filerealname = XOOPS_ROOT_PATH."/uploads/ams/files/filerealname/";
		$uploader_filerealname = new XoopsMediaUploader($uploaddir_filerealname, $xoopsModuleConfig["filerealname_mimetypes"], $xoopsModuleConfig["filerealname_size"], null, null);

		if ($uploader_filerealname->fetchMedia("filerealname")) {
			$uploader_filerealname->setPrefix("filerealname_") ;
			$uploader_filerealname->fetchMedia("filerealname");
			if (!$uploader_filerealname->upload()) {
				$errors = $uploader_filerealname->getErrors();
				redirect_header("javascript:history.go(-1)",3, $errors);
			} else {
				$obj->setVar("filerealname", $uploader_filerealname->getSavedFileName());
			}
		}
		//Form storyid
		$obj->setVar("storyid", $_REQUEST["storyid"]);
		//Form date
		$obj->setVar("date", strtotime($_REQUEST["date"]));
		//Form mimetype
		$obj->setVar("mimetype", $_REQUEST["mimetype"]);
		//Form downloadname
		$obj->setVar("downloadname", $_REQUEST["downloadname"]);
		//Form counter
		$obj->setVar("counter", $_REQUEST["counter"]);
		
		
        if ($filesHandler->insert($obj)) {
           redirect_header("files.php?op=show_list_files", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_files":
		$obj = $filesHandler->get($_REQUEST["fileid"]);
		$form = $obj->getForm();
	break;
	
	case "delete_files":
		$obj =& $filesHandler->get($_REQUEST["fileid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("files.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($filesHandler->delete($obj)) {
				redirect_header("files.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "fileid" => $_REQUEST["fileid"], "op" => "delete_files"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("files")));
		}
	break;
	
	case "update_online_files":
		
	if (isset($_REQUEST["fileid"])) {
		$obj =& $filesHandler->get($_REQUEST["fileid"]);
	} 
	$obj->setVar("files_online", $_REQUEST["files_online"]);

	if ($filesHandler->insert($obj)) {
		redirect_header("files.php", 3, _AM_AMS_FORMOK);
	}
	echo $obj->getHtmlErrors();
	
	break;	
}
xoops_cp_footer();

?>