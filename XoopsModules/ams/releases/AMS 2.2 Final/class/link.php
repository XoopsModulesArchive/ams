<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //

class Link extends XoopsObject {
    var $table;
    var $db;
    
    function Link($id = null) {
        $this->db =& XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('linkid', XOBJ_DTYPE_INT);
        $this->initVar('storyid', XOBJ_DTYPE_INT);
        $this->initVar('link_module', XOBJ_DTYPE_INT);
        $this->initVar('link_link', XOBJ_DTYPE_TXTBOX);
        $this->initVar('link_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('link_counter', XOBJ_DTYPE_INT);
        $this->initVar('link_position', XOBJ_DTYPE_TXTBOX);
        $this->table = $this->db->prefix('ams_link');
        if ($id != null) {
            $this->get($id);
        }
    }
    
    function get($id) {
        $sql = "SELECT * FROM ".$this->table." WHERE linkid = ".intval($id)." LIMIT 1";
        $result = $this->db->query($sql);
        $row = $this->db->fetchArray($result);
        $this->assignVars($row);            
    }
    
    /**
    * Increment Link counter
    *
    * @return bool
    */
    function increment() {
        $sql = "UPDATE ".$this->table." SET link_counter=link_counter+1 WHERE linkid=".intval($this->getVar('linkid'));
        return $this->db->queryF($sql);
    }
        
}

class AMSLinkHandler extends XoopsObjectHandler {
    var $table;
    
    function AMSLinkHandler(&$db) {
        $this->XoopsObjectHandler(&$db);
        $this->table = $this->db->prefix('ams_link');
    }
    /**
     * create a new Link object
     * 
     * @param bool $isNew flag the new objects as "new"?
     * @return object {@link Link}
     */
    function &create($isNew = true)
    {
        $link = new Link();
        if ($isNew) {
            $link->setNew();
        }
        return $link;
    }
    
    /**
     * retrieve a {@link Link}
     * 
     * @param int $id ID of the link
     * @return mixed reference to the {@link Link} object, FALSE if failed
     */
    function &get($id) {
        $link = new Link($id);
        return $link;
    }
    
    /**
    * Save link in database
    * @param object $link reference to the {@link Link} object
    * @param bool $force 
    * @return bool FALSE if failed, TRUE if already present and unchanged or successful
    */
    function insert(&$link, $force = false) {
        if (strtolower(get_class($link)) != 'link') {
            return false;
        }
        if (!$link->isDirty()) {
            return true;
        }
        if (!$link->cleanVars()) {
            return false;
        }
        foreach ($link->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($link->_isNew) {
            $sql = "INSERT INTO ".$this->table." (storyid, link_module, link_link, link_title, link_position) 
	               VALUES ($storyid, $link_module, '$link_link', ".$this->db->quoteString($link_title).", '$link_position')";
        }
        else {
            $sql = "UPDATE ".$this->table." SET
                    storyid = $storyid,
                    link_module = $link_module,
                    link_link = '$link_link',
                    link_title = ".$this->db->quoteString($link_title).",
                    link_position = '$link_position' 
                    WHERE linkid = ".$linkid;
        }
        if (!$this->db->query($sql)) {
            return false;
        }
        if ($link->_isNew) {
            $link->setVar('linkid', $this->db->getInsertId());
            $link->_isNew = false;
        }
        return true;
    }
    
    /**
    * delete a link from the database
    *
    * @param object $link reference to the {@link Link} to delete
    * @param bool $force
    * @return bool FALSE if failed.
    */
    function delete(&$link) {
        $sql = "DELETE FROM ".$this->table." WHERE linkid = ".intval($link->getVar('linkid'));
        if (!$this->db->query($sql)) {
            return false;
        }
        return true;
    }
    
    /**
    * get array of links by story
    *
    * @param int $storyid ID of story
    *
    * @return array
    */
    function &getByStory($storyid) {
        global $xoopsModule;
        $ret = array();
	    $module_handler =& xoops_gethandler('module');
	    $link = "article.php?storyid=".intval($storyid);
	    $myts = MyTextSanitizer::getInstance();
	    
	    if ($xoopsModule->getVar('dirname') != "AMS") {
	        $newsmodule =& $module_handler->getByDirname('AMS');
	    }
	    else {
	        $newsmodule =& $xoopsModule;
	    }
	    $sql = "SELECT n.title, n.storyid, l.* FROM ".$this->table." l, ".$this->db->prefix('ams_article')." n WHERE n.storyid=l.storyid AND ((link_link='$link' AND link_module=".$newsmodule->mid().") OR (l.storyid = ".intval($storyid)."))";
	    $directresult = $this->db->query($sql);
	    //$moduleids[$newsmodule->getVar('mid')] = $newsmodule->getVar('mid');
	    while ($row = $this->db->fetchArray($directresult)) {
	        if ($row['storyid'] == $storyid) {
	            if ($row['link_module'] > -1) {
	                $moduleids[$row['link_module']] = $row['link_module'];
	                $row['target'] = "_self";
	            }
	            else {
	                $row['target'] = "_blank";
	            }
	            $row['link_title'] = $myts->htmlSpecialChars($row['link_title']);
	            $row['hits'] = $row['link_counter'];
	            $ret[$row['link_position']][] = $row;
	        }
	        else {
	            $row['link_module'] = $newsmodule->getVar('mid');
	            $row['link_link'] = 'article.php?storyid='.$row['storyid'];
	            $row['link_title'] = $myts->htmlSpecialChars($row['title']);
	            $row['target'] = "_self";
	            $row['hits'] = $row['link_counter'];
	            // Backlink, so set position to recommended reading
	            $ret['bottom'][] = $row;
	        }
	    }
	    if (isset($moduleids)) {
	        $moduleids = "(".implode(',', array_keys($moduleids)).")";
	        $modules = $module_handler->getList(new Criteria('mid', $moduleids, "IN"));
	    }
	    $modules[$newsmodule->getVar('mid')] = $newsmodule->getVar('name');
	    foreach ($ret as $position => $links) {
	        foreach ($links as $key => $link) {
	            $ret[$position][$key]['link_module'] = ($link['link_module'] > -1) ? $modules[$link['link_module']] : _AMS_NW_EXTERNALLINK;
	        }
	    }
	    return $ret;
    }
}
?>