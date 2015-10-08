<?php
class OldNewsTopic {
    var $db;
    var $topic_id;
    var $topic_imgurl;
    var $topic_pid;
    var $topic_title;
    function OldNewsTopic($id=-1)
	{
		$this->db =& Database::getInstance();
		if (is_array($id)) {
			$this->makeObject($id);
		}
	}
    function makeObject($array)
	{
		foreach ( $array as $key=>$value ){
			$this->$key = $value;
		}
	}
    
    function getAllTopics() {
        $ret = array();
        $db =& Database::getInstance();
	    $sql = "SELECT * FROM ".$db->prefix('topics');
	    $result = $db->query($sql);
	    while ($row = $db->fetchArray($result)) {
	        $ret[] = new OldNewsTopic($row);
	    }
	    return $ret;
	}
	
	function upgrade() {
	    $myts =& MyTextSanitizer::getInstance();
	    $sql = "INSERT INTO ".$this->db->prefix('ams_topics')."
                (topic_id, topic_pid, topic_imgurl, topic_title)
	            VALUES (".$this->topic_id.", ".$this->topic_pid.", '".$this->topic_imgurl."', '".$myts->addSlashes($this->topic_title)."')";
	    return $this->db->query($sql);
	}
	
	function cleanUp() {
	    return true;
	}
}
?>
