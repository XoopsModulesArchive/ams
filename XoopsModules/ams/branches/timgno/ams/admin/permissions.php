<?php
/**
 * TDMArticle
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   Gregory Mage (Aka Mage)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Gregory Mage (Aka Mage)
 */

include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstopic.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

if( !empty($_POST["submit"]) ) 
{
	redirect_header( XOOPS_URL."/modules/".$xoopsModule->dirname()."/admin/permissions.php" , 1 , _MP_GPERMUPDATED );
}

xoops_cp_header();

    $permissions_admin = new ModuleAdmin();
    echo $permissions_admin->addNavigation("permissions.php");
	
global $xoopsDB;

	$permtoset= isset($_POST["permtoset"]) ? intval($_POST["permtoset"]) : 1;
	$selected=array("","","","");
	$selected[$permtoset-1]=" selected";
	
echo "
<form method=\"post\" name=\"fselperm\" action=\"permissions.php\">
	<table border=0>
		<tr>
			<td>
				<select name=\"permtoset\" onChange=\"javascript: document.fselperm.submit()\">
					<option value=\"1\"".$selected[0].">"._AM_AMS_ACCESSFORM."</option>
					<option value=\"2\"".$selected[1].">"._AM_AMS_APPROVEFORM."</option>
					<option value=\"3\"".$selected[2].">"._AM_AMS_SUBMITFORM."</option>
					<option value=\"4\"".$selected[3].">"._AM_AMS_VIEWFORM."</option>
				</select>
			</td>
		</tr>
	</table>
</form>";

$module_id = $xoopsModule->getVar("mid");

	switch($permtoset)
	{
		case 1:
			$title_of_form = _AM_AMS_ACCESSFORM;
			$perm_name = "ams_access";
			$perm_desc = _AM_AMS_ACCESSFORM_DESC;
			break;
		case 2:
			$title_of_form = _AM_AMS_APPROVEFORM;
			$perm_name = "ams_approve";
			$perm_desc = _AM_AMS_APPROVEFORM_DESC;
			break;
		case 3:
			$title_of_form = _AM_AMS_SUBMITFORM;
			$perm_name = "ams_submit";
			$perm_desc = _AM_AMS_SUBMITFORM_DESC;
			break;
		case 4:
			$title_of_form = _AM_AMS_VIEWFORM;
			$perm_name = "ams_view";
			$perm_desc = _AM_AMS_VIEWFORM_DESC;
			break;
	}
	
	$permform = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, "admin/permissions.php");
	$xt = new XoopsTopic( $xoopsDB -> prefix("ams_topics") );
	$alltopics =& $xt->getTopicsList();
	
	foreach ($alltopics as $topic_id => $topic) 
	{
		$permform->addItem($topic_id, $topic["title"], $topic["pid"]);
	}
	echo $permform->render();
	echo "<br /><br /><br /><br />\n";
	unset ($permform);	

include("admin_footer.php");
?>