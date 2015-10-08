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
 * @author          NovaSmart Technology by Mithrandir (support@xoops.org)
 * @author          TXMod Xoops (info@txmodxoops.org)
 *
 * Version : 3.01 Thu 2011/11/24 6:00:35 : Timgno Exp $
 * ****************************************************************************
 */
 
if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$dirname = basename( dirname( __FILE__ ) ) ;

$modversion['name'] = _MI_AMS_NAME;
$modversion['version'] = 3.01;
$modversion['description'] = _MI_AMS_DESC;
$modversion['author'] = "NovaSmart Technology, TXMod Xoops";
$modversion['author_mail'] = "info@txmodxoops.org";
$modversion['author_website_url'] = "http://www.txmodxoops.org";
$modversion['author_website_name'] = "TXMod Xoops";
$modversion['credits'] = "Hervé Thouzard, Timgno";
$modversion['license'] = "GPL see LICENSE";
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";

$modversion['release_info'] = "Beta 1 24/11/2011";
$modversion['release_file'] = XOOPS_URL."/modules/".$dirname."/docs/changelog.txt";
$modversion['release_date'] = "2011/11/24";

$modversion['manual'] = "Install Manual";
$modversion['manual_file'] = XOOPS_URL."/modules/".$dirname."/docs/install.txt";

$modversion['image'] = "images/ams_slogo.png";
$modversion['dirname'] = "$dirname";

$modversion['min_php']="5.2";
$modversion['min_xoops']="2.5";
$modversion['min_admin']="1.1";
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

//About
$modversion['demo_site_url'] = "http://www.txmodxoops.org/modules/ams";
$modversion['demo_site_name'] = "AMS TXMod Xoops";
$modversion['forum_site_url'] = "http://www.txmodxoops.org/modules/newbb/";
$modversion['forum_site_name'] = "TXMod Xoops Community";
$modversion['module_website_url'] = "http://www.txmodxoops.org/";
$modversion['module_website_name'] = "TXMod Xoops";
$modversion['release'] = "24-11-2011";
$modversion['module_status'] = "Beta 1";

// Admin things
$modversion['hasAdmin'] = 1;
// Admin system menu
$modversion['system_menu'] = 1;

// Sql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
// Tables
$modversion['tables'][0] = "ams_article";
$modversion['tables'][1] = "ams_topics";
$modversion['tables'][2] = "ams_files";
$modversion['tables'][3] = "ams_link";
$modversion['tables'][4] = "ams_text";
$modversion['tables'][5] = "ams_rating";
$modversion['tables'][6] = "ams_audience";
$modversion['tables'][7] = "ams_spotlight";
$modversion['tables'][8] = "ams_setting";

$modversion["adminindex"] = "admin/index.php";
$modversion["adminmenu"] = "admin/menu.php";

// Scripts to run upon installation or update
$modversion["onInstall"] = "include/install.php";
//$modversion["onUpdate"] = "include/update.php";

//Search
$modversion["hasSearch"] = 1;
$modversion["search"]["file"] = "include/search.inc.php";
$modversion["search"]["func"] = "ams_search";

//Added ams 3.01 Beta 1
//Fetch ams spotlight dynamicly
$sl_tlc=0; // spotlight_templates_list_count
$sl_t=array(); // spotlight_templates
$sl_tl=array(); // spotlight_templates_list
$path = XOOPS_ROOT_PATH."/modules/ams/templates";
if ($handle = opendir($path))
{
	while (false !== ($file = readdir($handle)))
	{
		//if not a folder...
		if (!is_dir($path."/".$file) && $file != "." && $file != "..")
		{
			//if it is spotlight templates..
			if(substr($file,0,19)=="ams_block_spotlight" && substr($file, strlen($file) - 5)==".html")
			{			
					$tn_offset=20; // template_name_offset
					$tn=substr($file,$tn_offset,strlen($file)-$tn_offset-5);
					$sl_t[$tn]=$file;
					$sl_tl[$sl_tlc]=$file;
					$sl_tlc++;
			}
		}
	}
   closedir($handle);
}

