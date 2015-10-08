<?php

function table_exists($tablename) {
    global $xoopsDB;
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix($tablename);
    return $xoopsDB->query($sql);
}
                      
?>
