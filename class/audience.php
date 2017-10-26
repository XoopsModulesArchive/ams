<?php
if (!class_exists('IdgObjectHandler')) {
    include_once XOOPS_ROOT_PATH."/modules/AMS/class/idgobject.php";
}
class AmsAudience extends XoopsObject
{
    public function __construct()
    {
        $this->initVar('audienceid', XOBJ_DTYPE_INT);
        $this->initVar('audience', XOBJ_DTYPE_TXTBOX);
    }
}

class AMSAudienceHandler extends IdgObjectHandler
{
    public function __construct($db)
    {
        parent::__construct($db, 'ams_audience', 'AmsAudience', 'audienceid');
    }

    public function deleteReplace($aud, $newaudid)
    {
        if (1 == $aud->getVar('audienceid')) {
            return false;
        }
        $sql = "UPDATE ".$this->db->prefix('ams_article')." SET audienceid = ".intval($newaudid)." WHERE audienceid = ".intval($aud->getVar('audienceid'));
        if (!$this->db->query($sql)) {
            return false;
        }
        return parent::delete($aud);
    }

    public function getAllAudiences()
    {
        return $this->getObjects(null, true);
    }

    public function getStoryCountByAudience($audience)
    {
        $sql = "SELECT COUNT(*) FROM ".$this->db->prefix("ams_article")." WHERE audienceid=".$audience->getVar('audienceid');
        if ($result = $this->db->query($sql)) {
            list($count) = $this->db->fetchRow($result);
            return $count;
        }
        return false;
    }
}
