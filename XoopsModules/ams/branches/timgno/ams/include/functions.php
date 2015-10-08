<?php   
/**
 * ****************************************************************************
 *       - Original Copyright (TDM)
 *       - TDMCreate By TDM - TEAM DEV MODULE FOR XOOPS
 *       - Licence GPL Copyright (c) (http://www.tdmxoops.net)
 *       - Developers TEAM TDMCreate Xoops - (http://www.xoops.org)
 * ****************************************************************************
 *       ams - MODULE FOR XOOPS
 *        Copyright (c) 2007 - 2011
 *       TXMod Xoops (http://www.txmodxoops.org)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  ------------------------------------------------------------------------
 *
 * @copyright       TXMod Xoops (http://www.txmodxoops.org)
 * @license         GPL see LICENSE
 * @package         ams
 * @author          TXMod Xoops (info@txmodxoops.org)
 *
 * Version : 3.01 Thu 2011/11/24 6:00:35 : Timgno Exp $
 * ****************************************************************************
 */
 	

/***************Blocks***************/
function ams_block_addCatSelect($cats) {
	if(is_array($cats)) 
	{
		$cat_sql = "(".current($cats);
		array_shift($cats);
		foreach($cats as $cat) 
		{
			$cat_sql .= ",".$cat;
		}
		$cat_sql .= ")";
	}
	return $cat_sql;
}

function ams_checkModuleAdmin()
{
    if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        return true;
    }else{
	    xoops_cp_header();
        echo xoops_error(_AM_ams_NOFRAMEWORKS);
		xoops_cp_footer();
        return false;
    }
}

function ams_MygetItemIds($permtype,$dirname)
{
    global $xoopsUser;
    static $permissions = array();
    if(is_array($permissions) && array_key_exists($permtype, $permissions)) {
        return $permissions[$permtype];
    }
       $module_handler =& xoops_gethandler('module');
       $myModule =& $module_handler->getByDirname($dirname);
       $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
       $gperm_handler =& xoops_gethandler('groupperm');
       $ret = $gperm_handler->getItemIds($permtype, $groups, $myModule->getVar('mid'));
    return $ret;
}

function ams_CleanVars( &$global, $key, $default = '', $type = 'int' ) {
    switch ( $type ) {
        case 'string':
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_MAGIC_QUOTES ) : $default;
            break;
        case 'int': default:
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_NUMBER_INT ) : $default;
            break;
    }
    if ( $ret === false ) {
        return $default;
    }
    return $ret;
}

function ams_pathTree($mytree, $key, $topic_array, $title, $prefix = '' )
{
    $topic_parent = $mytree->getAllParent($key);
    $topic_parent = array_reverse($topic_parent);
    $path = '';
    foreach (array_keys($topic_parent) as $j) {
        $path .= $topic_parent[$j]->getVar($title) . $prefix;
    }
    if (array_key_exists($key, $topic_array)){
        $first_topic = $topic_array[$key]->getVar($title);
    }else{
        $first_topic = '';
    }
    $path .= $first_topic;
    return $path;
}

function ams_pathTreeUrl($mytree, $key, $topic_array, $title, $prefix = '', $link = false, $order = 'ASC', $lasturl = false)
{
    global $xoopsModule;
    $topic_parent = $mytree->getAllParent($key);
    if ($order == 'ASC'){
        $topic_parent = array_reverse($topic_parent);
        if ($link == true) {
            $path = '<a href="index.php">' . $xoopsModule->name() . '</a>' . $prefix;
        }else{
            $path = $xoopsModule->name() . $prefix;
        }
    }else{
        if (array_key_exists($key, $topic_array)){
            $first_topic = $topic_array[$key]->getVar($title);
        }else{
            $first_topic = '';
        }
        $path = $first_topic . $prefix;
    }
    foreach (array_keys($topic_parent) as $j) {
        if ($link == true) {
            $path .= '<a href="viewcat.php?cid=' . $topic_parent[$j]->getVar('cat_cid') . '">' . $topic_parent[$j]->getVar($title) . '</a>' . $prefix;
        }else{
            $path .= $topic_parent[$j]->getVar($title) . $prefix;
        }
    }
    if ($order == 'ASC'){
        if (array_key_exists($key, $topic_array)){
            if ($lasturl == true){
                $first_topic = '<a href="viewcat.php?cid=' . $topic_array[$key]->getVar('cat_cid') . '">' . $topic_array[$key]->getVar($title) . '</a>';
            }else{
                $first_topic = $topic_array[$key]->getVar($title);
            }
        }else{
            $first_topic = '';
        }
        $path .= $first_topic;
    }else{
        if ($link == true) {
            $path .= '<a href="index.php">' . $xoopsModule->name() . '</a>';
        }else{
            $path .= $xoopsModule->name();
        }
    }
    return $path;
}

