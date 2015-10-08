<?php
// $Id$
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

function b_ams_top_show($options) {
    $myts =& MyTextSanitizer::getInstance();
    include_once XOOPS_ROOT_PATH."/modules/AMS/class/class.newsstory.php";
    $block = array();
    if ( $options[8] == 0 ) {
        $stories = AmsStory::getAllPublished($options[1],0,false,0,1, true, $options[0]);
    }
    else {
        $topics = array_slice($options, 8);
        $stories = AmsStory::getAllPublished($options[1],0,false,$topics, 1, true, $options[0]);
    }
    foreach ( $stories as $key => $story ) {
        switch ($options[0]) {
            case "rating":
                $stat = $story->rating;
                break;
                
            case "counter":
                $stat = $story->counter();
                break;
                
            case "published":
                $stat = formatTimestamp($story->published(), "s");
                break;
        }
        $news = array();
        $title = $story->title();
		if (strlen($title) >= $options[2]) {
			$title = xoops_substr($title,0,($options[2]-1));
		}
		$html = $story->nohtml ? 0 : 1;
        //if spotlight is enabled and this is either the first article or the selected one
        if (($options[4] == 1) && (($options[6] > 0 && $options[6] == $story->storyid()) || ($options[6] == 0 && $key == 0))) {
            $spotlight = array();
            $spotlight['title'] = $title;
            $text = $story->hometext;
            if ($options[7] != "") {
                $text = $options[7].$text;
            }
            $spotlight['text'] = $myts->displayTarea($text, !$html);
            $spotlight['id'] = $story->storyid();
            $spotlight['date'] = formatTimestamp($story->published(), "s");
            $spotlight['hits'] = $stat;
            $block['spotlight'] = $spotlight;
        }
        else {
            $news['title'] = $title;
            $news['id'] = $story->storyid();
            $news['date'] = formatTimestamp($story->published(),"s");
            $news['hits'] = $stat;
            if ($options[3] > 0) {
                $news['teaser'] = xoops_substr($myts->displayTarea($story->hometext, $html), 0, $options[3]-1);
            }
            else {
                $news['teaser'] = "";
            }
            $block['stories'][] = $news;
        }
    }
    //If spotlight article was not in the fetched stories
    if (($options[4] == 1) && !isset($spotlight)) {
        $spotlightArticle = new AmsStory($options[6]);
        $spotlight = array();
        $spotlight['title'] = xoops_substr($spotlightArticle->title(),0,($options[2]-1));;
        $text = $spotlightArticle->hometext;
        if ($options[7] != "") {
            $text = $options[7].$text;
        }
        $html = $spotlightArticle->nohtml ? 0 : 1;
        $spotlight['text'] = $myts->displayTarea($text, $html);
        $spotlight['id'] = $spotlightArticle->storyid();
        $spotlight['date'] = formatTimestamp($spotlightArticle->published(), "s");
        $spotlight['hits'] = $spotlightArticle->counter();
        $block['spotlight'] = $spotlight;
    }
    $block['onecolumn'] = $options[5];
    return $block;
}

function b_ams_top_edit($options) {
    global $xoopsDB;
    $form = ""._AMS_MB_NEWS_ORDER."&nbsp;<select name='options[0]'>";
    $form .= "<option value='published'";
    if ( $options[0] == "published" ) {
        $form .= " selected='selected'";
    }
    $form .= ">"._AMS_MB_NEWS_DATE."</option>\n";
    $form .= "<option value='counter'";
    if($options[0] == "counter"){
        $form .= " selected='selected'";
    }
    $form .= ">"._AMS_MB_NEWS_HITS."</option>\n";
    $form .= "<option value='rating'";
    if($options[0] == "rating"){
        $form .= " selected='selected'";
    }
    $form .= ">"._AMS_MB_NEWS_RATING."</option>\n";
    $form .= "</select>\n";
    $form .= "&nbsp;"._AMS_MB_NEWS_DISP."&nbsp;<input type='text' name='options[1]' value='".$options[1]."'/>&nbsp;"._AMS_MB_NEWS_ARTCLS."";
    $form .= "&nbsp;<br><br />"._AMS_MB_NEWS_CHARS."&nbsp;<input type='text' name='options[2]' value='".$options[2]."'/>&nbsp;"._AMS_MB_NEWS_LENGTH."<br /><br />";

    $form .= _AMS_MB_NEWS_TEASER." <input type='text' name='options[3]' value='".$options[3]."' />"._AMS_MB_NEWS_LENGTH;
    $form .= "<br /><br />";
    $form .= _AMS_MB_NEWS_SPOTLIGHT." <input type='radio' name='options[4]' value='1'";
    if ($options[4] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />"._YES;
    $form .= "<input type='radio' name='options[4]' value='0'";
    if ($options[4] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />"._NO;
    $form .= "<br /><br />";
    $form .= _AMS_MB_NEWS_ONECOLUMN." <input type='radio' name='options[5]' value='1'";
    if ($options[5] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />"._YES;
    $form .= "<input type='radio' name='options[5]' value='0'";
    if ($options[5] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />"._NO;
    $form .= "<br /><br />";
    
    include_once XOOPS_ROOT_PATH."/modules/AMS/class/class.newsstory.php";
    $articles = AmsStory::getAllPublished(0,0,false,0,0,false);
    $form .= "<select id='options[6]' name ='options[6]'>";
    $form .= "<option value='0'>"._AMS_MB_NEWS_FIRST."</option>";
    foreach ($articles as $storyid => $storytitle) {
        $sel = "";
        if ($options[6] == $storyid) {
            $sel = " selected='selected'";
        }
        $form .= "<option value='$storyid'$sel>".$storytitle."</option>";
    }
    $form .= "</select><br /><br />";
    $form .= _AMS_MB_NEWS_IMAGE."&nbsp;<input type='text' id='spotlightimage' name='options[7]' value='".$options[7]."' size='50'/>";
    $form .= "<img onmouseover='style.cursor=\"hand\"' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/imagemanager.php?target=spotlightimage\",\"imgmanager\",400,430);' src='".XOOPS_URL."/images/image.gif' alt='image' />";
    
    $form .= "<br /><br /><br /><select id='options[8]' name='options[8]' multiple='multiple'>";
    
    include_once XOOPS_ROOT_PATH."/class/xoopsstory.php";
    $xt = new XoopsTopic($xoopsDB->prefix("ams_topics"));
    $alltopics = $xt->getTopicsList();
    $alltopics[0]['title'] = "All topics";
    ksort($alltopics);
    $size = count($options);
    foreach ($alltopics as $topicid => $topic) {
        $sel = "";
        for ( $i = 8; $i < $size; $i++ ) {
            if ($options[$i] == $topicid) {
                $sel = " selected='selected'";
            }
        }
        $form .= "<option value='$topicid'$sel>".$topic['title']."</option>";
    }
    $form .= "</select><br />";

    return $form;
}
?>