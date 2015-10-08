<?php
// $Id: modinfo.php,v 1.16 2004/06/09 09:57:33 mithyt2 Exp $
// Module Info

// The name of this module
define("_AMS_MI_NEWS_NAME","Articoli");

// A brief description of this module
define("_AMS_MI_NEWS_DESC","Crea uno Slashdot-like sezione di articolo, dove gli utenti possono pubblicare articoli e commenti.");

// Names of blocks for this module (Not all module has blocks)
define("_AMS_MI_NEWS_BNAME1","Nuovi Argomenti");
define("_AMS_MI_NEWS_BNAME3","Grande Storia");
define("_AMS_MI_NEWS_BNAME4","Le migliori News");
define("_AMS_MI_NEWS_BNAME5","News Recenti");
define("_AMS_MI_NEWS_BNAME6","Modera News");
define("_AMS_MI_NEWS_BNAME7","Naviga attraverso gli Argomenti");
define("_AMS_MI_NEWS_BNAME8","Autori più attivi");
define("_AMS_MI_NEWS_BNAME9","Autori più votati");
define("_AMS_MI_NEWS_BNAME10","Autori con i voti più alti");
define("_AMS_MI_NEWS_BNAME11","Articoli con i voti più alti");
define("_AMS_MI_NEWS_BNAME12","Articoli \"In Primo Piano\"");

// Sub menus in main menu block
define("_AMS_MI_NEWS_SMNAME1","Invia Articolo");
define("_AMS_MI_NEWS_SMNAME2","Archivio");

// Names of admin menu items
define("_AMS_MI_NEWS_ADMENU2","Amministra Argomenti");
define("_AMS_MI_NEWS_ADMENU3","Amministra Articoli");
define("_AMS_MI_NEWS_GROUPPERMS","Invia/Approva Permessi");

// Title of config items
define("_AMS_MI_STORYHOME","Seleziona il numero di Articoli da mostrare all'inizio della pagina");
define("_AMS_MI_STORYCOUNTTOPIC","Seleziona il numero di Articoli da mostrare nella pagina topic's");
define("_AMS_MI_NOTIFYSUBMIT","Seleziona Sì per inviare messaggio di notifica sul nuovo invio al Webmaster");
define("_AMS_MI_DISPLAYNAV","Seleziona Sì per visualizzare il box di navigazione all'inizio della pagina di ogni modulo");
define("_AMS_MI_AUTOAPPROVE","Auto approvazione articoli senza l'intervento dell'Amministratore?");
define("_AMS_MI_ALLOWEDSUBMITGROUPS","Gruppi che possono inviare Articoli");
define("_AMS_MI_ALLOWEDAPPROVEGROUPS","Gruppi che possono approvare Articoli");
define("_AMS_MI_NEWSDISPLAY","Mostra layout articolo");
define("_AMS_MI_NAMEDISPLAY","Nome Autore");
define("_AMS_MI_COLUMNMODE","Colonne");
define("_AMS_MI_STORYCOUNTADMIN","Numero di articoli da mostrare nell area di amministrazione: ");
define("_AMS_MI_UPLOADFILESIZE","Dimensione massima dei file caricati (KB) 1048576 = 1 Meg");
define("_AMS_MI_UPLOADGROUPS","Gruppo autorizzato all'upload");
define("_AMS_MI_MAXITEMS","Elementi massimi consentiti");
define("_AMS_MI_MAXITEMDESC","Questo imposta il numero massimo di elementi che un utente può selezionare nel box di navigazione nell'indice o pagine argomento.");


// Description of each config items
define("_AMS_MI_STORYHOMEDSC","Questo controlla quanti elementi verranno visualizzati all'inizio della pagina (per esempio quando nessun argomento è selezionato)");
define("_AMS_MI_NOTIFYSUBMITDSC","");
define("_AMS_MI_DISPLAYNAVDSC","");
define("_AMS_MI_AUTOAPPROVEDSC","");
define("_AMS_MI_ALLOWEDSUBMITGROUPSDESC","I gruppi selezionati saranno abilitati ad inviare articoli");
define("_AMS_MI_ALLOWEDAPPROVEGROUPSDESC","I gruppi selezionati saranno abilitati ad approvare gli articoli");
define("_AMS_MI_NEWSDISPLAYDESC","'Classic' mostra tutti gli articoli ordinati per data di pubblicazione. 'Per Argomento' raggrupperà gli articoli per argomento con gli ultimi articoli completi e gli altri solo il titolo");
define("_AMS_MI_ADISPLAYNAMEDSC","Seleziona come visualizzare il nome dell'autore");
define("_AMS_MI_COLUMNMODE_DESC","Puoi scegliere il numero di colonne per visualizzare la lista articoli ");
define("_AMS_MI_STORYCOUNTADMIN_DESC","");
define("_AMS_MI_STORYCOUNTTOPIC_DESC","Questo controlla quanti elementi verranno visualizzati nella pagina dell'argomento (per esempio not front page)");
define("_AMS_MI_UPLOADFILESIZE_DESC","");
define("_AMS_MI_UPLOADGROUPS_DESC","Seleziona i gruppi che possono caricare nel server");

