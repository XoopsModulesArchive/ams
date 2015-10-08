<?php
// $Id: main.php,v 1.3 2004/04/10 16:04:12 hthouzard Exp $
//%%%%%%		File Name index.php 		%%%%%
define("_AMS_NW_PRINTER","Pagina stampabile");
define("_AMS_NW_SENDSTORY","Invia questo articolo ad un amico");
define("_AMS_NW_READMORE","Leggi tutto...");
define("_AMS_NW_COMMENTS","Commenti?");
define("_AMS_NW_ONECOMMENT","1 commento");
define("_AMS_NW_BYTESMORE","%s più parole");
define("_AMS_NW_NUMCOMMENTS","%s commenti");
define("_AMS_NW_MORERELEASES","Altre versioni ");

//%%%%%%		File Name submit.php		%%%%%
define("_AMS_NW_SUBMITNEWS","Invia Articolo");
define("_AMS_NW_TITLE","Titolo");
define("_AMS_NW_TOPIC","Argomento");
define("_AMS_NW_THESCOOP","Testo Articolo");
define("_AMS_NW_NOTIFYPUBLISH","Notifica via mail quando pubblicato");
define("_AMS_NW_POST","Pubblica");
define("_AMS_NW_GO","Vai!");
define("_AMS_NW_THANKS","Grazie per il tuo invio."); //submission of news article

define("_AMS_NW_NOTIFYSBJCT","Articolo per il mio sito"); // Notification mail subject
define("_AMS_NW_NOTIFYMSG","Hai un nuovo invio per il tuo sito."); // Notification mail message

//%%%%%%		File Name archive.php		%%%%%
define("_AMS_NW_NEWSARCHIVES","Archivio articoli");
define("_AMS_NW_ARTICLES","Articoli");
define("_AMS_NW_VIEWS","Visite");
define("_AMS_NW_DATE","Data");
define("_AMS_NW_ACTIONS","Azioni");
define("_AMS_NW_PRINTERFRIENDLY","Pagina stampabile");

define("_AMS_NW_THEREAREINTOTAL","Ci sono %s articolo(i) in totale");

// %s is your site name
define("_AMS_NW_INTARTICLE","Articolo interessante su %s");
define("_AMS_NW_INTARTFOUND","Qui c'e' un articolo interessante che ho trovato su %s");

define("_AMS_NW_TOPICC","Argomento:");
define("_AMS_NW_URL","URL:");
define("_AMS_NW_NOSTORY","Spiacenti, l'articolo selezionato non esiste.");

//%%%%%%	File Name print.php 	%%%%%

define("_AMS_NW_URLFORSTORY","La URL per questo articolo è:");

// %s represents your site name
define("_AMS_NW_THISCOMESFROM","Questo articolo viene da %s");

// Added by Hervé
define("_AMS_NW_ATTACHEDFILES","Files allegati:");

define("_AMS_NW_MAJOR","Modifica proncipale?");
define("_AMS_NW_STORYID","ID articolo");
define("_AMS_NW_VERSION","Versione");
define("_AMS_NW_SETVERSION","Imposta versione corrente");
define("_AMS_NW_VERSIONUPDATED","Versione corrente impostata a %s");
define("_AMS_NW_OVERRIDE","Annulla");
define("_AMS_NW_FINDVERSION","Trova Versione");
define("_AMS_NW_REVISION","Revisiona");
define("_AMS_NW_MINOR","Revisioni minori");
define("_AMS_NW_VERSIONDESC","Scegli livello di cambio - se NON specifichi il file non verrà aggiornato!");
define("_AMS_NW_NOVERSIONCHANGE","Nessun cambiamento di versione");
define("_AMS_NW_AUTO","Auto");

define("_AMS_NW_RATEARTICLE","Vota Articolo");
define("_AMS_NW_RATE","Vota Articolo");
define("_AMS_NW_SUBMITRATING","Invia voto");
define("_AMS_NW_RATING_SUCCESSFUL","Articolo votato con successo");
define("_AMS_NW_PUBLISHED_DATE","Data di pubblicazione: ");
define("_AMS_NW_POSTEDBY","Autore");
define("_AMS_NW_READS","Numero di letture");
define("_AMS_NW_AUDIENCE","Audience");
define("_AMS_NW_SWITCHAUTHOR","Aggiora Autore?");

//Warnings
define("_AMS_NW_VERSIONSEXIST","%s Versione(i) con la versione più recente e <strong> </strong> verrà modificata con nessuna possibilità di recupero:");
define("_AMS_NW_AREYOUSUREOVERRIDE","Sei sicuro di voler sostituire queste versioni?");
define("_AMS_NW_CONFLICTWHAT2DO","Un articolo calcolato con il numero di versione esiste<br />Cosa vuoi fare?<br />Annulla: Questa versione verrà salvata con il numero calcolato di versione e tutte le versioni più recenti nello stesso gruppo (xx.xx.xx) verrà cancellata<br />Trova Versione: Lascia trovare al sistema la prossima versione disponibile nello stesso gruppo di versioni");
define("_AMS_NW_VERSIONCONFLICT","Versione in conflitto");
define("_AMS_NW_TRYINGTOSAVE","Tentativo di salvataggio ");

//Error messages
define("_AMS_NW_ERROR","Errore");
define("_AMS_NW_RATING_FAILED","Votazione fallita!");
define("_AMS_NW_SAVEFAILED","Salvataggio articolo fallito!");
define("_AMS_NW_TEXTSAVEFAILED","Potresti non poter salvare il testo dell'articolo");
define("_AMS_NW_VERSIONUPDATEFAILED","Potresti non poter aggiornare la versione");
define("_AMS_NW_COULDNOTRESET","Potresti non poter resettare la versione");
define("_AMS_NW_COULDNOTUPDATEVERSION","Potresti non poter aggiornare la versione corrente");

