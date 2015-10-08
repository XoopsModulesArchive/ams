<?php
// $Id: modinfo.php,v 1.16 2004/06/09 09:57:33 mithyt2 Exp $
// Module Info

// The name of this module
define("_MI_AMS_NAME","Articles");

// A brief description of this module
define("_MI_AMS_DESC","Creates a Slashdot-like article section, where users can post articles and comment.");

// Admin Menu
define("_MI_AMS_ADMENU1","Home");
define("_MI_AMS_ADMENU2","Categories");
define("_MI_AMS_ADMENU3","Articles");
define("_MI_AMS_ADMENU4","Permissions");
define("_MI_AMS_ADMENU5","Settings");
define("_MI_AMS_ADMENU6","Audience");
define("_MI_AMS_ADMENU7","Spotlight");
define("_MI_AMS_ADMENU8","About");

// Names of blocks for this module (Not all module has blocks)
define("_MI_AMS_BNAME1","News Topics");
define("_MI_AMS_BNAME3","Big Story");
define("_MI_AMS_BNAME4","Top News");
define("_MI_AMS_BNAME5","Recent News");
define("_MI_AMS_BNAME6","Moderate News");
define("_MI_AMS_BNAME7","Navigate thru topics");
define("_MI_AMS_BNAME8","Most Active Authors");
define("_MI_AMS_BNAME9","Most Read Authors");
define("_MI_AMS_BNAME10","Highest Rated Authors");
define("_MI_AMS_BNAME11","Highest Rated Articles");
define("_MI_AMS_BNAME12","AMS Spotlight");

// Sub menus in main menu block
define("_MI_AMS_SMNAME1","Submit Article");
define("_MI_AMS_SMNAME2","Archive");

// Title of config items
define("_MI_AMS_STORYHOME","Select the number of articles to display on top page");
define("_MI_AMS_STORYCOUNTTOPIC","Select the number of articles to display on a topic\"s page");
define("_MI_AMS_NOTIFYSUBMIT","Select yes to send notification message to webmaster upon new submission");
define("_MI_AMS_DISPLAYNAV","Select yes to display navigation box at the top of each module page");
define("_MI_AMS_AUTOAPPROVE","Auto approve articles without admin intervention?");
define("_MI_AMS_ALLOWEDSUBMITGROUPS","Groups who can Submit Articles");
define("_MI_AMS_ALLOWEDAPPROVEGROUPS","Groups who can Approve Articles");
define("_MI_AMS_NEWSDISPLAY","Article Display Layout");
define("_MI_AMS_NAMEDISPLAY","Author's name");
define("_MI_AMS_COLUMNMODE","Columns");
define("_MI_AMS_STORYCOUNTADMIN","Number of new articles to display in admin area: ");
define("_MI_AMS_UPLOADFILESIZE","MAX Filesize Upload (KB) 1048576 = 1 Meg");
define("_MI_AMS_UPLOADGROUPS","Authorized groups to upload");
define("_MI_AMS_MAXITEMS","Maximum allowed items");
define("_MI_AMS_MAXITEMDESC","This sets the maximum number of items, a user can select in the navigation box on index or topic pages");


// Description of each config items
define("_MI_AMS_STORYHOMEDSC","This controls how many items will be displayed on the top page (i.e. when no topic is selected)");
define("_MI_AMS_NOTIFYSUBMITDSC","");
define("_MI_AMS_DISPLAYNAVDSC","");
define("_MI_AMS_AUTOAPPROVEDSC","");
define("_MI_AMS_ALLOWEDSUBMITGROUPSDESC","The selected groups will be able to submit articles");
define("_MI_AMS_ALLOWEDAPPROVEGROUPSDESC","The selected groups will be able to approve articles");
define("_MI_AMS_NEWSDISPLAYDESC","Classic shows all articles ordered by date of publish. Articles by topic will group the articles by topic with the latest article in full and the others with just the title");
define("_MI_AMS_ADISPLAYNAMEDSC","Select how to display the author\"s name");
define("_MI_AMS_COLUMNMODE_DESC","You can choose the number of columns to display articles list");
define("_MI_AMS_STORYCOUNTADMIN_DESC","");
define("_MI_AMS_STORYCOUNTTOPIC_DESC","This controls how many items will be displayed on a topic page (i.e. not front page)");
define("_MI_AMS_UPLOADFILESIZE_DESC","");
define("_MI_AMS_UPLOADGROUPS_DESC","Select the groups who can upload to the server");

