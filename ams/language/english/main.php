<?php
// $Id: main.php,v 1.3 2004/04/10 16:04:12 hthouzard Exp $
//%%%%%%		File Name index.php 		%%%%%
define("_MA_AMS_PRINTER","Printer Friendly Page");
define("_MA_AMS_SENDSTORY","Send this Article to a Friend");
define("_MA_AMS_READMORE","Read More...");
define("_MA_AMS_COMMENTS","Comments?");
define("_MA_AMS_ONECOMMENT","1 comment");
define("_MA_AMS_BYTESMORE","%s words more");
define("_MA_AMS_NUMCOMMENTS","%s comments");
define("_MA_AMS_MORERELEASES","More releases in ");

//%%%%%%		File Name submit.php		%%%%%
define("_MA_AMS_SUBMITNEWS","Submit Article");
define("_MA_AMS_TITLE","Title");
define("_MA_AMS_TOPIC","Topic");
define("_MA_AMS_THESCOOP","Article Text");
define("_MA_AMS_NOTIFYPUBLISH","Notify by mail when published");
define("_MA_AMS_POST","Post");
define("_MA_AMS_GO","Go!");
define("_MA_AMS_THANKS","Thanks for your submission."); //submission of news article

define("_MA_AMS_NOTIFYSBJCT","Article for my site"); // Notification mail subject
define("_MA_AMS_NOTIFYMSG","You have a new submission for your site."); // Notification mail message

//%%%%%%		File Name archive.php		%%%%%
define("_MA_AMS_NEWSARCHIVES","Article Archives");
define("_MA_AMS_ARTICLES","Articles");
define("_MA_AMS_VIEWS","Views");
define("_MA_AMS_DATE","Date");
define("_MA_AMS_ACTIONS","Actions");
define("_MA_AMS_PRINTERFRIENDLY","Printer Friendly Page");

define("_MA_AMS_THEREAREINTOTAL","There are %s article(s) in total");

// %s is your site name
define("_MA_AMS_INTARTICLE","Interesting Article at %s");
define("_MA_AMS_INTARTFOUND","Here is an interesting article I have found at %s");

define("_MA_AMS_TOPICC","Topic:");
define("_MA_AMS_URL","URL:");
define("_MA_AMS_NOSTORY","Sorry, the selected article does not exist.");

//%%%%%%	File Name print.php 	%%%%%

define("_MA_AMS_URLFORSTORY","The URL for this article is:");

// %s represents your site name
define("_MA_AMS_THISCOMESFROM","This article comes from %s");

// Added by Hervé
define("_MA_AMS_ATTACHEDFILES","Attached Files:");

define("_MA_AMS_MAJOR","Major Change?");
define("_MA_AMS_STORYID","Article ID");
define("_MA_AMS_VERSION","Version");
define("_MA_AMS_SETVERSION","Set Current Version");
define("_MA_AMS_VERSIONUPDATED","Current Version Set To %s");
define("_MA_AMS_OVERRIDE","Override");
define("_MA_AMS_FINDVERSION","Find Version");
define("_MA_AMS_REVISION","Revision");
define("_MA_AMS_MINOR","Minor Revision");
define("_MA_AMS_VERSIONDESC","Choose level of change - If you do NOT specify this, the text will NOT UPDATE!");
define("_MA_AMS_NOVERSIONCHANGE","No Version Change");
define("_MA_AMS_AUTO","Auto");

define("_MA_AMS_RATEARTICLE","Rate Article");
define("_MA_AMS_RATE","Rate Article");
define("_MA_AMS_SUBMITRATING","Submit Rating");
define("_MA_AMS_RATING_SUCCESSFUL","Article Rated Successfully");
define("_MA_AMS_PUBLISHED_DATE","Published Date: ");
define("_MA_AMS_POSTEDBY","Author");
define("_MA_AMS_READS","Reads");
define("_MA_AMS_AUDIENCE","Audience");
define("_MA_AMS_SWITCHAUTHOR","Update Author?");

