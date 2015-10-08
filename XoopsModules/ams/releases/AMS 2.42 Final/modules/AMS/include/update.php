<?php
function xoops_module_update_AMS(&$module, $old_version) {
    if ($old_version < 225) {
        include_once XOOPS_ROOT_PATH.'/modules/AMS/upgrade/class/dbmanager.php';
	    include_once XOOPS_ROOT_PATH.'/modules/AMS/upgrade/language/install.php';
	    $dbm = new db_manager;
	    $dbm->queryFromFile(XOOPS_ROOT_PATH.'/modules/AMS/sql/upgrade.sql');
	    $feedback = $dbm->report();
	    $module->setErrors($feedback);
	    return true;
    }
    $module->setErrors("Database Tables Uptodate");
    return true;
}
?>