<?php
// $Id: admin.php,v 1.18 2004/07/26 17:51:25 hthouzard Exp $
//%%%%%%	Admin Module Name  Articles 	%%%%%
define("_AM_AMS_DBUPDATED","Database Updated Successfully!");
define("_AM_AMS_CONFIG","AMS Configuration");
define("_AM_AMS_AUTOARTICLES","Automated Articles");
define("_AM_AMS_STORYID","Story ID");
define("_AM_AMS_TITLE","Title");
define("_AM_AMS_TOPIC","Topic");
define("_AM_AMS_TOPICID","Topic Id");
define("_AM_AMS_COUNTER","Counter");
define("_AM_AMS_ARTICLE","Article");
define("_AM_AMS_POSTER","Poster");
define("_AM_AMS_PROGRAMMED","Programmed Date/Time");
define("_AM_AMS_ACTION","Action");
define("_AM_AMS_EDIT","Edit");
define("_AM_AMS_DELETE","Delete");
define("_AM_AMS_LAST10ARTS","Last %d Articles");
define("_AM_AMS_PUBLISHED","Published"); // Published Date
define("_AM_AMS_UPDATED","Updated"); // Updated Date
define("_AM_AMS_GO","Go!");
define("_AM_AMS_EDITARTICLE","Edit Article");
define("_AM_AMS_POSTNEWARTICLE","Post New Article");
define("_AM_AMS_ARTPUBLISHED","Your article has been published!");
define("_AM_AMS_HELLO","Hello %s,");
define("_AM_AMS_YOURARTPUB","Your article submitted to our site has been published.");
define("_AM_AMS_TITLEC","Title: ");
define("_AM_AMS_URLC","URL: ");
define("_AM_AMS_PUBLISHEDC","Published: ");
define("_AM_AMS_RUSUREDEL","Are you sure you want to delete this article and all its comments?");
define("_AM_AMS_YES","Yes");
define("_AM_AMS_NO","No");
define("_AM_AMS_INTROTEXT","Intro Text");
define("_AM_AMS_EXTEXT","Extended Text");
define("_AM_AMS_ALLOWEDHTML","Allowed HTML:");
define("_AM_AMS_NOTIFYPUBLISH","Notify Publish");
define("_AM_AMS_DISAMILEY","Disable Smiley");
define("_AM_AMS_DISHTML","Disable HTML");
define("_AM_AMS_APPROVE","Approve");
define("_AM_AMS_MOVETOTOP","Move this story to top");
define("_AM_AMS_CHANGEDATETIME","Change the date/time of publication");
define("_AM_AMS_NOWSETTIME","It is now set at: %s"); // %s is datetime of publish
define("_AM_AMS_CURRENTTIME","Current time is: %s");  // %s is the current datetime
define("_AM_AMS_SETDATETIME","Set the date/time of publish");
define("_AM_AMS_MONTHC","Month:");
define("_AM_AMS_DAYC","Day:");
define("_AM_AMS_YEARC","Year:");
define("_AM_AMS_TIMEC","Time:");
define("_AM_AMS_PREVIEW","Preview");
define("_AM_AMS_SAVE","Save");
define("_AM_AMS_PUBINHOME","Publish in Home?");
define("_AM_AMS_ADD","Add");

// Buttons
define("_AM_AMS_ADDARTICLE","Add Article");

define("_AM_AMS_ARTICLEWAIT","Article Wait");
define("_AM_AMS_ARTICLELIST","Article List");

define("_AM_AMS_ADDTOPICS","Add Topic");
define("_AM_AMS_TOPICSLIST","Topic List");

// Statistics
define("_AM_AMS_TOPICS","Topics Statistics");
define("_AM_AMS_THEREARE_TOPICS","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Topics in database");
define("_AM_AMS_THEREARE_TOPICS_ONLINE","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Topics waiting");
define("_AM_AMS_ARTICLES","Articles Statistics");
define("_AM_AMS_THEREARE_ARTICLE","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Articles in database");
define("_AM_AMS_THEREARE_ARTICLE_ONLINE","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Articles waiting");
define("_AM_AMS_SPOTLIGHTS","Spotlights Statistics");
define("_AM_AMS_THEREARE_SPOTLIGHT","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Spotlights in database");
define("_AM_AMS_THEREARE_SPOTLIGHT_ONLINE","There are <span style='color: #ff0000; font-weight: bold'>%s</span> Spotlights waiting");

// Form New Topic
define("_AM_AMS_TOPICS_ADD","Add a Topic");
define("_AM_AMS_TOPICS_EDIT","Edit Topic");

