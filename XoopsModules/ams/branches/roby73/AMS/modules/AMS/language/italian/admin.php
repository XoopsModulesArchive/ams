<?php
// $Id: admin.php,v 1.18 2004/07/26 17:51:25 hthouzard Exp $
//%%%%%%	Admin Module Name  Articles 	%%%%%
define("_AMS_AM_DBUPDATED","Database aggiornato con successo!");
define("_AMS_AM_CONFIG","Configurazione AMS");
define("_AMS_AM_AUTOARTICLES","Articoli Automatizzati");
define("_AMS_AM_STORYID","Story ID");
define("_AMS_AM_TITLE","Titolo");
define("_AMS_AM_TOPIC","Argomento");
define("_AMS_AM_ARTICLE","Articolo");
define("_AMS_AM_POSTER","Autore");
define("_AMS_AM_PROGRAMMED","Data/Ora Programmate");
define("_AMS_AM_ACTION","Azione");
define("_AMS_AM_EDIT","Modifica");
define("_AMS_AM_DELETE","Cancella");
define("_AMS_AM_LAST10ARTS","Ultimi %d Articoli");
define("_AMS_AM_PUBLISHED","Pubblicato"); // Published Date
define("_AMS_AM_GO","Vai!");
define("_AMS_AM_EDITARTICLE","Modifica Articolo");
define("_AMS_AM_POSTNEWARTICLE","Pubblica Nuovo Articolo");
define("_AMS_AM_ARTPUBLISHED","Il tuo Articolo è stato pubblicato!");
define("_AMS_AM_HELLO","Ciao %s,");
define("_AMS_AM_YOURARTPUB","Il tuo Articolo inviato è stato pubblicato.");
define("_AMS_AM_TITLEC","Titolo: ");
define("_AMS_AM_URLC","URL: ");
define("_AMS_AM_PUBLISHEDC","Pubblicato: ");
define("_AMS_AM_RUSUREDEL","Sei sicuro che vuoi cancellare questo Articolo e i suoi commenti?");
define("_AMS_AM_YES","Si");
define("_AMS_AM_NO","No");
define("_AMS_AM_INTROTEXT","Testo di introduzione");
define("_AMS_AM_EXTEXT","Testo esteso");
define("_AMS_AM_ALLOWEDHTML","Consenti HTML:");
define("_AMS_AM_DISAMILEY","Disabilita Smiley");
define("_AMS_AM_DISHTML","Disabilita HTML");
define("_AMS_AM_APPROVE","Approva");
define("_AMS_AM_MOVETOTOP","Sposta questa Story in alto");
define("_AMS_AM_CHANGEDATETIME","Cambia data/ora di pubblicazione.");
define("_AMS_AM_NOWSETTIME","Ora è impostato a: %s"); // %s is datetime of publish
define("_AMS_AM_CURRENTTIME","L'ora corrente è: %s");  // %s is the current datetime
define("_AMS_AM_SETDATETIME","Imposta data/ora di pubblicazione");
define("_AMS_AM_MONTHC","Mese:");
define("_AMS_AM_DAYC","Giorno:");
define("_AMS_AM_YEARC","Anno:");
define("_AMS_AM_TIMEC","Ora:");
define("_AMS_AM_PREVIEW","Anteprima");
define("_AMS_AM_SAVE","Salva");
define("_AMS_AM_PUBINHOME","Pubblica in Home?");
define("_AMS_AM_ADD","Aggiungi");

//%%%%%%	Admin Module Name  Topics 	%%%%%

define("_AMS_AM_ADDMTOPIC","Aggiungi un Argomento Principale");
define("_AMS_AM_TOPICNAME","Nome Argomento");
define("_AMS_AM_MAX40CHAR","(max: 40 caratteri)");
define("_AMS_AM_TOPICIMG","Immagine Argomento");
define("_AMS_AM_IMGNAEXLOC","Nome immagine + estensione, collocata in %s");
define("_AMS_AM_FEXAMPLE","Per esempio: games.gif");
define("_AMS_AM_ADDSUBTOPIC","Aggiungi un Sotto-Argomento");
define("_AMS_AM_IN","in");
define("_AMS_AM_MODIFYTOPIC","Modifica Argomento");
define("_AMS_AM_MODIFY","Modifica");
define("_AMS_AM_PARENTTOPIC","Argomento Principale");
define("_AMS_AM_SAVECHANGE","Salva Modifiche");
define("_AMS_AM_DEL","Elimina");
define("_AMS_AM_CANCEL","Cancella");
define("_AMS_AM_WAYSYWTDTTAL","ATTENZIONE: Sei sicuro di voler cancellare questo Argomento e tutte le sue Storie e Commenti?");