// Templates
$i = 1;
$modversion["templates"][$i]["file"] = "ams_index.html";
$modversion["templates"][$i]["description"] = "ams index page";
$i++;
$modversion['templates'][$i]['file'] = 'ams_item.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_archive.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_article.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_by_topic.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_ratearticle.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_version.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'ams_searchform.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion["templates"][$i]["file"] = "ams_header.html";
$modversion["templates"][$i]["description"] = "ams header page";
$i++;
$modversion["templates"][$i]["file"] = "ams_footer.html";
$modversion["templates"][$i]["description"] = "ams footer page";
//Added ams 3.01 Beta 1
//Put detected SPOTLIGHT templates to templates
for($j=0;$j<$sl_tlc;$j++)
{  
    $i++;
	$modversion['templates'][$i]['file'] = $sl_tl[$j];
	$modversion['templates'][$i]['description'] = '';	
}
unset( $i );

// Blocks
$i=1;
$modversion['blocks'][$i]['file'] = "ams_topics.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME1;
$modversion['blocks'][$i]['description'] = "Shows news topics";
$modversion['blocks'][$i]['show_func'] = "b_ams_topics_show";
$modversion['blocks'][$i]['template'] = 'ams_block_topics.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_bigstory.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME3;
$modversion['blocks'][$i]['description'] = "Shows most read story of the day";
$modversion['blocks'][$i]['show_func'] = "b_ams_bigstory_show";
$modversion['blocks'][$i]['template'] = 'ams_block_bigstory.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_top.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME4;
$modversion['blocks'][$i]['description'] = "Shows top read news articles";
$modversion['blocks'][$i]['show_func'] = "b_ams_top_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][$i]['options'] = "counter|10|25|0";
$modversion['blocks'][$i]['template'] = 'ams_block_top.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_top.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME5;
$modversion['blocks'][$i]['description'] = "Shows recent articles";
$modversion['blocks'][$i]['show_func'] = "b_ams_top_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][$i]['options'] = "published|10|25|0";
$modversion['blocks'][$i]['template'] = 'ams_block_top.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_moderate.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME6;
$modversion['blocks'][$i]['description'] = "Shows a block to moderate articles";
$modversion['blocks'][$i]['show_func'] = "b_ams_topics_moderate";
$modversion['blocks'][$i]['template'] = 'ams_block_moderate.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_topicsnav.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME7;
$modversion['blocks'][$i]['description'] = "Shows a block to navigate topics";
$modversion['blocks'][$i]['show_func'] = "b_ams_topicsnav_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_topicsnav_edit";
$modversion['blocks'][$i]['options'] = 0;
$modversion['blocks'][$i]['template'] = 'ams_block_topicnav.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_author.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME8;
$modversion['blocks'][$i]['description'] = "Shows top authors";
$modversion['blocks'][$i]['show_func'] = "b_ams_author_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][$i]['options'] = "count|5|uname";
$modversion['blocks'][$i]['template'] = 'ams_block_authors.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_author.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME9;
$modversion['blocks'][$i]['description'] = "Shows top authors";
$modversion['blocks'][$i]['show_func'] = "b_ams_author_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][$i]['options'] = "read|5|uname";
$modversion['blocks'][$i]['template'] = 'ams_block_authors.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_author.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME10;
$modversion['blocks'][$i]['description'] = "Shows top authors";
$modversion['blocks'][$i]['show_func'] = "b_ams_author_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_author_edit";
$modversion['blocks'][$i]['options'] = "rating|5|uname";
$modversion['blocks'][$i]['template'] = 'ams_block_authors.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_top.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME11;
$modversion['blocks'][$i]['description'] = "Shows top rated articles";
$modversion['blocks'][$i]['show_func'] = "b_ams_top_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_top_edit";
$modversion['blocks'][$i]['options'] = "rating|10|25|0";
$modversion['blocks'][$i]['template'] = 'ams_block_top.html';
$i++;
$modversion['blocks'][$i]['file'] = "ams_spotlight.php";
$modversion['blocks'][$i]['name'] = _MI_AMS_BNAME12;
$modversion['blocks'][$i]['description'] = "Spotlight articles";
$modversion['blocks'][$i]['show_func'] = "b_ams_spotlight_show";
$modversion['blocks'][$i]['edit_func'] = "b_ams_spotlight_edit";
$modversion['blocks'][$i]['options'] = "10|1|"/*.$spotlight_templates_list[0]*/;
$modversion['blocks'][$i]['template'] = 'ams_block_spotlight.html';
unset($i);

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_AMS_SMNAME2;
$modversion['sub'][1]['url'] = "archive.php";

