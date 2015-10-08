<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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

function b_ams_spotlight_show($options) {
    include_once XOOPS_ROOT_PATH."/modules/AMS/class/class.newsstory.php";
    global $xoopsModule;
    if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != "AMS") {
        $mod_handler =& xoops_gethandler('module');
        $amsModule =& $mod_handler->getByDirname('AMS');
    }
    else {
        $amsModule =& $xoopsModule;
    }
    
    $spotlight_handler =& xoops_getmodulehandler('spotlight', 'AMS');
    $block =& $spotlight_handler->getSpotlightBlock();

    // If the main should be to the right
    if ($options[2] == "ams_block_spotlight_right.html") {
        //switch first and second article position
        // save first article in temp variable
        $temp = $block['spotlights'][0];
        // set first array value to the second article
        $block['spotlights'][0] = $block['spotlights'][1];
        // set second array value (main position) to the temp variable
        $block['spotlights'][1] = $temp;
        // clean up
        unset($temp);
    }
    
    $GLOBALS['xoopsTpl']->assign('spotlights', $block['spotlights']);
    $block['spotlightcontent'] = $GLOBALS['xoopsTpl']->fetch('db:'.$options[2]);
    $GLOBALS['xoopsTpl']->clear_assign('spotlights');

    if (count($options) > 0) {
        if (intval($options[0]) > 0) {
            $stories = AmsStory::getAllPublished(intval($options[0]), 0, false, 0, 1, true, 'published', $block['ids']);
            $count = 0;
            foreach (array_keys($stories) as $i) {
                $block['stories'][] = array('id' => $stories[$i]->storyid(), 'title' => $stories[$i]->title(), 'hits' => $stories[$i]->counter());
                $count ++;
            }
        }

        if ($options[1] == 1) {
            $block['total_art'] = AmsStory::countPublishedByTopic();
            $block['total_read'] = AmsStory::countReads();
            $comment_handler =& xoops_gethandler('comment');
            $block['total_comments'] = $comment_handler->getCount(new Criteria('com_modid', $amsModule->getVar('mid')));
        }
        $block['showministats'] = $options[1];
        $block['showother'] = intval($options[0]) > 0;
    }

    return $block;
}

function b_ams_spotlight_edit($options) {

    include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    $form = new XoopsFormElementTray('', '<br/><br />');
    $numarticles_select = new XoopsFormText(_AMS_MB_SPOT_NUMARTICLES, 'options[0]', 10, 10, $options[0]);
    $form->addElement($numarticles_select);

    $form->addElement(new XoopsFormRadioYN(_AMS_MB_SPOT_SHOWMINISTATS, 'options[1]', $options[1]));
    
    $template_select = new XoopsFormSelect(_AMS_MB_SPOTLIGHT_TEMPLATE, 'options[2]', $options[2]);
    $template_select->addOptionArray(array( 'ams_block_spotlight_center.html' => _AMS_MB_SPOTLIGHT_TEMPLATE_CENTER,
                                            'ams_block_spotlight_left.html' => _AMS_MB_SPOTLIGHT_TEMPLATE_LEFT,
                                            'ams_block_spotlight_right.html' => _AMS_MB_SPOTLIGHT_TEMPLATE_RIGHT));

    $template_select->setDescription(_AMS_MB_SPOTLIGHT_TEMPLATE_DESC);
    $form->addElement($template_select);
    return $form->render();
}
?>