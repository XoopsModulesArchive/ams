<?php 

class AmsAudience extends XoopsObject {
    function AmsAudience() {
        $this->initVar('audienceid', XOBJ_DTYPE_INT);
        $this->initVar('audience', XOBJ_DTYPE_TXTBOX);
    }
}

class AMSAudienceHandler extends XoopsObjectHandler {
    function &create($new = true) {
        $audience = new AmsAudience();
        if ($new) {
            $audience->setNew();
        }
        return $audience;
    }
    
    function &get($audid) {
        $audid = intval($audid);
        if ($audid > 0) {
            $sql = "SELECT * FROM ".$this->db->prefix("ams_audience")." WHERE audienceid=".$audid;
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $audience =& $this->create(false);
            $audience->assignVars($this->db->fetchArray($result));
            return $audience;
        }
        return false;
    }
    
    function insert(&$aud) {
        if (!$aud->isDirty()) {
            return true;
        }
        if (!$aud->cleanVars()) {
            return false;
        }
        foreach ($aud->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($aud->_isNew) {
            $sql = "INSERT INTO ".$this->db->prefix("ams_audience")." 
                    (audience) VALUES 
                    ('".$audience."')";
        }
        else {
            $sql = "UPDATE ".$this->db->prefix("ams_audience")." SET
                    audience = '".$audience."' WHERE audienceid = ".$audienceid;
        }
        if (!$this->db->query($sql)) {
            return false;
        }
        if ($aud->_isNew) {
            $aud->setVar('audienceid', $this->db->getInsertId());
            $aud->_isNew = false;
        }
        return $aud->getVar('audienceid');
    }
    
    function delete(&$aud, $newaudid) {
        $sql = "UPDATE ".$this->db->prefix('ams_article')." SET audienceid = ".intval($newaudid)." WHERE audienceid = ".intval($aud->getVar('audienceid'));
        if (!$this->db->query($sql)) {
            return false;
        }
        $sql = "DELETE FROM ".$this->db->prefix('ams_audience')." WHERE audienceid=".intval($aud->getVar('audienceid'));
        return $this->db->query($sql);
    }
    
    function getAllAudiences() {
        $ret = array();
        $sql = "SELECT * FROM ".$this->db->prefix("ams_audience");
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        while ($row = $this->db->fetchArray($result)) {
            $audience =& $this->create(false);
            $audience->assignVars($row);
            $ret[$audience->getVar('audienceid')] = $audience;
            unset($audience);
        }
        return $ret;
    }
    
    function getStoryCountByAudience($audience) {
        $ret = 0;
        $sql = "SELECT count(*) AS count FROM ".$this->db->prefix('ams_article')." WHERE audienceid = ".intval($audience->getVar('audienceid'));
        $result = $this->db->query($sql);
        list($ret) = $this->db->fetchRow($result);
        return $ret;
    }
}

?>