// Form New Article
define("_AM_AMS_ARTICLE_ADD","Add an Article");
//define("_AM_AMS_EDITARTICLE","Edit Article");

// Permissions
define("_AM_AMS_PERM_VIEW_DSC","Permissions to View");
define("_AM_AMS_PERM_SUBMIT_DSC","Permissions to Submit");

// Audience
define("_AM_AMS_AUDIENCE","Audience Name");
define("_AM_AMS_AUDIENCE_ADD","Add an Audience");
define("_AM_AMS_AUDIENCE_EDIT","Edit an Audience");
define("_AM_AMS_AUDIENCE_NAME","Add Name");
define("_AM_AMS_AUDIENCE_ACCESS","Audience Access Right");
define("_AM_AMS_AUDIENCE_LIST","Audience List");
define("_AM_AMS_AUDIENCE_NEW","Add Audience");
define("_AM_AMS_AUDIENCE_ID","Audience Id");

// Setting SEO
define("_AM_AMS_SETTING_ADD","SEO Setting");
define("_AM_AMS_SETTINGVALUE","Setting Value - Custom URL Template = [XOOPS_URL]/");
define("_AM_AMS_SETTINGTYPE","Rewrite Engine URL");

define("_AM_AMS_TOPICTITLE","Topic Title");
define("_AM_AMS_IHOME","Homepage");
define("_AM_AMS_UID","User");
define("_AM_AMS_HOMETEXT","Low Text");
define("_AM_AMS_BODYTEXT","Long Text");
define("_AM_AMS_HOSTNAME","Hostname");
define("_AM_AMS_NOHTML","No html");
define("_AM_AMS_NOSMILEY","No smyles");
define("_AM_AMS_NOTIFYPUB","Notify Publication");
define("_AM_AMS_STORY_TYPE","Story Type");
define("_AM_AMS_MAJOR","Version");
define("_AM_AMS_VERSIONDESC","Versione recent");
define("_AM_AMS_SWITCHAUTHOR","Switch Author");
define("_AM_AMS_NOVERSIONCHANGE","No version change");
define("_AM_AMS_REVISION","Revision");
define("_AM_AMS_MINOR","Minor");
define("_AM_AMS_AUTO","Auto");
define("_AM_AMS_AUDIENCEID","Audience");

// Topic List
define("_AM_AMS_TOPIC_ID","Topic Id");
define("_AM_AMS_TOPIC_PID","Topic PId");
define("_AM_AMS_FORMIMG","Topic Image");
define("_AM_AMS_TOPIC_TITLE","Topic Title");
define("_AM_AMS_FORUM_ID","Forum Id");
define("_AM_AMS_WEIGHT","Weight");
define("_AM_AMS_ONLINE","Online");
define("_AM_AMS_ON","Online On");
define("_AM_AMS_OFF","Online Off");
define("_AM_AMS_FORMACTION","Action");

//%%%%%%	Admin Module Name  Topics 	%%%%%

define("_AM_AMS_ADDMTOPIC","Add a MAIN Topic");
define("_AM_AMS_TOPICNAME","Topic Name");
define("_AM_AMS_MAX40CHAR","(max: 40 characters)");
define("_AM_AMS_TOPICIMG","Topic Image");
define("_AM_AMS_FORMPATH","image name + extension located in %s");
define("_AM_AMS_FEXAMPLE","for example: games.gif");
define("_AM_AMS_ADDSUBTOPIC","Add a SUB-Topic");
define("_AM_AMS_IN","in");
define("_AM_AMS_MODIFYTOPIC","Modify Topic");
define("_AM_AMS_MODIFY","Modify");
define("_AM_AMS_PARENTTOPIC","Parent Topic");
define("_AM_AMS_SAVECHANGE","Save Changes");
define("_AM_AMS_DEL","Delete");
define("_AM_AMS_CANCEL","Cancel");
define("_AM_AMS_WAYSYWTDTTAL","WARNING: Are you sure you want to delete this Topic and ALL its Stories and Comments?");

define("_AM_AMS_FORMUPLOAD","Upload Image");
define("_AM_AMS_BANNER","Banner");
define("_AM_AMS_BANNER_INHERIT","Banner Inherit");

// Added in Beta6
define("_AM_AMS_TOPICSMNGR","Topics Manager");
define("_AM_AMS_PEARTICLES","Manage Articles");
define("_AM_AMS_NEWSUB","New Submissions");
define("_AM_AMS_POSTED","Posted");
define("_AM_AMS_GENERALCONF","General Configuration");

