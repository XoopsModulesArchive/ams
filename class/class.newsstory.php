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

include_once __DIR__ . '/xoopsstory.php';
include_once __DIR__ . '/class.newstopic.php';
include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
include_once XOOPS_ROOT_PATH.'/modules/AMS/include/functions.inc.php';

class AmsStory extends AmsXoopsStory
{
    public $newstopic;   // XoopsTopic object
    public $change;
    public $version;
    public $revision;
    public $revisionminor;
    public $current;
    public $texttable;
    public $ratings; //individual ratings
    public $rating; //average rating
    public $updated; //Last update
    public $_errors=array(); //errors encountered
    public $isNew = false;
    public $versionConflict = false;
    public $banner;
    public $VersionNo;
    public $audienceid;
    public $audience;
    public $audiencetable;
    public $_hasVersions = -1;
    public $uname = "";
    public $topic = "";
    public $friendlyurl_enable = -1;
    public $friendlyurl = "";


    public function __construct($storyid = -1, $getRating = false)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->table = $this->db->prefix("ams_article");
        $this->texttable = $this->db->prefix("ams_text");
        $this->topicstable = $this->db->prefix("ams_topics");
        $this->audiencetable = $this->db->prefix("ams_audience");
        if (is_array($storyid)) {
            $this->makeStory($storyid);
            $this->newstopic = $this->topic();
        } elseif ($storyid != -1) {
            $this->getStory(intval($storyid));
            $this->newstopic = $this->topic(true);
            if ($getRating != false) {
                $this->getRatings();
            }
        } else {
            $this->isNew = true;
        }
        $this->setFriendlyUrl('', 1, $this->storyid, 0);
    }

    public function topic($single_topic = false)
    {
        static $topicsCache = array();
        $topicId = $this->topicid();
        if (!isset($topicsCache[$topicId])) {
            $topicsCache = AmsTopic::getAllTopics();
        }
        $this->newstopic = $topicsCache[$this->topicid()];
        return $this->newstopic;
    }

    public function getStory($storyid)
    {
        $sql = "SELECT * FROM ".$this->table." n, ".$this->texttable." t, ".$this->audiencetable." a WHERE n.storyid=t.storyid AND n.audienceid=a.audienceid AND t.current=1 AND n.storyid=".$storyid."";
        $array = $this->db->fetchArray($this->db->query($sql));
        $this->makeStory($array);
    }

    public function hometext($format="Show")
    {
        $myts = MyTextSanitizer::getInstance();
        $html = 1;
        $smiley = 1;
        $xcodes = 1;
        if ($this->nohtml()) {
            $html = 0;
        }
        if ($this->nosmiley()) {
            $smiley = 0;
        }
        switch ($format) {
            case "Show":
            $hometext = $myts->displayTarea($this->hometext, $html, $smiley, $xcodes);
            break;
            case "Edit":
            $hometext = $myts->htmlSpecialChars($this->hometext);
            break;
            case "Preview":
            $hometext = $myts->previewTarea($this->hometext, $html, $smiley, $xcodes);
            break;
            case "InForm":
            $hometext = $myts->htmlSpecialChars($myts->stripSlashesGPC($this->hometext));
            break;
            case "N":
            $hometext = stripslashes($this->hometext);
            break;
        }
        return $hometext;
    }

    public function bodytext($format="Show")
    {
        $myts = MyTextSanitizer::getInstance();
        $html = 1;
        $smiley = 1;
        $xcodes = 1;
        if ($this->nohtml()) {
            $html = 0;
        }
        if ($this->nosmiley()) {
            $smiley = 0;
        }
        switch ($format) {
            case "Show":
            $bodytext = $myts->displayTarea($this->bodytext, $html, $smiley, $xcodes);
            break;
            case "Edit":
            $bodytext = $myts->htmlSpecialChars($this->bodytext);
            break;
            case "Preview":
            $bodytext = $myts->previewTarea($this->bodytext, $html, $smiley, $xcodes);
            break;
            case "InForm":
            $bodytext = $myts->htmlSpecialChars($myts->stripSlashesGPC($this->bodytext));
            break;
            case "N":
            $bodytext = stripslashes($this->bodytext);
            break;
        }
        return $bodytext;
    }

