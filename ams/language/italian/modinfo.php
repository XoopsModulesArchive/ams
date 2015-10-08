<?php
// $Id: modinfo.php,v 1.16 2004/06/09 09:57:33 mithyt2 Exp $
// Module Info

// The name of this module
define("_MI_AMS_NAME","Articoli");

// A brief description of this module
define("_MI_AMS_DESC","Crea una sezione come Slashdot-articolo, in cui gli utenti possono inserire articoli e commenti.");

// Admin Menu
define("_MI_AMS_ADMENU1","Home page");
define("_MI_AMS_ADMENU2","Categorie");
define("_MI_AMS_ADMENU3","Articoli");
define("_MI_AMS_ADMENU4","Autorizzazioni");
define("_MI_AMS_ADMENU5","Impostazioni");
define("_MI_AMS_ADMENU6","Destinatari");
define("_MI_AMS_ADMENU7","Messi in evidenza");
define("_MI_AMS_ADMENU8","Informazioni");

// Names of blocks for this module (Not all module has blocks)
define("_MI_AMS_BNAME1","Attualità Temi");
define("_MI_AMS_BNAME3","Storia");
define("_MI_AMS_BNAME4","Top News");
define("_MI_AMS_BNAME5","Ultime notizie");
define("_MI_AMS_BNAME6","Modera news");
define("_MI_AMS_BNAME7","Navigare tra gli argomenti");
define("_MI_AMS_BNAME8","Autori più attivi");
define("_MI_AMS_BNAME9","Gli autori più letti");
define("_MI_AMS_BNAME10","Autori nominale più alto");
define("_MI_AMS_BNAME11","Articoli più alto nominale");
define("_MI_AMS_BNAME12","Messi in evidenza");

// Sub menus in main menu block
define("_MI_AMS_SMNAME1","Invia un articolo");
define("_MI_AMS_SMNAME2","Archivio");

// Title of config items
define("_MI_AMS_STORYHOME","Selezionare il numero di articoli da visualizzare nella pagina in alto");
define("_MI_AMS_STORYCOUNTTOPIC","Selezionare il numero di articoli da visualizzare su un argomento \"s pagina");
define("_MI_AMS_NOTIFYSUBMIT","Selezionare Sì per inviare messaggi di notifica per webmaster su presentazione nuovo");
define("_MI_AMS_DISPLAYNAV","Selezionare Sì per visualizzare la finestra di navigazione nella parte superiore di ogni pagina del modulo");
define("_MI_AMS_AUTOAPPROVE","Auto approvazione degli articoli senza l&#39;intervento di admin?");
define("_MI_AMS_ALLOWEDSUBMITGROUPS","Gruppi che possono Presenti gli articoli");
define("_MI_AMS_ALLOWEDAPPROVEGROUPS","Gruppi che possono approvare gli articoli");
define("_MI_AMS_NEWSDISPLAY","L&#39;articolo di visualizzazione layout");
define("_MI_AMS_NAMEDISPLAY","Per nome autore");
define("_MI_AMS_COLUMNMODE","Colonne");
define("_MI_AMS_STORYCOUNTADMIN","Numero di nuovi articoli da visualizzare nella zona admin:");
define("_MI_AMS_UPLOADFILESIZE","Max Upload filesize (KB) 1048576 = 1 Meg");
define("_MI_AMS_UPLOADGROUPS","Gruppi autorizzati a caricare");
define("_MI_AMS_MAXITEMS","Massimo consentito articoli");
define("_MI_AMS_MAXITEMDESC","Imposta il numero massimo di elementi, un utente può selezionare nella finestra di navigazione sulle pagine di indice o di un argomento");


// Description of each config items
define("_MI_AMS_STORYHOME_DESC","Questo controlla quanti elementi verranno visualizzati nella pagina in alto (cioè quando nessun tema è selezionato)");
define("_MI_AMS_NOTIFYSUBMIT_DESC","");
define("_MI_AMS_DISPLAYNAV_DESC","");
define("_MI_AMS_AUTOAPPROVE_DESC","");
define("_MI_AMS_ALLOWEDSUBMITGROUPSDESC","I gruppi selezionati saranno in grado di presentare articoli");
define("_MI_AMS_ALLOWEDAPPROVEGROUPSDESC","I gruppi selezionati saranno in grado di approvare gli articoli");
define("_MI_AMS_NEWSDISPLAYDESC","Classica mostra tutti gli articoli ordinati per data di pubblicazione. Articoli per argomento sarà il gruppo di articoli per argomento con l&#39;ultimo articolo per intero e gli altri con il solo titolo");
define("_MI_AMS_ADISPLAYNAME_DESC","Selezionare come visualizzare l&#39;autore \"nome s");
define("_MI_AMS_COLUMNMODE_DESC","È possibile scegliere il numero di colonne da visualizzare lista articoli");
define("_MI_AMS_STORYCOUNTADMIN_DESC","");
define("_MI_AMS_STORYCOUNTTOPIC_DESC","Questo controlla quanti elementi verranno visualizzati in una pagina argomento (cioè non prima pagina)");
define("_MI_AMS_UPLOADFILESIZE_DESC","");
define("_MI_AMS_UPLOADGROUPS_DESC","Selezionare i gruppi che possono caricare sul server");

