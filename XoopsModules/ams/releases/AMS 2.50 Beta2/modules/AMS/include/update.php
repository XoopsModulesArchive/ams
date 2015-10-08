<?php

function xoops_module_update_AMS(&$module, $old_version) {

    if ($old_version < 225) //If upgrade from AMS older than 2.25
	{
        include_once XOOPS_ROOT_PATH.'/modules/AMS/upgrade/class/dbmanager.php';
	    include_once XOOPS_ROOT_PATH.'/modules/AMS/upgrade/language/install.php';
	    $dbm = new db_manager;
	    $dbm->queryFromFile(XOOPS_ROOT_PATH.'/modules/AMS/sql/upgrade.sql');
	    $feedback = $dbm->report();
	    $module->setErrors($feedback);
	    return true;
    }elseif($old_version <= 250) //if upgrade from AMS 2.25 - AMS 2.50
	{
		//There is template changes in AMS 2.50 Beta 2. Delete previous template in order not to confuse AMS
		if(file_exists(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_center.html'))
		{
			$module->setErrors("Old template detected !. Deleting ams_block_spotlight_center.html");
			unlink(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_center.html');
		}
		
		if(file_exists(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_left.html'))
		{
			$module->setErrors("Old template detected !. Deleting ams_block_spotlight_left.html");
			unlink(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_left.html');
		}

		if(file_exists(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_right.html'))
		{
			$module->setErrors("Old template detected !. Deleting ams_block_spotlight_right.html");
			unlink(XOOPS_ROOT_PATH.'/modules/AMS/templates/ams_block_spotlight_right.html');
		}

	    return true;
	}
    $module->setErrors("Database Tables Uptodate");
    return true;
}


?>