// Added in RC2
define("_AM_AMS_TOPICDISPLAY","Display Image?");
define("_AM_AMS_TOPICALIGN","Position");
define("_AM_AMS_RIGHT","Right");
define("_AM_AMS_LEFT","Left");

define("_AM_AMS_EXPARTS","Expired Articles");
define("_AM_AMS_EXPIRED","Expired");
define("_AM_AMS_CHANGEEXPDATETIME","Change the date/time of expiration");
define("_AM_AMS_SETEXPDATETIME","Set the date/time of expiration");
define("_AM_AMS_NOWSETEXPTIME","It is now set at: %s");

// Added in RC3
define("_AM_AMS_ERRORTOPICNAME","You must enter a topic name!");
define("_AM_AMS_EMPTYNODELETE","Nothing to delete!");

// Added 240304 (Mithrandir)
define("_AM_AMS_GROUPPERM","Submit/Approve Permissions");
define("_AM_AMS_SELFILE","Select file");

// Added Novasmart in 2.42
define("_MULTIPLE_PAGE_GUIDE","Type [pagebreak] to split to multiple pages");

// Added by Hervé
define("_AM_AMS_UPLOAD_DBERROR_SAVE","Error while attaching file to the article");
define("_AM_AMS_UPLOAD_ERROR","Error while uploading the file");
define("_AM_AMS_UPLOAD_ATTACHFILE","Attached file(s)");
define("_AM_AMS_ACCESSFORM","Access Permissions");
define("_AM_AMS_APPROVEFORM","Approve Permissions");
define("_AM_AMS_SUBMITFORM","Submit Permissions");
define("_AM_AMS_VIEWFORM","View Permissions");
define("_AM_AMS_ACCESSFORM_DESC","Select, who can have access to articles");
define("_AM_AMS_APPROVEFORM_DESC","Select, who can approve articles");
define("_AM_AMS_SUBMITFORM_DESC","Select, who can submit articles");
define("_AM_AMS_VIEWFORM_DESC","Select, who can view which topics");
define("_AM_AMS_DELETE_SELFILES","Delete selected files");
define("_AM_AMS_TOPIC_PICTURE","Upload picture");
define("_AM_AMS_UPLOAD_WARNING","<B>Warning, do not forget to apply write permissions to the following folder : %s</B>");

define("_AM_AMS_NEWS_UPGRADECOMPLETE","Upgrade Complete");
define("_AM_AMS_NEWS_UPDATEMODULE","Update module templates and blocks");
define("_AM_AMS_NEWS_UPGRADEFAILED","Upgrade Failed");
define("_AM_AMS_NEWS_UPGRADE","Upgrade");
define("_AM_AMS_ADD_TOPIC","Add a topic");
define("_AM_AMS_ADD_TOPIC_ERROR","Error, topic already exists!");
define("_AM_AMS_ADD_TOPIC_ERROR1","ERROR: Cannot select this topic for parent topic!");
define("_AM_AMS_SUB_MENU","Publish this topic as a sub menu");
define("_AM_AMS_SUB_MENU_YESNO","Sub-menu?");
define("_AM_AMS_HITS","Hits");
define("_AM_AMS_CREATED","Created");
define("_AM_AMS_COMMENTS","Comments");
define("_AM_AMS_VERSION","Version");
define("_AM_AMS_PUBLISHEDARTICLES","Published Articles");
define("_AM_AMS_TOPICBANNER","Banner");
define("_AM_AMS_BANNERINHERIT","Inherit from parent");
define("_AM_AMS_RATING","Rating");
define("_AM_AMS_FILTER","Filter");
define("_AM_AMS_SORTING","Sorting Options");
define("_AM_AMS_SORT","Sort");
define("_AM_AMS_ORDER","Order");
define("_AM_AMS_STATUS","Status");
define("_AM_AMS_OF","of");

define("_AM_AMS_MANAGEAUDIENCES","Manage Audience Levels");
define("_AM_AMS_AUDIENCENAME","Audience Name");
define("_AM_AMS_ACCESSRIGHTS","Access Rights");
define("_AM_AMS_LINKEDFORUM","Linked Forum");
define("_AM_AMS_VERSIONCOUNT","Versions");
define("_AM_AMS_AUDIENCEHASSTORIES","%u articles have this audience, please select a new audience level for these articles");
define("_AM_AMS_RUSUREDELAUDIENCE","Are you sure you want to delete this audience level completely?");
define("_AM_AMS_PLEASESELECTNEWAUDIENCE","Please Select Replacement Audience Level");
define("_AM_AMS_AUDIENCEDELETED","Audience Deleted Successfully");
define("_AM_AMS_ERROR_AUDIENCENOTDELETED","Error - Audience NOT deleted");
define("_AM_AMS_CANNOTDELETEDEFAULTAUDIENCE","Error - Cannot delete default audience");

