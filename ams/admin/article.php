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
$op = ams_CleanVars($_REQUEST, 'op', 'list_article', 'string');

// compte le nombre de téléchargement non validé
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', 0));
$article_waiting = $articleHandler->getCount($criteria);

$status_menu = ams_CleanVars($_REQUEST, 'status_display', 1, 'int');
$articleAdmin = new ModuleAdmin();
switch ($op) {
default:
    case "list_article":            
		echo $articleAdmin->addNavigation('article.php');
		if ($status_menu == 1){
			$articleAdmin->addItemButton(_AM_AMS_ADDARTICLE, 'article.php?op=new_article', 'add');
			if ($article_waiting == 0){
				$articleAdmin->addItemButton(_AM_AMS_ARTICLEWAIT, 'article.php?op=waiting_article&status_display=0', 'add');
			}else{
				$articleAdmin->addItemButton(_AM_AMS_ARTICLEWAIT, 'article.php?op=waiting_article&status_display=1', 'add', ' (<span style="color : Red">article_waiting . </span>)');
			}
		}else{
			$articleAdmin->addItemButton(_AM_AMS_ARTICLELIST, 'article.php?op=list_article', 'list');
			$articleAdmin->addItemButton(_AM_AMS_ADDARTICLE, 'article.php?op=new_article', 'add');
		}
		echo $articleAdmin->renderButton();
		
		$criteria = new CriteriaCompo();
		$criteria->setSort("storyid");
		$criteria->add(new Criteria('topicid', '0', '>'));
		$criteria->setOrder("ASC");
		$numrows = $articleHandler->getCount();
		$article_arr = $articleHandler->getall($criteria);
	
		//Affichage du tableau
		if ($numrows>0) 
		{			
			echo "<table width=\"100%\" cellspacing=\"1\" class=\"outer\">
				<tr>
					<th align=\"center\">"._AM_AMS_TITLE."</th>
					<th align=\"center\">"._AM_AMS_TOPICID."</th>
					<th align=\"center\">"._AM_AMS_CREATED."</th>
					<th align=\"center\">"._AM_AMS_PUBLISHED."</th>
					<th align=\"center\">"._AM_AMS_EXPIRED."</th>												
					<th align=\"center\">"._AM_AMS_IHOME."</th>						
					<th align=\"center\">"._AM_AMS_STORY_TYPE."</th>						
					<th align=\"center\">"._AM_AMS_RATING."</th>						
					<th align=\"center\">"._AM_AMS_ONLINE."</th>
					<th align=\"center\">"._AM_AMS_ACTION."</th>						
				</tr>";
					
			$class = "odd";
			
			foreach (array_keys($article_arr) as $i) 
			{	
				if ( $article_arr[$i]->getVar("topic_pid") == 0)
				{
					$class = ($class == "even") ? "odd" : "even";
					echo "<tr class=\"".$class."\">";						
					echo "<td align=\"center\">".$article_arr[$i]->getVar("title")."</td>";	
					echo "<td align=\"center\">".$article_arr[$i]->getVar("topicid")."</td>";	//topic_title
					echo "<td align=\"center\">".formatTimeStamp($article_arr[$i]->getVar("created"),"S")."</td>";	
					echo "<td align=\"center\">".formatTimeStamp($article_arr[$i]->getVar("published"),"S")."</td>";	
					echo "<td align=\"center\">".formatTimeStamp($article_arr[$i]->getVar("expired"),"S")."</td>";						
				
					$verif_ihome = ( $article_arr[$i]->getVar("ihome") == 1 ) ? _YES : _NO;
					echo "<td align=\"center\">".$verif_ihome."</td>";						
					
					echo "<td align=\"center\">".$article_arr[$i]->getVar("story_type")."</td>";						
					echo "<td align=\"center\">".$article_arr[$i]->getVar("rating")."</td>";
					$online = $article_arr[$i]->getVar("online");
			
					if( $online == 1 ) {
					   echo "<td align=\"center\"><a href=\"./article.php?op=update_online_article&storyid=".$article_arr[$i]->getVar("storyid")."&article_online=0\"><img src=".$pathImageIcon."/on.png border=\"0\" alt=\""._AM_AMS_ON."\" title=\""._AM_AMS_ON."\"></a></td>";
					} else {
					   echo "<td align=\"center\"><a href=\"./article.php?op=update_online_article&storyid=".$article_arr[$i]->getVar("storyid")."&article_online=1\"><img src=".$pathImageIcon."/off.png border=\"0\" alt=\""._AM_AMS_OFF."\" title=\""._AM_AMS_OFF."\"></a></td>";
					}
					echo "<td align=\"center\" width=\"10%\">
						<a href=\"article.php?op=edit_article&storyid=".$article_arr[$i]->getVar("storyid")."\"><img src=".$pathImageIcon."/edit.png alt=\""._EDIT."\" title=\""._EDIT."\"></a>
						<a href=\"article.php?op=delete_article&storyid=".$article_arr[$i]->getVar("storyid")."\"><img src=".$pathImageIcon."/delete.png alt=\""._DELETE."\" title=\""._DELETE."\"></a>
								  </td>";
					echo "</tr>";
				}	
			}
			echo "</table><br><br>";
		}
	break;

    case "new_article":        
        echo $articleAdmin->addNavigation("article.php");
        $articleAdmin->addItemButton(_AM_AMS_ARTICLELIST, 'article.php?op=list_article', 'list');
        echo $articleAdmin->renderButton();

        $obj =& $articleHandler->create();
        $form = $obj->getForm();
    break;
	
	
	case "save_article":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("article.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["storyid"])) {
           $obj =& $articleHandler->get($_REQUEST["storyid"]);
        } else {
           $obj =& $articleHandler->create();
        }
		
		//Form title
		$obj->setVar("title", $_REQUEST["title"]);
		//Form created
		$obj->setVar("created", strtotime($_REQUEST["created"]));
		//Form published
		$obj->setVar("published", strtotime($_REQUEST["published"]));
		//Form expired
		$obj->setVar("expired", strtotime($_REQUEST["expired"]));
		//Form hostname
		$obj->setVar("hostname", $_REQUEST["hostname"]);
		//Form nohtml
		$verif_nohtml = ($_REQUEST["nohtml"] == 1) ? "1" : "0";
		$obj->setVar("nohtml", $verif_nohtml);
		//Form nosmiley
		$verif_nosmiley = ($_REQUEST["nosmiley"] == 1) ? "1" : "0";
		$obj->setVar("nosmiley", $verif_nosmiley);
		//Form counter
		$obj->setVar("counter", $_REQUEST["counter"]);
		//Form topicid
		$obj->setVar("topicid", $_REQUEST["topicid"]);
		//Form ihome
		$verif_ihome = ($_REQUEST["ihome"] == 1) ? "1" : "0";
		$obj->setVar("ihome", $verif_ihome);
		//Form notifypub
		$verif_notifypub = ($_REQUEST["notifypub"] == 1) ? "1" : "0";
		$obj->setVar("notifypub", $verif_notifypub);
		//Form story_type
		$obj->setVar("story_type", $_REQUEST["story_type"]);
		//Form topicdisplay
		$verif_topicdisplay = ($_REQUEST["topicdisplay"] == 1) ? "1" : "0";
		$obj->setVar("topicdisplay", $verif_topicdisplay);
		//Form topicalign
		$obj->setVar("topicalign", $_REQUEST["topicalign"]);
		//Form comments
		$obj->setVar("comments", $_REQUEST["comments"]);
		//Form rating
		$obj->setVar("rating", $_REQUEST["rating"]);
		//Form banner
		$obj->setVar("banner", $_REQUEST["banner"]);
		//Form online
		$online = ($_REQUEST["online"] == 1) ? "1" : "0";
		$obj->setVar("online", $online);
		//Form audienceid
		$obj->setVar("audienceid", $_REQUEST["audienceid"]);
		
		
        if ($articleHandler->insert($obj)) {
           redirect_header("article.php?op=show_list_article", 2, _AM_AMS_FORMOK);
        }
        
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
	break;
	
	case "edit_article":
		$obj = $articleHandler->get($_REQUEST["storyid"]);
		$form = $obj->getForm();
	break;
	
	case "waiting_article":
		echo $articleAdmin->addNavigation("article.php");
        $articleAdmin->addItemButton(_AM_AMS_ARTICLELIST, 'article.php?op=list_article', 'list');
        echo $articleAdmin->renderButton();
	break;
	
	case "delete_article":
		$obj =& $articleHandler->get($_REQUEST["storyid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("article.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($articleHandler->delete($obj)) {
				redirect_header("article.php", 3, _AM_AMS_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "storyid" => $_REQUEST["storyid"], "op" => "delete_article"), $_SERVER["REQUEST_URI"], sprintf(_AM_AMS_FORMSUREDEL, $obj->getVar("article")));
		}
	break;
	
	case "update_online_article":		
		if (isset($_REQUEST["storyid"])) {
			$obj =& $articleHandler->get($_REQUEST["storyid"]);
		} 
		$obj->setVar("online", $_REQUEST["online"]);

		if ($articleHandler->insert($obj)) {
			redirect_header("article.php", 3, _AM_AMS_FORMOK);
		}
		echo $obj->getHtmlErrors();	
	break;	
}
include "admin_footer.php";

?>