<?php
class OldNewsTopic
{
    public $db;
    public $topic_id;
    public $topic_imgurl;
    public $topic_pid;
    public $topic_title;
    public function __construct($id=-1)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        if (is_array($id)) {
            $this->makeObject($id);
        }
    }
    public function makeObject($array)
    {
        foreach ($array as $key=>$value) {
            $this->$key = $value;
        }
    }

    public function getAllTopics()
    {
        $ret = array();
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT * FROM ".$db->prefix('topics');
        $result = $db->query($sql);
        while ($row = $db->fetchArray($result)) {
            $ret[] = new OldNewsTopic($row);
        }
        return $ret;
    }

    public function upgrade()
    {
        $myts = MyTextSanitizer::getInstance();
        $sql = "INSERT INTO ".$this->db->prefix('ams_topics')."
                (topic_id, topic_pid, topic_imgurl, topic_title)
	            VALUES (".$this->topic_id.", ".$this->topic_pid.", '".$this->topic_imgurl."', '".$myts->addSlashes($this->topic_title)."')";
        return $this->db->query($sql);
    }

    public function copyPermissions($mid)
    {
        $criteria = new Criteria('gperm_modid', intval($mid));
        $gperm_handler = xoops_getHandler('groupperm');
        $gperm_items = $gperm_handler->getObjects($criteria);

        $mod_handler = xoops_getHandler('module');
        $amsModule = $mod_handler->getByDirname('AMS');
        $amsmid = $amsModule->getVar('mid');
        foreach (array_keys($gperm_items) as $i) {
            $gperm_items[$i]->setNew();
            $gperm_items[$i]->setVar('gperm_modid', $amsmid);
            switch ($gperm_items[$i]->getVar('gperm_name')) {
                case "news_approve":
                   $gperm_items[$i]->setVar('gperm_name', 'ams_approve');
                   break;
                case "news_submit":
                   $gperm_items[$i]->setVar('gperm_name', 'ams_submit');
                   break;
                case "news_view":
                   $gperm_items[$i]->setVar('gperm_name', 'ams_view');
                   break;
            }
            if (!$gperm_handler->insert($gperm_items[$i])) {
                return false;
            }
        }
        return true;
    }

    public function cleanUp()
    {
        return true;
    }
}