// Name of config item values
define("_MI_AMS_NEWSCLASSIC","Classico");
define("_MI_AMS_NEWSBYTOPIC","Per argomento");
define("_MI_AMS_DISPLAYNAME1","Nome utente");
define("_MI_AMS_DISPLAYNAME2","Nome reale");
define("_MI_AMS_DISPLAYNAME3","Non visualizzare autore");
define("_MI_AMS_UPLOAD_GROUP1","Presentatori e approvazioni");
define("_MI_AMS_UPLOAD_GROUP2","Solo approvatori");
define("_MI_AMS_UPLOAD_GROUP3","Carica disabili");
define("_MI_AMS_INDEX_NAME","Nome di indice");
define("_MI_AMS_INDEX_DESC","Questo sarà visualizzato come top-level link nel pangrattato in argomento e vista articolo");

// Text for notifications

define("_MI_AMS_NEWS_GLOBAL_NOTIFY","globale");
define("_MI_AMS_NEWS_GLOBAL_NOTIFY_DESC","Globale notizie opzioni di notifica.");

define("_MI_AMS_NEWS_STORY_NOTIFY","Storia");
define("_MI_AMS_NEWS_STORY_NOTIFY_DESC","Opzioni di notifica che si applicano alla storia attuale.");

define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFY","Nuovo argomento");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP","Inviami una notifica quando una risposta viene creato.");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFY_DESC","Ricevere la notifica quando una risposta viene creato.");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ","[X_SITENAME {}]} {X_MODULE auto-notify: Leggi News Nuovi");

define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFY","New Story Inviato");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP","Inviami una notifica quando un nuovo articolo viene presentata (in attesa di approvazione).");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFY_DESC","Ricevere la notifica quando un nuovo articolo viene presentata (in attesa di approvazione).");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ","[X_SITENAME {}]} {X_MODULE auto-notifica: Nuovo articolo presentato");

define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFY","Storia");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP","Inviami una notifica quando un nuovo articolo viene pubblicato.");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFY_DESC","Ricevere la notifica quando un nuovo articolo viene pubblicato.");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ","[X_SITENAME {}]} {X_MODULE auto-notifica: Nuovo articolo");

define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFY","Approvato storia");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYCAP","Fammi sapere quando il racconto è approvato.");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFY_DESC","Ricevere una notifica quando questo articolo è approvato.");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYSBJ","[X_SITENAME {}]} {X_MODULE auto-notify: Approvato l&#39;articolo");

define("_MI_AMS_NEWS_GLOBAL_NOTIFYDSC","Approvato storia");
define("_MI_AMS_NEWS_STORY_NOTIFYDSC","Approvato storia");
define("_MI_AMS_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC","Approvato storia");
define("_MI_AMS_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC","Approvato storia");
define("_MI_AMS_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC","Approvato storia");
define("_MI_AMS_NEWS_STORY_APPROVE_NOTIFYDSC","Approvato storia");

define("_MI_AMS_RESTRICTINDEX","Limitare Argomenti su Index Page?");
define("_MI_AMS_RESTRICTINDEX_DESC","Se impostato su yes, gli utenti vedranno solo articoli elencati nell&#39;indice di argomenti, hanno accesso da impostare come in Autorizzazioni articolo");

define("_MI_AMS_ANONYMOUS_VOTE","Abilita Valutazione Anonimo degli articoli");
define("_MI_AMS_ANONYMOUS_VOTE_DESC","Se abilitato, gli utenti anonimi possono votare gli articoli");

define("_MI_AMS_AUDIENCE","Livelli di pubblico");

define("_MI_AMS_SPOTLIGHT","messi in evidenza");
define("_MI_AMS_SPOTLIGHT_ITEMS","Spotlight articolo candidati");
define("_MI_AMS_SPOTLIGHT_ITEMS_DESC","Questo è il numero di articoli che saranno elencate nella pagina di configurazione selezionabili riflettori come per l&#39;articolo messo in luce");

define("_MI_AMS_EDITOR","Editor");
define("_MI_AMS_EDITOR_DESC","Scegliere l&#39;editor da usare in forma presentare - non predefinito editor DEVE essere installato separatamente");

define("_MI_AMS_SPOTLIGHT_TEMPLATE","Spotlight Modelli");
define("_MI_AMS_SPOTLIGHT_TEMPLATE_DESC","Quale modello di permesso di amministrazione da utilizzare sotto i riflettori blocco");

define("_MI_AMS_MIME_TYPES","Tipi MIME");

define("_MI_AMS_PERMISSION_ARTICLES","Permessi articoli");
define("_MI_AMS_PERMISSION_ARTICLES1","Permessi di articoli 1");
define("_MI_AMS_PERMISSION_ARTICLES2","Permessi articoli 2");
define("_MI_AMS_NUMCOLUMNS","Numero di colonne.");
define("_MI_AMS_NUMCOLUMN_DESC","Numero di colonne.");
define("_MI_AMS_NUMROWS","Numero di righe");
define("_MI_AMS_NUMROWS_DESC","Numero di righe");
define("_MI_AMS_ADMIN_PERPAGE","Admin per pagina");
define("_MI_AMS_ADMIN_PERPAGE_DESC","Admin per pagina");
// Tell a Friend
define("_MI_AMS_USETELLAFRIEND","Modulo TellaFriend");
define("_MI_AMS_USETELLAFRIEND_DESC","Attivare l'uso del modulo tellafriend?<br />E&#39 necessario che questo sia prima installato sul server.");
?><?php

// Translation done by XTransam & admin (info@txmodxoops.org)
// XTransam 1.2 is written by Chronolabs Co-op & The XOOPS Project - File Dumped on 2011-12-16 08:47

?>