// Added in Beta6
define("_AMS_AM_TOPICSMNGR","Amministrazione Argomenti");
define("_AMS_AM_PEARTICLES","Amministra Articoli");
define("_AMS_AM_NEWSUB","Nuovo Invio");
define("_AMS_AM_POSTED","Pubblicato");
define("_AMS_AM_GENERALCONF","Configurazione Generale");

// Added in RC2
define("_AMS_AM_TOPICDISPLAY","Mostra Immagine?");
define("_AMS_AM_TOPICALIGN","Posizione");
define("_AMS_AM_RIGHT","Destra");
define("_AMS_AM_LEFT","Sinistra");

define("_AMS_AM_EXPARTS","Articoli scaduti");
define("_AMS_AM_EXPIRED","Scaduto");
define("_AMS_AM_CHANGEEXPDATETIME","Cambia data/ora di scadenza");
define("_AMS_AM_SETEXPDATETIME","Imposta data/ora di scadenza");
define("_AMS_AM_NOWSETEXPTIME","Ora è impostato a: %s");

// Added in RC3
define("_AMS_AM_ERRORTOPICNAME","Devi inserire un nome Argomento!");
define("_AMS_AM_EMPTYNODELETE","Niente da cancellare!");

// Added 240304 (Mithrandir)
define("_AMS_AM_GROUPPERM","Invia/Approva Permessi");
define("_AMS_AM_SELFILE","Seleziona file");

// Added Novasmart in 2.42
define("_MULTIPLE_PAGE_GUIDE","Type [pagebreak] to split to multiple pages");

// Added by Hervé
define("_AMS_AM_UPLOAD_DBERROR_SAVE","Errore durante l'aggiunta del file all articolo");
define("_AMS_AM_UPLOAD_ERROR","Errore nel caricamento del file");
define("_AMS_AM_UPLOAD_ATTACHFILE","File in Allegato");
define("_AMS_AM_APPROVEFORM","Permessi per Approvare");
define("_AMS_AM_SUBMITFORM","Permessi per Inviare");
define("_AMS_AM_VIEWFORM","Permessi per Vedere");
define("_AMS_AM_APPROVEFORM_DESC","Seleziona, chi approva gli Articoli");
define("_AMS_AM_SUBMITFORM_DESC","Seleziona, chi può inviare gli Articoli");
define("_AMS_AM_VIEWFORM_DESC","Seleziona, chi può vedere quali Argomenti");
define("_AMS_AM_DELETE_SELFILES","Elimina i file selezionati");
define("_AMS_AM_TOPIC_PICTURE","Carica immagine");
define("_AMS_AM_UPLOAD_WARNING","<B>Attenzione, non dimenticare di applicare i permessi di scrittura alle seguenti cartelle: %s</B>");

define("_AMS_AM_NEWS_UPGRADECOMPLETE","Upgrade Complete");
define("_AMS_AM_NEWS_UPDATEMODULE","Carica i moduli di templates e i blocchi");
define("_AMS_AM_NEWS_UPGRADEFAILED","Upgrade Fallito");
define("_AMS_AM_NEWS_UPGRADE","Upgrade");
define("_AMS_AM_ADD_TOPIC","Aggiungi un Argomento");
define("_AMS_AM_ADD_TOPIC_ERROR","Errore, l'Argomento già esiste!");
define("_AMS_AM_ADD_TOPIC_ERROR1","ERRORE: Non puoi selezionare questo Argomento come principale!");
define("_AMS_AM_SUB_MENU","Pubblica questo Argomento come un sotto-menù");
define("_AMS_AM_SUB_MENU_YESNO","Sotto-menù?");
define("_AMS_AM_HITS","Visite");
define("_AMS_AM_CREATED","Creato");
define("_AMS_AM_COMMENTS","Commenti");
define("_AMS_AM_VERSION","Versione");
define("_AMS_AM_PUBLISHEDARTICLES","Articoli Pubblicati");
define("_AMS_AM_TOPICBANNER","Banner");
define("_AMS_AM_BANNERINHERIT","Prendi dalla principale");
define("_AMS_AM_RATING","Rating");
define("_AMS_AM_FILTER","Filtra");
define("_AMS_AM_SORTING","Opzioni di Riordino");
define("_AMS_AM_SORT","Ordina");
define("_AMS_AM_ORDER","Ordine");
define("_AMS_AM_STATUS","Stato");
define("_AMS_AM_OF","di");

