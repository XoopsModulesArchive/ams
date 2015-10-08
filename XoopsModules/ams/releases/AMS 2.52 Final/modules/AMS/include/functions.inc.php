<?php
// $Id$
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
//  ------------------------------------------------------------------------ //
//  Author: NovaSmart (admin@novasmarttechnology.com)                                  //
//  URL: http://www.novasmarttechnology.com, http://xoops.novasmarttechnology.com                         //
//  Project: Article Management System (AMS)                                           //
//  ------------------------------------------------------------------------ //

//create in AMS 2.50 but for future CLONEABLE ability
function AMS_setcookie($name, $string = '', $expire = 0)
{
	global $AMSCookie;
	if(is_array($string)) {
		$value = array();
		foreach ($string as $key => $val){
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	setcookie($AMSCookie['prefix'].$name, $string, intval($expire), $AMSCookie['path'], $AMSCookie['domain'], $AMSCookie['secure']);
}

//create in AMS 2.50 but for future CLONEABLE ability
function AMS_getcookie($name, $isArray = false)
{
	global $AMSCookie;
	$value = !empty($_COOKIE[$AMSCookie['prefix'].$name]) ? $_COOKIE[$AMSCookie['prefix'].$name] : null;
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
 * @package AMS
 * @author Instant Zero (http://xoops.instant-zero.com)
 * @copyright (c) Instant Zero
*/
function AMS_updateCache() {
	global $xoopsModule;
	$folder = $xoopsModule->getVar('dirname');
	$tpllist = array();
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
	include_once XOOPS_ROOT_PATH.'/class/template.php';
	$tplfile_handler =& xoops_gethandler('tplfile');
	$tpllist = $tplfile_handler->find(null, null, null, $folder);
	$xoopsTpl = new XoopsTpl();
	xoops_template_clear_module_cache($xoopsModule->getVar('mid'));			// Clear module's blocks cache

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
		}
	}
}

?>