define("_AM_AMS_NOTOPICSELECTED","No Topic Selected");
define("_AM_AMS_ACCESS","Access Articles");
define("_AM_AMS_SUBMIT","Submit Articles");
define("_AM_AMS_ERROR_REORDERERROR","Error - Errors occurred during reordering");
define("_AM_AMS_REORDERSUCCESSFUL","Topics Reordered");

define("_AM_AMS_NONE","No Image");
define("_AM_AMS_AUTHOR","Author's Avatar");
// Buttons
define("_AM_AMS_SPOTLIGHT_NEW","Add New Spotlight");
define("_AM_AMS_SPOTLIGHT_LIST","Spotlight List");

define("_AM_AMS_SPOTLIGHT_ADD","Add Spotlight Mini Block");
define("_AM_AMS_SPOTLIGHT_EDITBLOCK","Edit Block Settings");
define("_AM_AMS_SPOTLIGHT_NAME","Name");
define("_AM_AMS_SPOTLIGHT_SHOWIMAGE","Show Image");
define("_AM_AMS_SPOTLIGHT_SHOWIMAGE_DESC","Select an image to display or set it to show either topic image or author avatar");
define("_AM_AMS_SPOTLIGHT_WEIGHT","Weight");
define("_AM_AMS_SPOTLIGHT_DISPLAY","Display");
define("_AM_AMS_SPOTLIGHT_MAIN","Main");
define("_AM_AMS_SPOTLIGHT_MINI","Mini");
define("_AM_AMS_SPOTLIGHT","Spotlight");
define("_AM_AMS_SPOTLIGHT_SAVESUCCESS","Spotlight Successfully Saved");
define("_AM_AMS_SPOTLIGHT_DELETESUCCESS","Spotlight Successfully Deleted");
define("_AM_AMS_RUSUREDELSPOTLIGHT","Are you sure you want to remove this Spotlight?");

define("_AM_AMS_SPOTLIGHT_LATESTARTICLE","Latest Article");
define("_AM_AMS_SPOTLIGHT_LATESTINTOPIC","Latest in Topic");
define("_AM_AMS_SPOTLIGHT_SPECIFICARTICLE","Specific Article");
define("_AM_AMS_SPOTLIGHT_NOIMAGE","No Image");
define("_AM_AMS_SPOTLIGHT_MODE_SELECT","Spotlight Mode");
define("_AM_AMS_SPOTLIGHT_SPECIFYIMAGE","Specify Image");
define("_AM_AMS_SPOTLIGHT_TOPICIMAGE","Image from Topic");
define("_AM_AMS_SPOTLIGHT_AUTHORIMAGE","Author Avatar");
define("_AM_AMS_SPOTLIGHT_IMAGE","Image");
define("_AM_AMS_SPOTLIGHT_AUTOTEASER","Automatic Teaser");
define("_AM_AMS_SPOTLIGHT_MAXLENGTH","Maximum Length of Auto-Teaser");
define("_AM_AMS_SPOTLIGHT_TEASER","Manual Teaser Text");
define("_AM_AMS_SPOTLIGHT_TOPIC_DESC","If 'Latest in Topic' is selected, which topic should it select from?");
define("_AM_AMS_SPOTLIGHT_ARTICLE_DESC","If 'Specific Article' is selected, which article should be displayed?");
define("_AM_AMS_SPOTLIGHT_CUSTOM","Custom");

define("_AM_AMS_FORMOK","Succesfull Saved");
define("_AM_AMS_FORMDELOK","Succesfull Deleted");
define("_AM_AMS_FORMUPOK","Succesfull Updated");
define("_AM_AMS_MAXLENGTH","Custom");
define("_AM_AMS_DISPLAY","Custom");
define("_AM_AMS_SPOTLIGHT_MODE","Custom");

define("_AM_AMS_MODADMIN","Module Administration");
//SEO
define("_AM_AMS_SEO_SUBMITFORM","SEO Setting");
define("_AM_AMS_SEO_FRIENDLYURL","Friendly URL");
define("_AM_AMS_SEO_ENABLE","Enable");
define("_AM_AMS_SEO_URLTEMPLATE","Custom URL Template");
define("_AM_AMS_SEO_VALIDTAG","Valid Tag");

?>