global $xoopsModule;
if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsUser;
    if (is_object($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
    } else {
        $groups = XOOPS_GROUP_ANONYMOUS;
    }
    $gperm_handler =& xoops_gethandler('groupperm');
    if ($gperm_handler->checkRight("ams_submit", 0, $groups, $xoopsModule->getVar('mid'))) {
        $modversion['sub'][2]['name'] = _MI_AMS_SMNAME1;
        $modversion['sub'][2]['url'] = "submit.php";
    }
}

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "ams_search";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'article.php';
$modversion['comments']['itemName'] = 'storyid';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'ams_com_approve';
$modversion['comments']['callback']['update'] = 'ams_com_update';

// Config
$i = 1;
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
$modversion["config"][$i]["name"]        = "ams_editor";
$modversion["config"][$i]["title"]       = "_MI_AMS_EDITOR";
$modversion["config"][$i]["description"] = "_MI_AMS_EDITORDSC";
$modversion["config"][$i]["formtype"]    = "select";
$modversion["config"][$i]["valuetype"]   = "text";
$modversion["config"][$i]["default"]     = "dhtmltextarea";
$modversion["config"][$i]["options"]     = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . "/class/xoopseditor");
$modversion["config"][$i]["category"]    = "global";  
$i++;
$modversion['config'][$i]['name'] = 'storyhome';
$modversion['config'][$i]['title'] = '_MI_AMS_STORYHOME';
$modversion['config'][$i]['description'] = '_MI_AMS_STORYHOMEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
$i++;
//Uploads : mimetypes
$modversion["config"][$i]["name"] = "mimetypes";
$modversion["config"][$i]["title"] = "_MI_AMS_MIME_TYPES";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"] = "select_multi";
$modversion["config"][$i]["valuetype"] = "array";
$modversion["config"][$i]["default"] = array("image/gif", "image/jpeg", "image/png");
$modversion["config"][$i]["options"] = array(
"bmp" => "image/bmp",
"gif" => "image/gif",
"jpeg" => "image/pjpeg",
"jpeg" => "image/jpeg",
"jpg" => "image/jpeg",
"jpe" => "image/jpeg",
"png" => "image/png");
$i++;
$modversion['config'][$i]['name'] = 'storycountadmin';
$modversion['config'][$i]['title'] = '_MI_AMS_STORYCOUNTADMIN';
$modversion['config'][$i]['description'] = '_MI_AMS_STORYCOUNTADMIN_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);
$i++;
$modversion['config'][$i]['name'] = "storyhome_topic";
$modversion['config'][$i]['title'] = '_MI_AMS_STORYCOUNTTOPIC';
$modversion['config'][$i]['description'] = '_MI_AMS_STORYCOUNTTOPIC_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);
$i++;
$modversion['config'][$i]['name'] = 'max_items';
$modversion['config'][$i]['title'] = '_MI_AMS_MAXITEMS';
$modversion['config'][$i]['description'] = '_MI_AMS_MAXITEMDESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$i++;
$modversion['config'][$i]['name'] = 'spotlight_art_num';
$modversion['config'][$i]['title'] = '_MI_AMS_SPOTLIGHT_ITEMS';
$modversion['config'][$i]['description'] = '_MI_AMS_SPOTLIGHT_ITEMDESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['options'] = array('1' => 1, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50, '100' => 100, '500' => 500);
$i++;
$modversion['config'][$i]['name'] = 'displaynav';
$modversion['config'][$i]['title'] = '_MI_AMS_DISPLAYNAV';
$modversion['config'][$i]['description'] = '_MI_AMS_DISPLAYNAVDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name']        = 'usetellafriend';
$modversion['config'][$i]['title']       = '_MI_AMS_USETELLAFRIEND';
$modversion['config'][$i]['description'] = '_MI_AMS_USETELLAFRIEND_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;
$i++;
$modversion['config'][$i]['name'] = 'autoapprove';
$modversion['config'][$i]['title'] = '_MI_AMS_AUTOAPPROVE';
$modversion['config'][$i]['description'] = '_MI_AMS_AUTOAPPROVE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'uploadgroups';
$modversion['config'][$i]['title'] = '_MI_AMS_UPLOADGROUPS';
$modversion['config'][$i]['description'] = '_MI_AMS_UPLOADGROUPS_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 2;
$modversion['config'][$i]['options'] = array('_MI_AMS_UPLOAD_GROUP1' => 1, '_MI_AMS_UPLOAD_GROUP2' => 2, '_MI_AMS_UPLOAD_GROUP3' => 3);
$i++;
$modversion['config'][$i]['name'] = 'maxuploadsize';
$modversion['config'][$i]['title'] = '_MI_AMS_UPLOADFILESIZE';
$modversion['config'][$i]['description'] = '_MI_AMS_UPLOADFILESIZE_DESC';
$modversion['config'][$i]['formtype'] = 'texbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 104857600;
$i++;
$modversion['config'][$i]['name'] = 'newsdisplay';
$modversion['config'][$i]['title'] = '_MI_AMS_NEWSDISPLAY';
$modversion['config'][$i]['description'] = '_MI_AMS_NEWSDISPLAY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "Classic";
$modversion['config'][$i]['options'] = array('_MI_AMS_NEWSCLASSIC' => 'Classic', '_MI_AMS_NEWSBYTOPIC' => 'Bytopic');
$i++;
// For Author's name
$modversion['config'][$i]['name'] = 'displayname';
$modversion['config'][$i]['title'] = '_MI_AMS_NAMEDISPLAY';
$modversion['config'][$i]['description'] = '_MI_AMS_ADISPLAYNAMEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options']	= array('_MI_AMS_DISPLAYNAME1' => 1, '_MI_AMS_DISPLAYNAME2' => 2, '_MI_AMS_DISPLAYNAME3' => 3);
$i++;
$modversion['config'][$i]['name']        = 'permission_articles';
$modversion['config'][$i]['title']       = '_MI_AMS_PERMISSION_ARTICLES';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;
$modversion['config'][$i]['options']     = array('_MI_AMS_PERMISSION_ARTICLES1' => 1, '_MI_AMS_PERMISSION_ARTICLES2' => 2);
$i++;
$modversion['config'][$i]['name'] = 'numcolumns';
$modversion['config'][$i]['title'] = '_MI_AMS_NUMCOLUMNS';
$modversion['config'][$i]['description'] = '_MI_AMS_NUMCOLUMN_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
$i++;
$modversion['config'][$i]['name'] = 'numrows';
$modversion['config'][$i]['title'] = '_MI_AMS_NUMROWS';
$modversion['config'][$i]['description'] = '_MI_AMS_NUMROWS_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
$i++;
$modversion['config'][$i]['name'] = 'admin_perpage';
$modversion['config'][$i]['title'] = '_MI_AMS_ADMIN_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_AMS_ADMIN_PERPAGE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array('1' => 1, '2' => 2, '4' => 4, '5' => 5, '6' => 6, '8' => 8, '9' => 9, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);
$i++;
$modversion['config'][$i]['name'] = 'restrictindex';
$modversion['config'][$i]['title'] = '_MI_AMS_RESTRICTINDEX';
$modversion['config'][$i]['description'] = '_MI_AMS_RESTRICTINDEXDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'anonymous_vote';
$modversion['config'][$i]['title'] = '_MI_AMS_ANONYMOUS_VOTE';
$modversion['config'][$i]['description'] = '_MI_AMS_ANONYMOUS_VOTE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'index_name';
$modversion['config'][$i]['title'] = '_MI_AMS_INDEX_NAME';
$modversion['config'][$i]['description'] = '_MI_AMS_INDEX_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "Index";
$i++;
$modversion['config'][$i]['name'] = 'spotlight_template';
$modversion['config'][$i]['title'] = '_MI_AMS_SPOTLIGHT_TEMPLATE';
$modversion['config'][$i]['description'] = '_MI_AMS_SPOTLIGHT_TEMPLATE_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = $sl_t;
$modversion['config'][$i]['options'] = $sl_t;
unset($i);

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'ams_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_AMS_NEWS_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_AMS_NEWS_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'article.php');

$modversion['notification']['category'][2]['name'] = 'story';
$modversion['notification']['category'][2]['title'] = _MI_AMS_NEWS_STORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_AMS_NEWS_STORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('article.php');
$modversion['notification']['category'][2]['item_name'] = 'storyid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'story_submit';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_storysubmit_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_story';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newstory_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'approve';
$modversion['notification']['event'][4]['category'] = 'story';
$modversion['notification']['event'][4]['invisible'] = 1;
$modversion['notification']['event'][4]['title'] = _MI_AMS_NEWS_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_AMS_NEWS_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_AMS_NEWS_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_AMS_NEWS_STORY_APPROVE_NOTIFYSBJ;

?>