// Name of config item values
define("_AMS_MI_NEWSCLASSIC","Classic");
define("_AMS_MI_NEWSBYTOPIC","Per Argomento");
define("_AMS_MI_DISPLAYNAME1","Username");
define("_AMS_MI_DISPLAYNAME2","Nome reale");
define("_AMS_MI_DISPLAYNAME3","Non visualizzare l'Autore");
define("_AMS_MI_UPLOAD_GROUP1","Chi Invia e chi Approva");
define("_AMS_MI_UPLOAD_GROUP2","Solo chi Approva");
define("_AMS_MI_UPLOAD_GROUP3","Upload Disabilitato");
define("_AMS_MI_INDEX_NAME","Nome della pagina Indice");
define("_AMS_MI_INDEX_DESC","Questo verrà visualizzato come link top-level nella breadcrumbs nell'argomento e nell'articolo");

// Text for notifications

define("_AMS_MI_NEWS_GLOBAL_NOTIFY","Global");
define("_AMS_MI_NEWS_GLOBAL_NOTIFYDSC","Opzioni di notifica delle Global News.");

define("_AMS_MI_NEWS_STORY_NOTIFY","Story");
define("_AMS_MI_NEWS_STORY_NOTIFYDSC","Opzioni di notifica da applicare alla Storia corrente.");

define("_AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFY","Nuovo Argomento");
define("_AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP","Notificami quando un Nuovo Argomento viene creato.");
define("_AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC","Ricevi notifica quando un Nuovo Aargomento viene creato.");
define("_AMS_MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notifica : New news topic");

define("_AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFY","Nuova Storia Inviata");
define("_AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP","Notificami quando ogni nuovo articolo viene inviato (in attesa di approvazione).");
define("_AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC","Ricevi notifica quando  ogni nuovo articolo viene inviato (in attesa di approvazione).");
define("_AMS_MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notifica : Nuovo Articolo Inviato");

define("_AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFY","Nuova Storia");
define("_AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP","Notificami quando qualsiasi nuovo articolo viene pubblicato.");
define("_AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC","Ricevi notifica quando ogni nuovo articolo viene pubblicato.");
define("_AMS_MI_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notifica : Nuovo Articolo");

define("_AMS_MI_NEWS_STORY_APPROVE_NOTIFY","Storia Approvata");
define("_AMS_MI_NEWS_STORY_APPROVE_NOTIFYCAP","Notificami quando questa storia è approvata.");
define("_AMS_MI_NEWS_STORY_APPROVE_NOTIFYDSC","Ricevi notifica quando questo Articolo viene Approvato");
define("_AMS_MI_NEWS_STORY_APPROVE_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} auto-notifica : Articolo Approvato");

define("_AMS_MI_RESTRICTINDEX","Restringi gli Argomenti nella pagina Indice?");
define("_AMS_MI_RESTRICTINDEXDSC","Se impostato su sì, gli utenti visualizzeranno solo gli articoli elencati nell'indice dagli argomenti, hanno accesso così come impostato nei Permessi");

define("_AMS_MI_ANONYMOUS_VOTE","Abilita Anonimi a Votare gli Articoli");
define("_AMS_MI_ANONYMOUS_VOTE_DESC","Se abilitati, gli utenti Anonimi possono votare gli articoli");

define("_AMS_MI_AUDIENCE","Audience Levels");

define("_AMS_MI_SPOTLIGHT","In Primo Piano");
define("_AMS_MI_SPOTLIGHT_ITEMS","Articoli candidati ad essere In Primo Piano");
define("_AMS_MI_SPOTLIGHT_ITEMS_DESC","Questo è il numero di articoli che sarà messo in lista nella pagina di configurazione \"In Primo Piano\" come selezionabile per articoli spotlighted");

define("_AMS_MI_EDITOR","Editor");
define("_AMS_MI_EDITOR_DESC","Scegli l'editor da usare nel modulo - gli editor non di default DEVONO essere installati separatamente");
define("_AMS_MI_EDITOR_DEFAULT","Xoops Default");
define("_AMS_MI_EDITOR_DHTML","DHTML");
define("_AMS_MI_EDITOR_HTMLAREA","HtmlArea Editor");
define("_AMS_MI_EDITOR_FCK","FCK WYSIWYG Editor");
define("_AMS_MI_EDITOR_KOIVI","Koivi WYSIWYG Editor");
define("_AMS_MI_EDITOR_TINYMCE","TinyMCE WYSIWYG Editor");

define("_AMS_MI_EDITOR_USER_CHOICE","Abilita la scelta dell'editor agli utenti");
define("_AMS_MI_EDITOR_USER_CHOICE_DESC","Abilita gli utenti a scegliere l'editor che vogliono");

define("_AMS_MI_EDITOR_CHOICE","Scelta Editor");
define("_AMS_MI_EDITOR_CHOICE_DESC","Scetle di editor permesse agli utenti");

define("_AMS_MI_SPOTLIGHT_TEMPLATE","Spotlight Templates");
define("_AMS_MI_SPOTLIGHT_TEMPLATE_DESC","Quale template abilitare nel blocco \"In Primo Piano\".");

define("_AMS_MI_ABOUT","Info AMS");
if (!defined("_AMS_MI_MIME_TYPES"))
define("_AMS_MI_MIME_TYPES","MIME Types");

//1.60
// index.php
define('_AMS_MI_NEWS_ADMIN_HOME',"Home");
define("_AMS_MI_NEWS_ADMIN_HOME_DESC","Back to Home");
define("_AMS_MI_NEWS_ADMIN_ABOUT" , "About");
define("_AMS_MI_NEWS_ADMIN_ABOUT_DESC" , "About this module");

?>