define("_AMS_NW_COULDNOTSAVERATING","Potresti non aver salvato la votazione");
define("_AMS_NW_COULDNOTUPDATERATING","Potresti non aver salvato la votazione dell'articolo");

define("_AMS_NW_COULDNOTADDLINK","Il link potrebbe non essere correlato all'articolo");
define("_AMS_NW_COULDNOTDELLINK","Errore - Link non cancellato");

define("_AMS_NW_CANNOTVOTESELF","L'autore non può votare gli articoli");
define("_AMS_NW_ANONYMOUSVOTEDISABLED","Votazione anonima disabilitata");
define("_AMS_NW_ANONYMOUSHASVOTED","Questo IP ha già votato questo articolo");
define("_AMS_NW_USERHASVOTED","Hai già votato questo articolo");

define("_AMS_NW_NOTALLOWEDAUDIENCE","Non ti è permesso leggere %s articoli di livello");
define("_AMS_NW_NOERRORSENCOUNTERED","Nessun errore");

//Additional constants
define("_AMS_NW_USERNAME","Username");
define("_AMS_NW_ADDLINK","Aggiungi Link(s)");
define("_AMS_NW_DELLINK","Rimuovi Link(s)");
define("_AMS_NW_RELATEDARTICLES","Lettura raccomandata");
define("_AMS_NW_SEARCHRESULTS","Risultati di ricerca:");
define("_AMS_NW_MANAGELINK","Links");
define("_AMS_NW_DELVERSIONS","Cancella la versione di seguito a questa");
define("_AMS_NW_DELALLVERSIONS","Cancella tutte le versioni tranne questa");
define("_AMS_NW_SUBMIT","Invia");
define("_AMS_NW_RUSUREDELVERSIONS","Sei sicuro di voler cancellare tutte le versioni senza alcuna possibilità di ripristino?!! Seguenti a questa versione?");
define("_AMS_NW_RUSUREDELALLVERSIONS","Sei sicuro di voler cancellare tutte le versioni senza alcuna possibilità di ripristino?!! Tranne questa versione?");
define("_AMS_NW_EXTERNALLINK","Link esterno");
define("_AMS_NW_ADDEXTERNALLINK","Aggiungi Link esterno");
define("_AMS_NW_PREREQUISITEARTICLES","Lettura prerequisita");
define("_AMS_NW_LINKTYPE","Link Type");
define("_AMS_NW_SETTITLE","Seleziona titolo link");
define("_AMS_NW_BANNER","Banner/Sponsor");

define("_AMS_NW_NOTOPICS","Non esistono argomenti - Per favore crea un argomento ed imposta i permessi appropriati prima di inviare un articolo");

define("_AMS_NW_TOTALARTICLES","Totale Articoli");

define("_AMS_MA_INDEX","Indice");
define("_AMS_MA_SUBTOPICS","Sotto-argomenti per ");
define("_AMS_MA_PAGEBREAK","Interruzione di Pagina");
define("_AMS_NW_POSTNEWARTICLE","Invia un nuovo articolo");

//Bookmarks 
define("_MD_AMS_BOOKMARK_ME","<b>Segnala l'articolo su:</b>");
define("_MD_AMS_BOOKMARK_TO_BLINKLIST","Segnalami a Blinklist");
define("_MD_AMS_BOOKMARK_TO_DELICIOUS","Segnalami a del.icio.us");
define("_MD_AMS_BOOKMARK_TO_DIGG","Segnalami a Digg");
define("_MD_AMS_BOOKMARK_TO_FARK","Segnalami a Fark");
define("_MD_AMS_BOOKMARK_TO_FURL","Segnalami a Furl");
define("_MD_AMS_BOOKMARK_TO_NEWSVINE","Segnalami a Newsvine");
define("_MD_AMS_BOOKMARK_TO_REDDIT","Segnalami a Reddit");
define("_MD_AMS_BOOKMARK_TO_SIMPY","Segnalami a Simpy");
define("_MD_AMS_BOOKMARK_TO_SPURL","Segnalami a Spurl");
define("_MD_AMS_BOOKMARK_TO_YAHOO","Segnalami a Yahoo");
define("_MD_AMS_BOOKMARK_TO_FACEBOOK","Segnalami a Facebook");
define("_MD_AMS_BOOKMARK_TO_TWITTER","Segnalami a Twitter");
define("_MD_AMS_BOOKMARK_TO_SCRIPSTYLE","Segnalami a Scripstyle");
define("_MD_AMS_BOOKMARK_TO_STUMBLE","Segnalami a Stumble");
define("_MD_AMS_BOOKMARK_TO_TECHNORATI","Segnalami a Technorati");
define("_MD_AMS_BOOKMARK_TO_MIXX","Segnalami a Mixx");
define("_MD_AMS_BOOKMARK_TO_MYSPACE","Segnalami a Myspace");
define("_MD_AMS_BOOKMARK_TO_DESIGNFLOAT","Segnalami a DesignFloat");
define("_MD_AMS_BOOKMARK_TO_BALATARIN","Segnalami a Balatarin");
define("_MD_AMS_BOOKMARK_TO_GOOLGEBUZZ","Segnalami a Twitter");
define("_MD_AMS_BOOKMARK_TO_GOOLGEREADER","Segnalami a Twitter");
define("_MD_AMS_BOOKMARK_TO_GOOLGEBOOKMARKS","Segnalami a Google Bookmarks");

?>
