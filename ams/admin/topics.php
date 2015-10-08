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
global $pathImageIcon;

//On recupere la valeur de l argument op dans l URL$
$op = ams_CleanVars($_REQUEST, 'op', 'list', 'string');

// compte le nombre de téléchargement non validé
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', 0));
$topics_waiting = $topicsHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');

switch ($op) {
    case "list_topics":
	default:
            $topics_admin = new ModuleAdmin();
            echo $topics_admin->addNavigation('topics.php');
            if ($status_menu == 1){
                $topics_admin->addItemButton(_AM_AMS_ADDTOPICS, 'topics.php?op=new_topics', 'add');                
            }else{
                $topics_admin->addItemButton(_AM_AMS_TOPICSLIST, 'topics.php?op=list_topics', 'list');
                $topics_admin->addItemButton(_AM_AMS_ADDTOPICS, 'topics.php?op=new_topics', 'add');
            }
            echo $topics_admin->renderButton();
			$topics = ams_MygetItemIds('ams_view', 'ams');
		    $criteria = new CriteriaCompo();
		    $criteria->setSort("topic_id");
		    $criteria->setSort('weight ASC, topic_title');
            $criteria->setOrder('ASC');
		    $criteria->add(new Criteria('topic_id', '(' . implode(',', $topics) . ')','IN'));
		    $numrows = $topicsHandler->getCount();
		    $topics_arr = $topicsHandler->getall($criteria);
		
			//Affichage du tableau
			if ($numrows>0) 
			{			
				echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
					<tr>
						<th align=\"center\">"._AM_AMS_TOPIC_ID."</th>
						<th align=\"center\">"._AM_AMS_TOPIC_PID."</th>
						<th align=\"center\">"._AM_AMS_TOPICIMG."</th>
						<th align=\"center\">"._AM_AMS_TOPIC_TITLE."</th>
						<th align=\"center\">"._AM_AMS_BANNER."</th>
						<th align=\"center\">"._AM_AMS_BANNER_INHERIT."</th>
						<th align=\"center\">"._AM_AMS_FORUM_ID."</th>						
						<th align=\"center\">"._AM_AMS_WEIGHT."</th>
						<th align=\"center\">"._AM_AMS_ONLINE."</th>
						
						<th align=\"center\" width=\"10%\">"._AM_AMS_FORMACTION."</th>
					</tr>";
						
				$class = "odd";				
				foreach (array_keys($topics_arr) as $i) 
				{	
					if ( $topics_arr[$i]->getVar("topic_pid") == 0)
					{
						echo "<tr class=\"center ".$class."\">";
						$class = ($class == "even") ? "odd" : "even";
						echo "<td>".$topics_arr[$i]->getVar("topic_id")."</td>";
						echo "<td>".$topics_arr[$i]->getVar("topic_pid")."</td>";
						echo "<td><img src=\"".XOOPS_URL."/uploads/ams/topics/topic_imgurl/".$topics_arr[$i]->getVar("topic_imgurl")."\" height=\"30px\" title=\"topic_imgurl\" alt=\"topic_imgurl\"></td>";	
					echo "<td>".$topics_arr[$i]->getVar("topic_title")."</td>";
						echo "<td>".$topics_arr[$i]->getVar("banner")."</td>";	
					
					$verif_banner_inherit = ( $topics_arr[$i]->getVar("banner_inherit") == 1 ) ? _YES : _NO;
					echo "<td>".$verif_banner_inherit."</td>";	
					echo "<td>".$topics_arr[$i]->getVar("forum_id")."</td>";
					echo "<td>".$topics_arr[$i]->getVar("weight")."</td>";
					$online = $topics_arr[$i]->getVar("online");
				
					if( $online == 1 ) {
						echo "<td><a href=\"./topics.php?op=update_online_topics&topic_id=".$topics_arr[$i]->getVar("topic_id")."&topics_online=1\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
						echo "<td><a href=\"./topics.php?op=update_online_topics&topic_id=".$topics_arr[$i]->getVar("topic_id")."&topics_online=0\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
					echo "<td width=\"10%\">
							<a href=\"topics.php?op=edit_topics&topic_id=".$topics_arr[$i]->getVar("topic_id")."\"><img src=".$pathImageIcon."/edit.png alt=\""._AM_AMS_EDIT."\" title=\""._AM_AMS_EDIT."\"></a>
							<a href=\"topics.php?op=delete_topics&topic_id=".$topics_arr[$i]->getVar("topic_id")."\"><img src=".$pathImageIcon."/delete.png alt=\""._AM_AMS_DELETE."\" title=\""._AM_AMS_DELETE."\"></a>
						  </td>";
					echo "</tr>";
					}	
				}
				echo "</table><br><br>";
			}		
    break;

    case "new_topics":
        $member_admin = new ModuleAdmin();
        echo $member_admin->addNavigation("topics.php");
        $member_admin->addItemButton(_AM_AMS_TOPICSLIST, 'topics.php?op=list_topics', 'list');
        echo $member_admin->renderButton();

        $obj =& $topicsHandler->create();
        $form = $obj->getForm();
    break;
	
	
		case "save_topics":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("topics.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["topic_id"])) {
           $obj =& $topicsHandler->get($_REQUEST["topic_id"]);
        } else {
           $obj =& $topicsHandler->create();
        }
		
		//Form topic_pid
		$obj->setVar("topic_pid", $_REQUEST["topic_pid"]);
		//Form topic_imgurl	
		include_once XOOPS_ROOT_PATH."/class/uploader.php";
		$uploaddir_topic_imgurl = XOOPS_ROOT_PATH."/uploads/ams/topics/topic_imgurl/";
		$uploader_topic_imgurl = new XoopsMediaUploader($uploaddir_topic_imgurl, 
		                                                $xoopsModuleConfig["mimetypes"], 
														$xoopsModuleConfig["image_size"], 
														null, null);

		if ($uploader_topic_imgurl->fetchMedia($_POST['xoops_upload_file'][0])) {
			$uploader_topic_imgurl->setPrefix("topic_imgurl_") ;
			$uploader_topic_imgurl->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader_topic_imgurl->upload()) {
				$errors = $uploader_topic_imgurl->getErrors();
				redirect_header("javascript:history.go(-1)",3, $errors);
			} else {
				$obj->setVar("topic_imgurl", $uploader_topic_imgurl->getSavedFileName());
			}
		} else {
			$obj->setVar("topic_imgurl", $_REQUEST["topic_imgurl"]);
		}
		//Form topic_title
		$obj->setVar("topic_title", $_REQUEST["topic_title"]);
		//Form banner
		$obj->setVar("banner", $_REQUEST["banner"]);
		//Form banner_inherit
		$banner_inherit = ($_REQUEST["banner_inherit"] == 1) ? "1" : "0";
		$obj->setVar("banner_inherit", $banner_inherit);
		//Form forum_id
		$obj->setVar("forum_id", $_REQUEST["forum_id"]);
		//Form weight
		$obj->setVar("weight", $_REQUEST["weight"]);
		//Form online
		$online = ($_REQUEST["online"] == 1) ? "1" : "0";
		$obj->setVar("online", $online);		
		
        if ($topicsHandler->insert($obj)) {
           redirect_header("topics.php?op=show_list_topics", 2, _AM_AMS_FORMOK);
        }
        //include_once("../include/forms.php");
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_topics":
		$obj = $topicsHandler->get($_REQUEST["topic_id"]);
		$form = $obj->getForm();
	break;
	
	case "delete_topics":
		$obj =& $topicsHandler->get($_REQUEST["topic_id"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("topics.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($topicsHandler->delete($obj)) {
				redirect_header("topics.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "topic_id" => $_REQUEST["topic_id"], "op" => "delete_topics"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("topics")));
		}
	break;
	
	case "update_online_topics":		
	    if (isset($_REQUEST["topic_id"])) {
		    $obj =& $topicsHandler->get($_REQUEST["topic_id"]);
	    } 
	    $obj->setVar("online", $_REQUEST["online"]);

	    if ($topicsHandler->insert($obj)) {
		    redirect_header("topics.php", 3, _AM_AMS_FORMOK);
	    }
	    echo $obj->getHtmlErrors();	
	break;	
}
xoops_cp_footer();

?>