// rag - added $orderdir
    public static function getAllPublished($limit=0, $start=0, $checkRight = false, $topic=0, $ihome=0, $asobject=true, $order = 'published', $ids = false, $orderdir = 'DESC')
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $myts = MyTextSanitizer::getInstance();
        $ret = array();
        $sql = "SELECT * FROM ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t, ".$db->prefix("ams_audience")." a WHERE t.storyid=n.storyid AND n.audienceid=a.audienceid AND published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")";
        if ($topic != 0) {
            if (!is_array($topic)) {
                $sql .= " AND topicid=".intval($topic)." AND (ihome=1 OR ihome=0)";
            } else {
                $sql .= " AND topicid IN (".implode(',', $topic).")";
            }
        } else {
            if ($checkRight) {
                global $xoopsUser, $xoopsModule;
                if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
                    $module_handler = xoops_getHandler('module');
                    $newsModule = $module_handler->getByDirname('AMS');
                } else {
                    $newsModule = $xoopsModule;
                }
                $groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
                $gperm_handler = xoops_getHandler('groupperm');
                $topics = $gperm_handler->getItemIds('ams_view', $groups, $newsModule->getVar('mid'));
                $topics = implode(',', $topics);
                $sql .= " AND topicid IN (".$topics.")";
            }
            if ($ihome == 0) {
                $sql .= " AND ihome=0";
            }
        }
        if ($ids != false) {
            $sql .= " AND n.storyid NOT IN (".implode(',', $ids).")";
        }
        $sql .= " AND t.current=1";
        $sql .= " ORDER BY $order $orderdir";
        $result = $db->query($sql, intval($limit), intval($start));
        while ($myrow = $db->fetchArray($result)) {
            if ($asobject) {
                $ret[] = new AmsStory($myrow);
            } else {
                $ret[$myrow['storyid']] = $myts->htmlSpecialChars($myrow['title']);
            }
        }
        return $ret;
    }

    /*
    * Get all submitted stories awaiting approval
    *
    * @param int $limit Denotes where to start the query
    * @param boolean $asobject true will return the stories as an array of objects, false will return storyid => title
    * @param boolean $checkRight whether to check the user's rights to topics
    */
    public static function getAllSubmitted($limit=0, $asobject=true, $checkRight = false)
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $myts = MyTextSanitizer::getInstance();
        $ret = array();
        $criteria = new CriteriaCompo(new Criteria('published', 0));
        if ($checkRight) {
            global $xoopsUser;
            if (!$xoopsUser) {
                return $ret;
            }
            $groups = $xoopsUser->getGroups();
            $gperm_handler = xoops_getHandler('groupperm');
            global $xoopsModule;
            if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
                $module_handler = xoops_getHandler('module');
                $newsmodule = $module_handler->getByDirname('AMS');
            } else {
                $newsmodule = $xoopsModule;
            }
            $allowedtopics = $gperm_handler->getItemIds('ams_approve', $groups, $newsmodule->getVar('mid'));
            if (count($allowedtopics) == 0) {
                return $ret;
            }
            $criteria2 = new CriteriaCompo();
            $criteria2->add(new Criteria('topicid', "(".implode(',', $allowedtopics).")", 'IN'));
            $criteria->add($criteria2);
        }
        $criteria->setOrder('DESC');
        $criteria->setSort('created');
        $sql = "SELECT * FROM ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t WHERE n.storyid=t.storyid AND t.current=1";
        $sql .= ' AND '.$criteria->render();
        $result = $db->query($sql, $limit, 0);
        while ($myrow = $db->fetchArray($result)) {
            if ($asobject) {
                $ret[] = new AmsStory($myrow);
            } else {
                $ret[$myrow['storyid']] = $myts->htmlSpecialChars($myrow['title']);
            }
        }
        return $ret;
    }

    public function getByTopic($topicid, $limit=0)
    {
        $ret = array();
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT * FROM ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t, ".$db->prefix("ams_audience")." a WHERE n.storyid=t.storyid AND n.audienceid=a.audienceid AND t.current=1 AND topicid=".intval($topicid)." AND published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().") ORDER BY published DESC";
        $result = $db->query($sql, intval($limit), 0);
        while ($myrow = $db->fetchArray($result)) {
            $ret[] = new AmsStory($myrow);
        }
        return $ret;
    }

    public function countByTopic($topicid=0)
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT COUNT(*) FROM ".$db->prefix("ams_article")."
        WHERE expired >= ".time()."";
        if ($topicid != 0) {
            $sql .= " AND  topicid=".intval($topicid);
        }
        $result = $db->query($sql);
        list($count) = $db->fetchRow($result);
        return $count;
    }

    public static function countPublishedByTopic($topicid=0, $checkRight = false)
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT COUNT(*) FROM ".$db->prefix("ams_article")." WHERE published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")";
        if (!empty($topicid)) {
            $sql .= " AND topicid=".intval($topicid);
        } else {
            $sql .= " AND ihome=0";
            if ($checkRight) {
                global $xoopsUser, $xoopsModule;
                if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
                    $module_handler = xoops_getHandler('module');
                    $newsModule = $module_handler->getByDirname('AMS');
                } else {
                    $newsModule = $xoopsModule;
                }
                $groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
                $gperm_handler = xoops_getHandler('groupperm');
                $topics = $gperm_handler->getItemIds('ams_view', $groups, $newsModule->getVar('mid'));
                $topics = implode(',', $topics);
                $sql .= " AND topicid IN (".$topics.")";
            }
        }
        $result = $db->query($sql);
        list($count) = $db->fetchRow($result);
        return $count;
    }

    public static function countPublishedOrderedByTopic($topicid=0, $checkRight = false)
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT topicid, COUNT(*) FROM ".$db->prefix("ams_article")." WHERE published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")";
        if (!empty($topicid)) {
            $sql .= " AND topicid=".intval($topicid);
        } else {
            $sql .= " AND ihome=0";
            if ($checkRight) {
                global $xoopsUser, $xoopsModule;
                if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
                    $module_handler = xoops_getHandler('module');
                    $newsModule = $module_handler->getByDirname('AMS');
                } else {
                    $newsModule = $xoopsModule;
                }
                $groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
                $gperm_handler = xoops_getHandler('groupperm');
                $topics = $gperm_handler->getItemIds('ams_view', $groups, $newsModule->getVar('mid'));
                $topics = implode(',', $topics);
                $sql .= " AND topicid IN (".$topics.")";
            }
        }
        $sql .= " GROUP BY topicid";
        $result = $db->query($sql);
        while (list($id, $count) = $db->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }

    public function countReads()
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT SUM(counter) FROM ".$db->prefix('ams_article')." WHERE published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")";
        $result = $db->query($sql);
        list($count) = $db->fetchRow($result);
        return $count;
    }

    public function topic_title()
    {
        return $this->newstopic->topic_title();
    }

    public function imglink($show_avatar = false, $users = false)
    {
        $ret = '';
        if (false != $show_avatar && $this->uid() > 0) {
            if (!isset($users[$this->uid()])) {
                $member_handler = xoops_getHandler('member');
                $author = $member_handler->getUser($this->uid);
            } else {
                $author = $users[$this->uid()];
            }
            if ($author->getVar('user_avatar') != "" && $author->getVar('user_avatar') != "blank.gif") {
                return "<a href='".XOOPS_URL."/userinfo.php?uid=".$author->getVar('uid')."'><img src='".XOOPS_URL."/uploads/".$author->getVar('user_avatar')."' alt='".$this->newstopic->topic_title()."' hspace='10' vspace='10' align='".$this->topicalign()."' /></a>";
            }
        }
        if (!is_object($this->newstopic)) {
            $this->topic();
        }
        if ($this->newstopic->topic_imgurl() != '' && file_exists(XOOPS_ROOT_PATH."/modules/AMS/assets/images/topics/".$this->newstopic->topic_imgurl())) {
            $ret = "<a href='".XOOPS_URL."/modules/AMS/index.php?storytopic=".$this->topicid."'><img src='".XOOPS_URL."/modules/AMS/assets/images/topics/".$this->newstopic->topic_imgurl()."' alt='".$this->newstopic->topic_title()."' hspace='10' vspace='10' align='".$this->topicalign()."' /></a>";
        }
        return $ret;
    }

    public function uname($users = false)
    {
        if ($this->uid == 0) {
            $this->uname = $GLOBALS['xoopsConfig']['anonymous'];
            return array();
        }
        global $xoopsModule, $xoopsModuleConfig;
        if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
            $module_handler = xoops_getHandler('module');
            $module = $module_handler->getByDirname("AMS");
            $config_handler = xoops_getHandler('config');
            if ($module) {
                $moduleConfig = $config_handler->getConfigsByCat(0, $module->getVar('mid'));
                $option= $moduleConfig['displayname'];
            } else {
                $option= 1;
            }
        } else {
            $option = $xoopsModuleConfig['displayname'];
        }
        if ($users != false && isset($users[$this->uid()])) {
            $author = $users[$this->uid()];
            switch ($option) {
                case 1:        // Username
                $this->uname = $author->getVar('uname');
                break;
                case 2:        // Display full name (if it is not empty)
                if ($author->getVar('name') == "") {
                    $this->uname = $author->getVar('uname');
                    break;
                }
                $this->uname = $author->getVar('name');
                break;
                case 3:        // Nothing
                $this->uname = '';
                break;
            }
        } else {
            switch ($option) {
                case 1:        // Username
                $author = new XoopsUser($this->uid());
                $this->uname = $author->getVar('uname');
                break;
                case 2:        // Display full name (if it is not empty)
                $author = new XoopsUser($this->uid());
                if ($author->getVar('name') == "") {
                    $this->uname = $author->getVar('uname');
                    break;
                }
                $this->uname = $author->getVar('name');
                break;
                case 3:        // Nothing
                $this->uname = '';
                break;
            }
        }
        return $author;
    }

    public function setChange($change)
    {
        $this->change = $change;
    }

    public function store($approved = false)
    {
        $myts = MyTextSanitizer::getInstance();
        $title =$myts->censorString($this->title);
        $title = $myts->addSlashes($title);
        if (!isset($this->nohtml) || $this->nohtml != 1) {
            $this->nohtml = 0;
        }
        if (!isset($this->nosmiley) || $this->nosmiley != 1) {
            $this->nosmiley = 0;
        }
        if (!isset($this->notifypub) || $this->notifypub != 1) {
            $this->notifypub = 0;
        }
        $expired = !empty($this->expired) ? $this->expired : 0;
        if (!isset($this->storyid)) {
            $newstoryid = $this->db->genId($this->table."_storyid_seq");
            $created = time();
            $published = ($this->approved) ? $this->published : 0;
            $this->isNew = true;
            $sql = sprintf("INSERT INTO %s (storyid, title, created, published, expired, hostname, nohtml, nosmiley, counter, topicid, ihome, notifypub, story_type, topicdisplay, topicalign, comments, banner, audienceid) VALUES (%u, '%s', %u, %u, %u, '%s', %u, %u, %u, %u, %u, %u, '%s', %u, '%s', %u, '%s', %u)", $this->table, $newstoryid, $title, $created, $published, $expired, $this->hostname, $this->nohtml, $this->nosmiley, 0, $this->topicid, $this->ihome, $this->notifypub, $this->type, $this->topicdisplay, $this->topicalign, $this->comments, $myts->addSlashes($this->banner), $this->audienceid);
            if (!$this->db->query($sql)) {
                $this->_errors[] = _AMS_NW_SAVEFAILED;
                return false;
            }
            $newstoryid = $this->db->getInsertId();
            $this->storyid = $newstoryid;
            $this->calculateVersion();
            if (!$this->updateVersion()) {
                return false;
            }
        } else {
            if ($this->approved) {
                $sql = sprintf("UPDATE %s SET title = '%s', published = %u, expired = %u, nohtml = %u, nosmiley = %u, topicid = %u, ihome = %u, topicdisplay = %u, topicalign = '%s', comments = %u, banner = '%s', audienceid=%u WHERE storyid = %u", $this->table, $title, $this->published, $expired, $this->nohtml, $this->nosmiley, $this->topicid, $this->ihome, $this->topicdisplay, $this->topicalign, $this->comments, $myts->addSlashes($this->banner), $this->audienceid, $this->storyid);
            } else {
                $sql = sprintf("UPDATE %s SET title = '%s', published = 0, expired = %u, nohtml = %u, nosmiley = %u, topicid = %u, ihome = %u, topicdisplay = %u, topicalign = '%s', comments = %u, banner= '%s' WHERE storyid = %u", $this->table, $title, $expired, $this->nohtml, $this->nosmiley, $this->topicid, $this->ihome, $this->topicdisplay, $this->topicalign, $this->comments, $myts->addSlashes($this->banner), $this->storyid);
            }
            $newstoryid = $this->storyid;
            $this->isNew = false;
            if (!$this->db->query($sql)) {
                $this->_errors[] = _AMS_NW_SAVEFAILED;
                return false;
            }

            if ($this->change > 0) {
                $this->calculateVersion();
                if (!$this->updateVersion()) {
                    return false;
                }
            }
        }
        return $newstoryid;
    }

    public function delete()
    {
        $links = $this->getLinks();
        if (count($links)>0) {
            foreach ($links as $thislink) {
                $this->deleteLink($thislink['linkid']);
            }
        }
        if (count($this->_errors)>0) {
            return false;
        }
        parent::delete();
        $sql = "DELETE FROM ".$this->texttable." WHERE storyid=".$this->storyid;
        return $this->db->query($sql);
    }

    public function setCurrentVersion($version, $revision, $revisionminor)
    {
        $version = intval($version);
        $revision = intval($revision);
        $revisionminor = intval($revisionminor);
        $sql = "UPDATE ".$this->texttable." SET current=0 WHERE storyid=".$this->storyid;
        if (!$this->db->query($sql)) {
            $this->_errors[] = _AMS_NW_COULDNOTRESET;
            return false;
        }
        $sql = "UPDATE ".$this->texttable." SET current=1 WHERE storyid=".$this->storyid." AND version=".$version." AND revision=".$revision." AND revisionminor=".$revisionminor;
        if (!$this->db->query($sql)) {
            $this->_errors[] = _AMS_NW_COULDNOTUPDATEVERSION;
            return false;
        }
        return true;
    }

    public function getVersions($only_higher = false)
    {
        $clause = "";
        if (false != $only_higher) {
            if ($this->change == 1) {
                $clause = " AND version >= ".$this->version;
            } elseif ($this->change == 2) {
                $clause = " AND version = ".$this->version." AND revision >= ".$this->revision;
            } elseif ($this->change == 3) {
                $clause = " AND version = ".$this->version." AND revision = ".$this->revision." AND revisionminor >= ".$this->revisionminor;
            }
        }
        $sql = "SELECT * FROM ".$this->texttable." WHERE storyid=".$this->storyid."$clause ORDER BY version DESC, revision DESC, revisionminor DESC";
        $result = $this->db->query($sql);
        $ret = array();
        $i = 0;
        while ($row = $this->db->fetchArray($result)) {
            $ret[$i] = $row;
            $ret[$i]['poster'] = XoopsUser::getUnameFromId($row['uid']);
            $ret[$i]['posttime'] = formatTimestamp($row['updated']);
            $i++;
        }
        return $ret;
    }

    public function updateVersion()
    {
        $myts = MyTextSanitizer::getInstance();
        $hometext = $myts->censorString($this->hometext);
        $bodytext = $myts->censorString($this->bodytext);
        $hometext = addslashes($hometext);
        $bodytext = addslashes($bodytext);
        $sql = "INSERT INTO ".$this->texttable." VALUES ($this->storyid, ".$this->version.", ".$this->revision.", ".$this->revisionminor.", ".$this->uid.", '".$hometext."', '".$bodytext."', 0, ".time().")";
        if (!$this->db->query($sql)) {
            $this->_errors[] = _AMS_NW_TEXTSAVEFAILED;
            return false;
        }
        if (!$this->setCurrentVersion($this->version, $this->revision, $this->revisionminor)) {
            $this->_errors[] = _AMS_NW_VERSIONUPDATEFAILED;
            return false;
        }
        return true;
    }

    public function calculateVersion($recursive = false)
    {
        if ($this->isNew == true) {
            $this->version = 1;
            $this->revision = 0;
            $this->revisionminor = 0;
            return true;
        }
        if ($this->change == 1) {
            $this->version = $this->version + 1;
            $this->revision = 0;
            $this->revisionminor = 0;
        } elseif ($this->change == 2) {
            $this->revision = $this->revision + 1;
            $this->revisionminor = 0;
        } elseif ($this->change == 3) {
            $this->revisionminor = $this->revisionminor + 1;
        }
        $sql = "SELECT COUNT(*) FROM ".$this->texttable." WHERE storyid=".$this->storyid." AND version=".$this->version." AND revision=".$this->revision." AND revisionminor=".$this->revisionminor;
        $result = $this->db->query($sql);
        list($conflict) = $this->db->fetchRow($result);
        if ($conflict > 0) {
            if (false != $recursive) {
                return $this->calculateVersion(true);
            } else {
                $this->versionConflict = true;
                return false;
            }
        }
        return true;
    }

    public function overrideVersion()
    {
        $versions = $this->getVersions(true);
        if (count($versions) > 0) {
            foreach ($versions as $key => $thisversion) {
                $this->db->query("DELETE FROM ".$this->texttable." WHERE storyid=".$this->storyid." AND version=".$thisversion['version']." AND revision=".$thisversion['revision']." AND revisionminor=".$thisversion['revisionminor']);
            }
        }
        return $this->updateVersion();
    }

    public function hasVersions()
    {
        if ($this->_hasVersions == -1) {
            $sql = "SELECT count(*) FROM ".$this->texttable." WHERE storyid=".$this->storyid;
            $result = $this->db->query($sql);
            list($count) = $this->db->fetchRow($result);
            $this->_hasVersions = $count-1;
        }
        return $this->_hasVersions;
    }

    public function getRatings()
    {
        $sql = "SELECT * FROM ".$this->db->prefix("ams_rating")." WHERE storyid = ".$this->storyid;
        if ($result = $this->db->query($sql)) {
            $ratings = array();
            while ($row = $this->db->fetchArray($result)) {
                $ratings[] = $row;
            }
            $this->ratings = $ratings;
        }
    }

    public function getRating()
    {
        if (count($this->rating) < 1) {
            if (empty($this->ratings)) {
                $this->getRatings();
            }
            $ratingcount = count($this->ratings);
            if ($ratingcount == 0) {
                return 0;
            }
            $rating = 0;
            foreach ($this->ratings as $key => $thisrating) {
                $rating += $thisrating['rating'];
            }
            $this->rating = round($rating/($ratingcount * 2), 0);
        }
        return $this->rating;
    }

    public function rateStory($rating)
    {
        global $xoopsUser, $xoopsModuleConfig;
        $rating = intval($rating);
        if (empty($this->ratings)) {
            $this->getRatings();
        }
        $ip = getenv("REMOTE_ADDR");
        if (!$xoopsUser) {
            if ($xoopsModuleConfig['anonymous_vote'] == 0) {
                $this->_errors[] = _AMS_NW_ANONYMOUSVOTEDISABLED;
                return false;
            }
            $ratinguser = 0;
            if (count($this->ratings) > 0) {
                foreach ($this->ratings as $key => $thisrating) {
                    if ($ip == $thisrating['ratinghostname']) {
                        $this->_errors[] = _AMS_NW_ANONYMOUSHASVOTED;
                        return false;
                    }
                }
            }
        } else {
            $ratinguser = $xoopsUser->uid();
            if ($ratinguser == $this->uid()) {
                $this->_errors[] = _AMS_NW_CANNOTVOTESELF;
                return false;
            }
            foreach ($this->ratings as $key => $thisrating) {
                if ($ratinguser == $thisrating['ratinguser']) {
                    $this->_errors[] = _AMS_NW_USERHASVOTED;
                    return false;
                }
            }
        }

        //Insert rating
        if (!$this->saveRating($rating, $ratinguser, $ip)) {
            return false;
        }
        //Update story's average rating
        if (!$this->updateAvgRating()) {
            return false;
        }
        return true;
    }

    public function saveRating($rating, $uid, $hostname)
    {
        $rating = intval($rating);
        $uid = intval($uid);
        $sql = "INSERT INTO ".$this->db->prefix("ams_rating")." (storyid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (".$this->storyid.", $uid, $rating, ".$this->db->quoteString($hostname).", ".time().")";
        if ($this->db->query($sql)) {
            $this->ratings[] = array('storyid' => $this->storyid,
            'ratinguser' => $uid,
            'rating' => $rating,
            'ratinghostname' => $hostname,
            'ratingtimestamp' => time());
            return true;
        }
        $this->_errors[] = _AMS_NW_COULDNOTSAVERATING;
        $this->_errors[] = $sql;
        return false;
    }

    public function updateAvgRating()
    {
        $totalrating = 0;
        $totalvotes = count($this->ratings);
        if ($totalvotes > 0) {
            foreach ($this->ratings as $key => $rating) {
                $totalrating += $rating['rating'];
            }
            $this->rating = round($totalrating/$totalvotes/2, 0);
        }
        $sql = "UPDATE ".$this->table." SET rating=".$this->rating." WHERE storyid=".$this->storyid;
        if (!$this->db->query($sql)) {
            $this->_errors[] = _AMS_NW_COULDNOTUPDATERATING;
            $this->_errors[] = $sql;
            return false;
        }
        return true;
    }

    public function addLink($moduleid, $link, $title, $position)
    {
        $linkHandler = xoops_getModuleHandler('link', 'AMS');
        $thisLink = $linkHandler->create();
        $thisLink->setVar('storyid', $this->storyid);
        $thisLink->setVar('link_module', intval($moduleid));
        $thisLink->setVar('link_link', $link);
        $thisLink->setVar('link_title', $title);
        $thisLink->setVar('link_position', $position);

        if (!$linkHandler->insert($thisLink)) {
            $this->_errors[] = _AMS_NW_COULDNOTADDLINK;
            return false;
        }
        return true;
    }

    public function deleteLink($linkid)
    {
        $linkHandler = xoops_getModuleHandler('link', 'AMS');
        $link = $linkHandler->create(false);
        $link->setVar('linkid', intval($linkid));
        if (!$linkHandler->delete($link)) {
            $this->_errors[] = _AMS_NW_COULDNOTDELLINK;
            return false;
        }
        return true;
    }

    public function getLinks()
    {
        $linkHandler = xoops_getModuleHandler('link', 'AMS');
        return $linkHandler->getByStory($this->storyid);
    }

    public function renderErrors()
    {
        if (count($this->_errors) == 0) {
            return _AMS_NW_NOERRORSENCOUNTERED;
        }
        $ret = "";
        foreach ($this->_errors as $key => $error) {
            $ret = $error."</br>";
        }
        return $ret;
    }

    public function toArray($admin = false, $pagenav = false, $storypage = 0, $users = false)
    {
        global $xoopsUser, $xoopsModule, $xoopsConfig;
        $story['id'] = $this->storyid;
        $story['posttimestamp'] = $this->published();
        $story['posttime'] = formatTimestamp($this->published());
        $story['topic'] = $this->newstopic->topic_title();
        $story['topicid'] = $this->topicid();
        $story['title'] = $this->title();
        $story['hometext'] = $this->hometext();
        $story['friendlyurl_enable'] = $this->friendlyurl_enable;
        $story['friendlyurl'] = $this->friendlyurl;

        $bodytext = $this->bodytext();
        if (trim($bodytext) != '') {
            if (false != $pagenav) {
                $articletext = explode("[pagebreak]", $bodytext);
                $story_pages = count($articletext);
                if ($story_pages > 1 && $storypage != -1) {
                    global $xoopsTpl;
                    include_once XOOPS_ROOT_PATH.'/modules/AMS/class/pagenav.php';
                    $pagenav = new AMSPageNav($story_pages, 1, $storypage, 'page', 'storyid='.$this->storyid, $this->friendlyurl_enable, $this->friendlyurl);
                    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
                    $story['bodytext'] = $articletext[$storypage];
                } elseif ($story_pages > 1) {
                    $story['bodytext'] = implode('<br /><b>'._AMS_MA_PAGEBREAK."</b><br />", $articletext);
                } else {
                    $story['bodytext'] = $bodytext;
                }
            } else {
                $articletext = explode("[pagebreak]", $bodytext);
                $story_pages = count($articletext);
                if ($story_pages > 1 && $storypage == -1) {
                    $story['bodytext'] = implode('<br /><b>'._AMS_MA_PAGEBREAK."</b><br />", $articletext);
                } else {
                    $story['bodytext'] = $bodytext;
                }
            }
        }
        if ($this->uname == "") {
            $users = array($this->uid() => $this->uname($users));
        }
        $story['poster'] = $this->uname;
        if ($story['poster']) {
            $story['posterid'] = $this->uid();
            $story['poster'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$story['posterid'].'">'.$story['poster'].'</a>';
        }
        $revision = $this->revision < 10 ? "0".$this->revision : $this->revision;
        if ($this->revisionminor > 0) {
            $revisionminor = $this->revisionminor < 10 ? ".0".$this->revisionminor : ".".$this->revisionminor;
        } else {
            $revisionminor = "";
        }
        $story['version'] = $this->version;
        $story['revision'] = $revision;
        $story['revisionminor'] = $revisionminor;

        $story['fullcount'] = substr_count(trim($this->bodytext()), ' ');
        $story['bytestext'] = _AMS_NW_READMORE;

        $ccount = $this->comments();
        if ($ccount == 0) {
            $story['comments'] = _AMS_NW_COMMENTS;
        } elseif ($ccount == 1) {
            $story['comments'] = _AMS_NW_ONECOMMENT;
        } else {
            $story['comments'] = sprintf(_AMS_NW_NUMCOMMENTS, $ccount);
        }

        $story['topicid'] = $this->topicid();
        $story['imglink'] = '';
        $story['align'] = '';
        if ($this->topicdisplay() > 0) {
            $story['imglink'] = $this->imglink($this->topicdisplay() == 2, $users);
            $story['align'] = $this->topicalign();
        }
        $story['ratingimage'] = XOOPS_URL."/modules/AMS/assets/images/rate".$this->getRating().".gif";
        $story['rating'] = $this->getRating();
        $story['hits'] = $this->counter();
        $story['mail_link'] = 'mailto:?subject='.sprintf(_AMS_NW_INTARTICLE, $xoopsConfig['sitename']).'&amp;body='.sprintf(_AMS_NW_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/AMS/article.php?storyid='.$this->storyid();
        $story['audience'] = $this->audience;
        $story['forum'] = $this->newstopic->forum_id;
        if ($pagenav) {
            $story['hasversions'] = $this->hasVersions() ? 1 : 0;
        }
        return $story;
    }

    public function delversions($version, $revision, $minor)
    {
        $version = intval($version);
        $revision = intval($revision);
        $minor = intval($minor);
        $sql = "DELETE FROM ".$this->db->prefix('ams_text')." WHERE storyid=".intval($this->storyid)."
                AND (
               (version < $version) OR 
               (version = $version AND revision < $revision) OR 
               (version = $version AND revision = $revision AND revisionminor < $minor)
               )";
        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    public function delallversions($version, $revision, $minor)
    {
        if (!$this->setCurrentVersion($version, $revision, $minor)) {
            return false;
        }
        $sql = "DELETE FROM ".$this->db->prefix('ams_text')." WHERE storyid=".intval($this->storyid)." AND current=0";
        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    public function version()
    {
        $revision = $this->revision < 10 ? "0".$this->revision : $this->revision;
        if ($this->revisionminor > 0) {
            $revisionminor = $this->revisionminor < 10 ? ".0".$this->revisionminor : ".".$this->revisionminor;
        } else {
            $revisionminor = "";
        }
        $story['version'] = $this->version;
        $story['revision'] = $revision;
        $story['revisionminor'] = $revisionminor;
        return $story['version'].".".$story['revision'].$story['revisionminor'];
    }

    public function getBanner()
    {
        if ($this->banner) {
            return $this->banner;
        } else {
            return $this->newstopic->getBanner();
        }
    }

    public function getNewsVersion($storyid, $version, $revision, $revisionminor = 0)
    {
        $sql = "SELECT * FROM ".$this->db->prefix("ams_article")." n, ".$this->db->prefix("ams_text")." t
                  WHERE t.storyid=n.storyid 
                  AND t.storyid=".intval($storyid)."
                  AND t.version=".intval($version)."
                  AND t.revision=".intval($revision)."
                  AND t.revisionminor=".intval($revisionminor);
        $result = $this->db->query($sql);
        $row = $this->db->fetchArray($result);
        $this->makeStory($row);
        $this->newstopic = $this->topic(true);
    }

    /**
    * Static method
    */
    public static function getAllNews($limit, $start = 0, $criteria = null)
    {
        $ret = array();
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        // @todo rework SQL to prevent 1055 error
        $setSqlMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
        $db->queryF($setSqlMode);

        if ($criteria == null) {
            $criteria = new Criteria();
        }
        $criteria->setLimit($limit);
        $criteria->setStart($start);
        $sql = "SELECT n.*, t.*, a.* FROM ".$db->prefix('ams_article')." n, ".$db->prefix('ams_text')." t, ".$db->prefix('ams_audience')." a WHERE n.storyid=t.storyid AND n.audienceid=a.audienceid AND n.published != 0 AND t.current=1";
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $render = $criteria->render();
            if ($render != "") {
                $sql .= ' AND '.$render;
            }
            $sql .= " GROUP BY n.storyid";
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $db->fetchArray($result)) {
            $story = new AmsStory();
            $story->makeStory($myrow);
            $ret[$myrow['storyid']] = $story;
            unset($story);
        }
        return $ret;
    }

    /**
    * Static method to get version counts for selected articles
    */
    public static function getVersionCounts($storyids = array())
    {
        if ($storyids == array()) {
            return false;
        }
        $ret = array();
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT storyid, count(version) AS VersionCount FROM ".$db->prefix('ams_text')." WHERE storyid IN (".implode(',', $storyids).") GROUP BY storyid";
        $result = $db->query($sql);
        while ($row = $db->fetchArray($result)) {
            $ret[$row['storyid']] = $row['VersionCount'];
        }
        return $ret;
    }

    /**
    * Static method to get author data
    */
    public function getAuthors($limit = 5, $sort = "count", $name = 'uname', $compute_method = "average")
    {
        $limit = intval($limit);
        if ($name != "uname") {
            $name = "name"; //making sure that there is not invalid information in field value
        }
        $ret = array();
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        if ($sort == "count") {
            $sql = "SELECT u.".$name." AS name, u.uid , count( n.storyid ) AS count
                    FROM ".$db->prefix("users")." u, ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t
                    WHERE n.storyid = t.storyid AND u.uid = t.uid AND t.current = 1
                       AND published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")
                    GROUP BY u.uid ORDER BY count DESC";
        } elseif ($sort == "read") {
            if ($compute_method == "average") {
                $compute = "sum( n.counter ) / count( n.storyid )";
            } else {
                $compute = "sum( n.counter )";
            }
            $sql = "SELECT u.".$name." AS name, u.uid , $compute AS count
                    FROM ".$db->prefix("users")." u, ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t
                    WHERE n.storyid = t.storyid AND u.uid = t.uid AND t.current =1
                       AND published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")
                    GROUP BY u.uid ORDER BY count DESC";
        } else {
            if ($compute_method == "average") {
                $compute = "sum( n.rating ) / count( n.storyid )";
            } else {
                $compute = "sum( n.rating )";
            }
            $sql = "SELECT u.".$name." AS name, u.uid, $compute AS count
                    FROM ".$db->prefix("users")." u, ".$db->prefix("ams_article")." n, ".$db->prefix("ams_text")." t
                    WHERE n.storyid = t.storyid AND u.uid = t.uid AND t.current =1 AND n.rating >0
                       AND published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().")
                    GROUP BY u.uid ORDER BY count DESC";
        }
        if (!$result = $db->query($sql, $limit)) {
            return false;
        }
        while ($row = $db->fetchArray($result)) {
            if ($name == "name" && $row['name'] == '') {
                $row['name'] = XoopsUser::getUnameFromId($row['uid']);
            }
            $row['count'] = round($row['count'], 0);
            $ret[] = $row;
        }
        return $ret;
    }

    public function getPath($withAllLink = false)
    {
        if (!$withAllLink) {
            return $this->newstopic->getTopicPath(true)." > ".$this->title();
        } else {
            return $this->newstopic->getTopicPath(true)." > <a href='".$this->setFriendlyUrl('article.php?storyid='.$this->storyid, 1, $this->storyid, 0). "'>".$this->title()."</a>";
        }
    }

    public function setFriendlyUrl($url='', $op=0, $id=0, $pg=0)
    {
        if ($this->friendlyurl_enable == -1) {  //if  called 1st time
            $this->newstopic = new AmsTopic($this->topicstable, $this->topicid());  //workaround due to destructive getTopicPath
            $this->topic = $this->newstopic->getTopicPath(false, '/', false);
            $this->newstopic = new AmsTopic($this->topicstable, $this->topicid());  //workaround due to destructive getTopicPath
            $this->friendlyurl=AMS_SEO_genURL($this->title, $this->audience, $this->topic, $op, $id, $pg);
            if (!($this->friendlyurl==false)) {
                $this->friendlyurl_enable=1; //mark it as enabled and friendlyurl is valid
                return $this->friendlyurl;
            } else {
                $this->friendlyurl_enable=0; //mark it as disabled and friendlyurl is invalid
                return $url;
            }
        } elseif ($this->friendlyurl_enable==1) {
            return $this->friendlyurl;
        } else {
            return $url;
        }
    }
}