// Name of config item values
define("_MI_AMS_NEWSCLASSIC","Classic");
define("_MI_AMS_NEWSBYTOPIC","By Topic");
define("_MI_AMS_DISPLAYNAME1","Username");
define("_MI_AMS_DISPLAYNAME2","Real Name");
define("_MI_AMS_DISPLAYNAME3","Do not display author");
define("_MI_AMS_UPLOAD_GROUP1","Submitters and Approvers");
define("_MI_AMS_UPLOAD_GROUP2","Approvers Only");
define("_MI_AMS_UPLOAD_GROUP3","Upload Disabled");
define("_MI_AMS_INDEX_NAME","Name of Index");
define("_MI_AMS_INDEX_DESC","This will be displayed as the top-level link in the breadcrumbs in topic and article view");

// Text for notifications

define("_MI_AMS_NEWS_GLOBAL_NOTIFY","Global");
define("_MI_AMS_NEWS_GLOBAL_NOTIFYDSC","Global news notification options.");

define("_MI_AMS_NEWS_STORY_NOTIFY","Story");
define("_MI_AMS_NEWS_STORY_NOTIFYDSC","Notification options that apply to the current story.");

define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFY","New Topic");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP","Notify me when a new topic is created.");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC","Receive notification when a new topic is created.");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notify : New news topic");

define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFY","New Story Submitted");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP","Notify me when any new article is submitted (awaiting approval).");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC","Receive notification when any new article is submitted (awaiting approval).");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notify : New article submitted");

define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFY","New Story");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP","Notify me when any new article is posted.");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC","Receive notification when any new article is posted.");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notify : New Article");

define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFY","Story Approved");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYCAP","Notify me when this story is approved.");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYDSC","Receive notification when this article is approved.");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notify : Article Approved");

define("_MI_AMS_RESTRICTINDEX","Restrict Topics on Index Page?");
define("_MI_AMS_RESTRICTINDEXDSC","If set to yes, users will only see articles listed in the index from the topics, they have access to as set in Article Permissions");

define("_MI_AMS_ANONYMOUS_VOTE","Enable Anonymous Rating of Articles");
define("_MI_AMS_ANONYMOUS_VOTE_DESC","If enabled, anonymous users can rate articles");

define("_MI_AMS_AUDIENCE","Audience Levels");

define("_MI_AMS_SPOTLIGHT","Spotlight");
define("_MI_AMS_SPOTLIGHT_ITEMS","Spotlight Article Candidates");
define("_MI_AMS_SPOTLIGHT_ITEMS_DESC","This is the number of articles that will be listed in the spotlight configuration page as selectable for spotlighted article");

define("_MI_AMS_EDITOR","Editor");
define("_MI_AMS_EDITOR_DESC","Choose the editor to use in the submit form - non-default editors MUST be separately installed");

define("_MI_AMS_SPOTLIGHT_TEMPLATE","Spotlight Templates");
define("_MI_AMS_SPOTLIGHT_TEMPLATE_DESC","Which template enabled to admin to be used in spotlight block");

define("_MI_AMS_MIME_TYPES","MIME Types");

define("_MI_AMS_PERMISSION_ARTICLES","Articles Permissions");
define("_MI_AMS_PERMISSION_ARTICLES1","Articles Permissions 1");
define("_MI_AMS_PERMISSION_ARTICLES2","Articles Permissions 2");
define("_MI_AMS_NUMCOLUMNS","Number Columns");
define("_MI_AMS_NUMCOLUMN_DESC","Number Columns");
define("_MI_AMS_NUMROWS","Number Rows");
define("_MI_AMS_NUMROWS_DESC","Number Rows");
define("_MI_AMS_ADMIN_PERPAGE","Admin Per Page");
define("_MI_AMS_ADMIN_PERPAGE_DESC","Admin Per Page");
?>