//Warnings
define("_MA_AMS_VERSIONSEXIST","%s Version(s) with higher versions exist and <strong>will</strong> be OVERWRITTEN with NO restoration ability:");
define("_MA_AMS_AREYOUSUREOVERRIDE","Are you sure you want to replace these versions");
define("_MA_AMS_CONFLICTWHAT2DO","An article with the calculated version number exists<br />What do You want to do?<br />Override: This version is saved with the calculated version number and all higher versions in the same version group (xx.xx.xx) will be deleted<br />Find Version: Let the system find the next available version in the same version group");
define("_MA_AMS_VERSIONCONFLICT","Version Conflict");
define("_MA_AMS_TRYINGTOSAVE","Attempting to save ");

//Error messages
define("_MA_AMS_ERROR","Error Occurred");
define("_MA_AMS_RATING_FAILED","Rating Failed");
define("_MA_AMS_SAVEFAILED","Article Saving Failed");
define("_MA_AMS_TEXTSAVEFAILED","Could not save article text");
define("_MA_AMS_VERSIONUPDATEFAILED","Could not update version");
define("_MA_AMS_COULDNOTRESET","Could not reset versions");
define("_MA_AMS_COULDNOTUPDATEVERSION","Could not update to current version");

define("_MA_AMS_COULDNOTSAVERATING","Could not save rating");
define("_MA_AMS_COULDNOTUPDATERATING","Could not update article rating");

define("_MA_AMS_COULDNOTADDLINK","Link could not be related to article");
define("_MA_AMS_COULDNOTDELLINK","Error - Link not deleted");

define("_MA_AMS_CANNOTVOTESELF","Author cannot rate articles");
define("_MA_AMS_ANONYMOUSVOTEDISABLED","Anonymous rating disabled");
define("_MA_AMS_ANONYMOUSHASVOTED","This IP has already rated this article");
define("_MA_AMS_USERHASVOTED","You have already rated this article");

define("_MA_AMS_NOTALLOWEDAUDIENCE","You are not allowed to read %s level articles");
define("_MA_AMS_NOERRORSENCOUNTERED","No errors encountered");

//Additional constants
define("_MA_AMS_USERNAME","Username");
define("_MA_AMS_ADDLINK","Add Link(s)");
define("_MA_AMS_DELLINK","Remove Link(s)");
define("_MA_AMS_RELATEDARTICLES","Recommended Reading");
define("_MA_AMS_SEARCHRESULTS","Search Results:");
define("_MA_AMS_MANAGELINK","Links");
define("_MA_AMS_DELVERSIONS","Delete versions below this version");
define("_MA_AMS_DELALLVERSIONS","Delete ALL versions apart from this version");
define("_MA_AMS_SUBMIT","Submit");
define("_MA_AMS_RUSUREDELVERSIONS","Are you sure you want to delete ALL versions BEYOND RESTORATION!!! below this version?");
define("_MA_AMS_RUSUREDELALLVERSIONS","Are you sure you want to delete ALL versions BEYOND RESTORATION!!! apart from this version?");
define("_MA_AMS_EXTERNALLINK","External Link");
define("_MA_AMS_ADDEXTERNALLINK","Add External Link");
define("_MA_AMS_PREREQUISITEARTICLES","Prerequisite Reading");
define("_MA_AMS_LINKTYPE","Link Type");
define("_MA_AMS_SETTITLE","Set Title of Link");
define("_MA_AMS_BANNER","Banner/Sponsor");

define("_MA_AMS_NOTOPICS","No Topics Exist - please create a topic and set appropriate permissions before submitting an article");

define("_MA_AMS_TOTALARTICLES","Total Articles");

define("_MA_AMS_INDEX","Index");
define("_MA_AMS_SUBTOPICS","Sub-Topics for ");
define("_MA_AMS_PAGEBREAK","PAGEBREAK");
define("_MA_AMS_POSTNEWARTICLE","Post New Article");

?>