function xoops_meta_keywords($content)
{
	global $xoopsTpl, $xoTheme;
	$myts =& MyTextSanitizer::getInstance();
	$content= $myts->undoHtmlSpecialChars($myts->displayTbox($content));
	if(isset($xoTheme) && is_object($xoTheme)) {
		$xoTheme->addMeta( 'meta', 'keywords', strip_tags($content));
	} else {	// Compatibility for old Xoops versions
		$xoopsTpl->assign('xoops_meta_keywords', strip_tags($content));
	}
}

function xoops_meta_description($content)
{
	global $xoopsTpl, $xoTheme;
	$myts =& MyTextSanitizer::getInstance();
	$content= $myts->undoHtmlSpecialChars($myts->displayTarea($content));
	if(isset($xoTheme) && is_object($xoTheme)) {
		$xoTheme->addMeta( 'meta', 'description', strip_tags($content));
	} else {	// Compatibility for old Xoops versions
		$xoopsTpl->assign('xoops_meta_description', strip_tags($content));
	}
}

//create in ams 2.50 but for future CLONEABLE ability
function ams_setcookie($name, $string = '', $expire = 0)
{
	global $amsCookie;
	if(is_array($string)) {
		$value = array();
		foreach ($string as $key => $val){
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	setcookie($amsCookie['prefix'].$name, $string, intval($expire), $amsCookie['path'], $amsCookie['domain'], $amsCookie['secure']);
}

//create in ams 2.50 but for future CLONEABLE ability
function ams_getcookie($name, $isArray = false)
{
	global $amsCookie;
	$value = !empty($_COOKIE[$amsCookie['prefix'].$name]) ? $_COOKIE[$amsCookie['prefix'].$name] : null;
	if($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if(count($_value)>0) foreach($_value as $string){
			$sep = strpos($string,"|");
			if($sep===false){
				$value[]=$string;
			}else{
				$key = substr($string, 0, $sep);
				$val = substr($string, ($sep+1));
				$value[$key] = $val;
			}
		}
		unset($_value);
	}
	return $value;
}

/**
 * Remove module's cache
 *
 * @package ams
 * @author Instant Zero (http://xoops.instant-zero.com)
 * @copyright (c) Instant Zero
*/
function ams_updateCache() {
	global $xoopsModule;
    if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "ams") {
        $mod_handler =& xoops_gethandler('module');
        $amsModule =& $mod_handler->getByDirname('ams');
    }
    else {
        $amsModule =& $xoopsModule;
    }
	$folder = $amsModule->getVar('dirname');
	$tpllist = array();
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
	include_once XOOPS_ROOT_PATH.'/class/template.php';
	$tplfile_handler =& xoops_gethandler('tplfile');
	$tpllist = $tplfile_handler->find(null, null, null, $folder);
	$xoopsTpl = new XoopsTpl();
	xoops_template_clear_module_cache($amsModule->getVar('mid'));			// Clear module's blocks cache

    //remove RSS cache (XOOPS, ImpressCMS)
    $files_del = array();
    $files_del = glob(XOOPS_CACHE_PATH.'/*system_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }
    $files_del = array();
    $files_del = glob(XOOPS_COMPILE_PATH.'/*system_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }
    $files_del = array();
    $files_del = glob($xoopsTpl->cache_dir.'/*system_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }

    //remove RSS cache (XOOPS CUBE)
    $files_del = array();
    $files_del = glob(XOOPS_CACHE_PATH.'/*legacy_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }
    $files_del = array();
    $files_del = glob(XOOPS_COMPILE_PATH.'/*legacy_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }
    $files_del = array();
    $files_del = glob($xoopsTpl->cache_dir.'/*legacy_rss*');
    if(count($files_del) >0) {
        foreach($files_del as $one_file) {
            unlink($one_file);
        }
    }
     
	// Remove cache for each page.
	foreach ($tpllist as $onetemplate) {
		if( $onetemplate->getVar('tpl_type') == 'module' ) {
			// Note, I've been testing all the other methods (like the one of Smarty) and none of them run, that's why I have used this code
			$files_del = array();
			$files_del = glob(XOOPS_CACHE_PATH.'/*'.$onetemplate->getVar('tpl_file').'*');
			if(count($files_del) >0) {
				foreach($files_del as $one_file) {
					unlink($one_file);
				}
			}
            $files_del = array();
            $files_del = glob(XOOPS_COMPILE_PATH.'/*'.$onetemplate->getVar('tpl_file').'*');
            if(count($files_del) >0) {
                foreach($files_del as $one_file) {
                    unlink($one_file);
                }
            }
            $files_del = array();
            $files_del = glob($xoopsTpl->cache_dir.'/*'.$onetemplate->getVar('tpl_file').'*');
            if(count($files_del) >0) {
                foreach($files_del as $one_file) {
                    unlink($one_file);
                }
            }
            
		}
	}
}

//Added ams 3.0. Source from smartsection code
function ams_seo_title($title='',$op=0,$id=0,$pg=0)
{
    /** 
     * if XOOPS ML is present, let's sanitize the title with the current language
     */
    
     $myts = MyTextSanitizer::getInstance();
     if (method_exists($myts, 'formatForML')) {
        $title = $myts->formatForML($title);
     }

    // Transformation de la chaine en minuscule
    // Codage de la chaine afin d'éviter les erreurs 500 en cas de caractères imprévus
    $title   = rawurlencode(strtolower($title));    
    
    // avoid problem caused by rawurlencode which convert % to %25
    //                 Tab     Space      !        "        #        %        &        '        (        )        ,        /        :        ;        <        =        >        ?        @        [        \        ]        ^        {        |        }        ~       .
    $pattern = array("/%2509/", "/%2520/", "/%2521/", "/%2522/", "/%2523/", "/%2525/", "/%2526/", "/%2527/", "/%2528/", "/%2529/", "/%252C/", "/%252F/", "/%253A/", "/%253B/", "/%253C/", "/%253D/", "/%253E/", "/%253F/", "/%2540/", "/%255B/", "/%255C/", "/%255D/", "/%255E/", "/%257B/", "/%257C/", "/%257D/", "/%257E/");
    $rep_pat = array(  "-"  ,   "-"  ,   ""   ,   ""   ,   ""   , "-" ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   , "-at-" ,   ""   ,   "-"   ,  ""   ,   "-"  ,   ""   ,   "-"  ,   ""   ,   "-"  );
    $title   = preg_replace($pattern, $rep_pat, $title);
    
    // Transformation des ponctuations
    //                 Tab     Space      !        "        #        %        &        '        (        )        ,        /        :        ;        <        =        >        ?        @        [        \        ]        ^        {        |        }        ~       .
    $pattern = array("/%09/", "/%20/", "/%21/", "/%22/", "/%23/", "/%25/", "/%26/", "/%27/", "/%28/", "/%29/", "/%2C/", "/%2F/", "/%3A/", "/%3B/", "/%3C/", "/%3D/", "/%3E/", "/%3F/", "/%40/", "/%5B/", "/%5C/", "/%5D/", "/%5E/", "/%7B/", "/%7C/", "/%7D/", "/%7E/", "/\./");
    $rep_pat = array(  "-"  ,   "-"  ,   ""   ,   ""   ,   ""   , "-" ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   , "-at-" ,   ""   ,   "-"   ,  ""   ,   "-"  ,   ""   ,   "-"  ,   ""   ,   "-"  ,  ""  );
    $title   = preg_replace($pattern, $rep_pat, $title);

    // Transformation des caractères accentués
    //                  è        é        ê        ë        ç        à        â        ä        î        ï        ù        ü        û        ô        ö
    $pattern = array("/%B0/", "/%E8/", "/%E9/", "/%EA/", "/%EB/", "/%E7/", "/%E0/", "/%E2/", "/%E4/", "/%EE/", "/%EF/", "/%F9/", "/%FC/", "/%FB/", "/%F4/", "/%F6/");
    $rep_pat = array(  "-", "e"  ,   "e"  ,   "e"  ,   "e"  ,   "c"  ,   "a"  ,   "a"  ,   "a"  ,   "i"  ,   "i"  ,   "u"  ,   "u"  ,   "u"  ,   "o"  ,   "o"  );
    $title   = preg_replace($pattern, $rep_pat, $title);



    $pattern = array("/--/");
    $rep_pat = array("-");
    $maxloop=0;      // avoid unlimited loop & possibility for DDOS attack
	while((preg_match("/--+/",$title) > 0) && ($maxloop < 100))
	{
		$title   = preg_replace($pattern, $rep_pat, $title); //remove multiple '-'
        $maxloop=$maxloop+1;
    }

    if (sizeof($title) > 0)
    {
         //remove trailing dash
        $pattern = "/\-$/";
        $rep_pat = "";
        $title = preg_replace($pattern, $rep_pat, $title);

        $title .= '-op' .$op. 'id' .$id. 'pg' .$pg. '.html';
        return $title;
    }
    else
        return '';
}

function ams_seo_genURL($title,$audience='', $topic='',$op=0,$id=0,$pg=0)
{
    $urltemplate=ams_seo_friendlyURLIsEnable();
    
    if (!($urltemplate==false)) //if friendly url is enabled
    {
         //remove prefix slash
        $pattern = "/^\//";
        $rep_pat = "";
        $topic = preg_replace($pattern, $rep_pat, $topic);
        
         //remove trailing slash
        $pattern = "/\/$/";
        $rep_pat = "";
        $urltemplate = preg_replace($pattern, $rep_pat, $urltemplate);

        //Create link based on URL template
        $pattern = array("/\[XOOPS_URL\]/","/\[ams_DIR\]/","/\[AUDIENCE\]/","/\[TOPIC\]/");
        $rep_pat = array(XOOPS_URL,'modules/ams',$audience,$topic);
        $urltemplate   = preg_replace($pattern, $rep_pat, $urltemplate);
        
        
        return $urltemplate. "/" .ams_SEO_title($title,$op,$id,$pg) ; //return url if friendlyurl is enabled
    }else
    {
        return false; //return false if friendlyurl is disabled
    }
     
}

function ams_seo_friendlyURLIsEnable()
{
    $SEO_handler =& xoops_getmodulehandler('seo', 'ams');
    $thisSEO= $SEO_handler->read_setting();
    if (intval($thisSEO['friendlyurl_enable'])==1)
    {
        return $thisSEO['urltemplate'];   
    }else
    {
        return false;
    }
}

function ams_getmoduleoption($option, $repmodule='ams')
{
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval = false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

function ams_isaudiencesetup($mid)
{
    global $xoopsDB;
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix('group_permission')." WHERE gperm_modid=".$mid." AND gperm_name='ams_audience'";
	$result=$xoopsDB->query($sql);
	$count=$xoopsDB->fetchRow($result);
	if ($count[0] > 0)
	{
		return true;
	} else
	{
		return false;
	}
	
	
}
// Metalslug
function ams_convert_date($date)   
{ 
if (strpos(_SHORTDATESTRING, "/")) $div="/"; 
if (strpos(_SHORTDATESTRING, "-")) $div="-"; 
$date_explode=explode($div, _SHORTDATESTRING); 
    if (($date_explode[0]=="j" || $date_explode[0]=="d") && ($date_explode[1]=="n" || $date_explode[1]=="m"))  
    { 
        $new_data=explode($div, $date); 
        $date=mktime(0, 0, 0, $new_data[1], $new_data[0], $new_data[2]); 
        return $date; 
        exit; 
    } else {
	    return strtotime($date); 
	}
}
?>