define("_AMS_AM_MANAGEAUDIENCES","Imposta Livelli di Audience");
define("_AMS_AM_AUDIENCENAME","Nome di Audience");
define("_AMS_AM_ACCESSRIGHTS","Diritti di Accesso");
define("_AMS_AM_LINKEDFORUM","Forum Linkato");
define("_AMS_AM_VERSIONCOUNT","Versione");
define("_AMS_AM_AUDIENCEHASSTORIES","%u articoli hanno questa audience, seleziona un nuovo livello di audience per questi articoli");
define("_AMS_AM_RUSUREDELAUDIENCE","Sei sicuro di voler cancellare completamente questo livello di audience?");
define("_AMS_AM_PLEASESELECTNEWAUDIENCE","Seleziona un Livello di Audience Sostitutivo");
define("_AMS_AM_AUDIENCEDELETED","Audience Cancellato con Successo");
define("_AMS_AM_ERROR_AUDIENCENOTDELETED","Errore - Audience NON Cancellato");
define("_AMS_AM_CANNOTDELETEDEFAULTAUDIENCE","Errore - Non è possibile cancellare l audience di default");

define("_AMS_AM_NOTOPICSELECTED","Nessun Argomento Selezionato");
define("_AMS_AM_SUBMIT","Invia");
define("_AMS_AM_ERROR_REORDERERROR","Errore - Si sono verificati errori durante Riordino");
define("_AMS_AM_REORDERSUCCESSFUL","Argomenti Riordinati");

define("_AMS_AM_NONE","Nessuna Immagine");
define("_AMS_AM_AUTHOR","Avatar dell'Autore");

define("_AMS_AM_SPOT_ADD","Aggiungi un Mini Blocco Primo Piano");
define("_AMS_AM_SPOT_EDITBLOCK","Modifica Impostazioni del Blocco");
define("_AMS_AM_SPOT_NAME","Nome");
define("_AMS_AM_SPOT_SHOWIMAGE","Mostra Immmagine");
define("_AMS_AM_SPOT_SHOWIMAGE_DESC","Seleziona un'immagine da mostrare o imposta l'immagine dell'argomento o l'avatar dell'Autore");
define("_AMS_AM_SPOT_WEIGHT","Peso");
define("_AMS_AM_SPOT_DISPLAY","Mostra");
define("_AMS_AM_SPOT_MAIN","Principale");
define("_AMS_AM_SPOT_MINI","Mini");
define("_AMS_AM_SPOTLIGHT","In Primo Piano");
define("_AMS_AM_WEIGHT","Peso");
define("_AMS_AM_SPOT_SAVESUCCESS","Articolo In Primo Piano salvato con successo");
define("_AMS_AM_SPOT_DELETESUCCESS","Articolo In Primo Piano cancellato con successo");
define("_AMS_AM_RUSUREDELSPOTLIGHT","Sei sicuro di voler rimuovere questo Articolo In Primo Piano?");

define("_AMS_AM_SPOT_LATESTARTICLE","Ultimi Articoli");
define("_AMS_AM_SPOT_LATESTINTOPIC","Ultimo nell'Argomento");
define("_AMS_AM_SPOT_SPECIFICARTICLE","Articolo Specifico");
define("_AMS_AM_SPOT_NOIMAGE","Nessuna Immagine");
define("_AMS_AM_SPOT_MODE_SELECT","Modalità In Primo Piano");
define("_AMS_AM_SPOT_SPECIFYIMAGE","Specifica Immagine");
define("_AMS_AM_SPOT_TOPICIMAGE","Immagine dall'Argomento");
define("_AMS_AM_SPOT_AUTHORIMAGE","Avatar Autore");
define("_AMS_AM_SPOT_IMAGE","Immagine");
define("_AMS_AM_SPOT_AUTOTEASER","Introduzione Automatica");
define("_AMS_AM_SPOT_MAXLENGTH","Lunghezza massima Introduzione Automatica");
define("_AMS_AM_SPOT_TEASER","Testo Introduzione Manuale");
define("_AMS_AM_SPOT_TOPIC_DESC","Se è selezionato \"Ultimo nell'Argomento\", da quale Argomento deve essere selezionato?");
define("_AMS_AM_SPOT_ARTICLE_DESC","Se è selezionato\"Articolo Specifico\", quale articolo deve essere visualizzato?");
define("_AMS_AM_SPOT_CUSTOM","Personalizza");

define("_AMS_AM_PREFERENCES","Preferenze");
define("_AMS_AM_GOMOD","Vai al Modulo");
define("_AMS_AM_ABOUT","Info AMS");
define("_AMS_AM_MODADMIN","Modulo di Amministrazione");

// admin SEO
define("_AMS_AM_SEO_SUBMITFORM","SEO Setting");
define("_AMS_AM_SEO_ENABLE","Abilita");
define("_AMS_AM_SEO_VALIDTAG","Valid Tag");
if (!defined("_AMS_MI_MIME_TYPES"))
define("_AMS_MI_MIME_TYPES","MIME Types");
define("_AMS_AM_SEO_URLTEMPLATE","Custom URL Template");
define("_AMS_AM_SEO_FRIENDLYURL","Friendly URL"); 
