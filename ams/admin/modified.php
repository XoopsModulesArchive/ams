<?php
/**
 * TDMDownload
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   Gregory Mage (Aka Mage)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Gregory Mage (Aka Mage)
 */

include 'admin_header.php';

//On recupere la valeur de l'argument op dans l'URL$
$op = ams_CleanVars($_REQUEST, 'op', 'list', 'string');

//Les valeurs de op qui vont permettre d'aller dans les differentes parties de la page
switch ($op)
{
    // Vue liste
    case "list":
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();
        if (TDMDownloads_checkModuleAdmin()){
            $modified_admin = new ModuleAdmin();
            echo $modified_admin->addNavigation('modified.php');
        }
        $criteria = new CriteriaCompo();
        if (isset($_REQUEST['limit'])) {
             $criteria->setLimit($_REQUEST['limit']);
             $limit = $_REQUEST['limit'];
         } else {
             $criteria->setLimit($xoopsModuleConfig['perpageadmin']);
             $limit = $xoopsModuleConfig['perpageadmin'];
         }
        if (isset($_REQUEST['start'])) {
            $criteria->setStart($_REQUEST['start']);
            $start = $_REQUEST['start'];
        } else {
            $criteria->setStart(0);
             $start = 0;
         }
        $criteria->setSort('requestid');
        $criteria->setOrder('ASC');
        $amsmod_arr = $amsmod_Handler->getall($criteria);
        $numrows = $amsmod_Handler->getCount($criteria);
        if ( $numrows > $limit ) {
            $pagenav = new XoopsPageNav($numrows, $limit, $start, 'start', 'op=liste&limit=' . $limit);
             $pagenav = $pagenav->renderNav(4);
         } else {
             $pagenav = '';
         }
        //Affichage du tableau des téléchargements modifiés
        if ($numrows > 0) {
            echo '<table width="100%" cellspacing="1" class="outer">';
            echo '<tr>';
            echo '<th align="center">' . _AM_AMS_FORMTITLE . '</th>';
            echo '<th align="center" width="20%">' . _AM_AMS_BROKEN_SENDER . '</th>';
            echo '<th align="center" width="15%">'._AM_AMS_FORMACTION.'</th>';
            echo '</tr>';
            $class = 'odd';
            foreach (array_keys($amsmod_arr) as $i) {
                $class = ($class == 'even') ? 'odd' : 'even';
                $storyid = $amsmod_arr[$i]->getVar('storyid');
                $ams_requestid = $amsmod_arr[$i]->getVar('requestid');
                $ams =& $ams_Handler->get($amsmod_arr[$i]->getVar('storyid'));
                // pour savoir si le fichier est nouveau
                $ams_url = $ams->getVar('url');
                $modams_url = $amsmod_arr[$i]->getVar('url');
                $new_file = ($ams_url == $modams_url ? false : true);
                 echo '<tr class="' . $class . '">';
                echo '<td align="center">' . $ams->getVar('title') . '</td>';
                echo '<td align="center"><b>' . XoopsUser::getUnameFromId($amsmod_arr[$i]->getVar('modifysubmitter')) . '</b></td>';
                echo '<td align="center" width="15%">';
                echo '<a href="modified.php?op=view_ams&storyid=' . $storyid . '&mod_id=' . $ams_requestid . '"><img src="../images/icon/view_mini.png" alt="' . _AM_AMS_FORMDISPLAY . '" title="' . _AM_AMS_FORMDISPLAY . '"></a> ';
                echo '<a href="modified.php?op=del_modams&mod_id=' . $ams_requestid . '&new_file=' . $new_file . '"><img src="../images/icon/ignore_mini.png" alt="' . _AM_AMS_FORMIGNORE . '" title="' . _AM_AMS_FORMIGNORE . '"></a>';
                echo '</td>';
             }
             echo '</table><br />';
             echo '<br /><div align=right>' . $pagenav . '</div><br />';
        }else{
            echo '<div class="errorMsg" style="text-align: center;">' . _AM_AMS_ERREUR_NOBMODDOWNLOADS . '</div>';
        }
    break;

    // Affiche la comparaison de fichier
    case "view_ams":
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();
        if (TDMDownloads_checkModuleAdmin()){
            $modified_admin = new ModuleAdmin();
            echo $modified_admin->addNavigation('modified.php');
            $modified_admin->addItemButton(_MI_AMS_ADMENU5, 'modified.php', 'list');
            echo $modified_admin->renderButton();
        }
        //information du téléchargement
        $view_ams = $ams_Handler->get($_REQUEST['storyid']);
        //information du téléchargement modifié
        $view_modams = $amsmod_Handler->get($_REQUEST['mod_id']);

        // original
        $ams_title = $view_ams->getVar('title');
        $ams_url = $view_ams->getVar('url');
        //catégorie
        $view_categorie = $amscat_Handler->get($view_ams->getVar('cid'));
        $ams_categorie = $view_categorie->getVar('cat_title');
        $ams_homepage = $view_ams->getVar('homepage');
        $ams_version = $view_ams->getVar('version');
        $ams_size = $view_ams->getVar('size');
        $ams_platform = $view_ams->getVar('platform');
        $ams_description = $view_ams->getVar('description');
        $ams_logourl = $view_ams->getVar('logourl');
        // modifié
        $modams_title = $view_modams->getVar('title');
        $modams_url = $view_modams->getVar('url');
        //catégorie
        $view_categorie = $amscat_Handler->get($view_modams->getVar('cid'));
        $modams_categorie = $view_categorie->getVar('cat_title');
        $modams_homepage = $view_modams->getVar('homepage');
        $modams_version = $view_modams->getVar('version');
        $modams_size = $view_modams->getVar('size');
        $modams_platform = $view_modams->getVar('platform');
        $modams_description = $view_modams->getVar('description');
        $modams_logourl = $view_modams->getVar('logourl');
        echo "<style type=\"text/css\">\n";
        echo ".style_dif {color: #FF0000; font-weight: bold;}\n";
        echo ".style_ide {color: #009966; font-weight: bold;}\n";
        echo "</style>\n";
        //originale
        echo '<table width="100%" border="0" cellspacing="1" class="outer"><tr class="odd"><td>';
        echo '<table border="1" cellpadding="5" cellspacing="0" align="center"><tr><td>';
        echo '<h4>' . _AM_AMS_MODIFIED_ORIGINAL . '</h4>';
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td valign="top" width="50%"><small><span class="' . ($ams_title == $modams_title ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMTITLE . '</span>: ' . $ams_title . '</small></td>';
        echo '<td valign="top" rowspan="14"><small><span class="' . ($ams_description == $modams_description ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMTEXT . '</span>:<br />' . $ams_description . '</small></td>';
        echo '</tr>';
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_url == $modams_url ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMURL . '</span>:<br />' . $ams_url . '</small></td></tr>';
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_categorie == $modams_categorie ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMCAT . '</span>: ' . $ams_categorie . '</small></td></tr>';
        $criteria = new CriteriaCompo();
        $criteria->setSort('weight ASC, title');
        $criteria->setOrder('ASC');
        $criteria->add(new Criteria('status', 1));
        $ams_field = $amsfield_Handler->getall($criteria);
        foreach (array_keys($ams_field) as $i) {
            if ($ams_field[$i]->getVar('status_def') == 1){
                if ($ams_field[$i]->getVar('fid') == 1){
                    //page d'accueil
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_homepage == $modams_homepage ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMHOMEPAGE . '</span>: <a href="' . $ams_homepage . '">' . $ams_homepage . '</a></small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 2){
                    //version
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_version == $modams_version ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMVERSION . '</span>: ' . $ams_version . '</small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 3){
                    //taille du fichier
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_size == $modams_size ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMSIZE . '</span>: ' . $ams_size  . '</small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 4){
                    //plateforme
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_platform == $modams_platform ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMPLATFORM . '</span>: ' . $ams_platform  . '</small></td></tr>';
                }
            }else{
                //original
                $contenu = '';
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $_REQUEST['storyid']));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfielddata = $amsfielddata_Handler->getall($criteria);
                foreach (array_keys($amsfielddata) as $j) {
                    $contenu = $amsfielddata[$j]->getVar('data');
                }
                //proposé
                $mod_contenu = '';
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $_REQUEST['mod_id']));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfieldmoddata = $amsfieldmoddata_Handler->getall($criteria);
                foreach (array_keys($amsfieldmoddata) as $j) {
                    $mod_contenu = $amsfieldmoddata[$j]->getVar('moddata');
                }
                echo '<tr><td valign="top" width="40%"><small><span class="' . ($contenu == $mod_contenu ? 'style_ide' : 'style_dif') . '">' . $ams_field[$i]->getVar('title') . '</span>: ' . $contenu  . '</small></td></tr>';
            }
        }
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_logourl == $modams_logourl ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMIMG . '</span>:<br /> <img src="' . $uploadurl_shots . $ams_logourl . '" alt="" title=""></small></td></tr>';
        echo '</table>';
        //proposé
        echo '</td></tr><tr><td>';
        echo '<h4>' . _AM_AMS_MODIFIED_MOD . '</h4>';
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td valign="top" width="40%"><small><span class="' . ($ams_title == $modams_title ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMTITLE . '</span>: ' . $modams_title . '</small></td>';
        echo '<td valign="top" rowspan="14"><small><span class="' . ($ams_description == $modams_description ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMTEXT . '</span>:<br />' . $modams_description . '</small></td>';
        echo '</tr>';
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_url == $modams_url ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMURL . '</span>:<br />' . $modams_url . '</small></td></tr>';
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_categorie == $modams_categorie ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMCAT . '</span>: ' . $modams_categorie . '</small></td></tr>';
        $criteria = new CriteriaCompo();
        $criteria->setSort('weight ASC, title');
        $criteria->setOrder('ASC');
        $criteria->add(new Criteria('status', 1));
        $ams_field = $amsfield_Handler->getall($criteria);
        foreach (array_keys($ams_field) as $i) {
            if ($ams_field[$i]->getVar('status_def') == 1){
                if ($ams_field[$i]->getVar('fid') == 1){
                    //page d'accueil
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_homepage == $modams_homepage ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMHOMEPAGE . '</span>: <a href="' . $modams_homepage . '">' . $modams_homepage . '</a></small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 2){
                    //version
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_version == $modams_version ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMVERSION . '</span>: ' . $modams_version . '</small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 3){
                    //taille du fichier
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_size == $modams_size ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMSIZE . '</span>: ' . $modams_size  . '</small></td></tr>';
                }
                if ($ams_field[$i]->getVar('fid') == 4){
                    //plateforme
                    echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_platform == $modams_platform ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMPLATFORM . '</span>: ' . $modams_platform  . '</small></td></tr>';
                }
            }else{
                //original
                $contenu = '';
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $_REQUEST['storyid']));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfielddata = $amsfielddata_Handler->getall($criteria);
                foreach (array_keys($amsfielddata) as $j) {
                    $contenu = $amsfielddata[$j]->getVar('data');
                }
                //proposé
                $mod_contenu = '';
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $_REQUEST['mod_id']));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfieldmoddata = $amsfieldmoddata_Handler->getall($criteria);
                foreach (array_keys($amsfieldmoddata) as $j) {
                    $mod_contenu = $amsfieldmoddata[$j]->getVar('moddata');
                }
                echo '<tr><td valign="top" width="40%"><small><span class="' . ($contenu == $mod_contenu ? 'style_ide' : 'style_dif') . '">' . $ams_field[$i]->getVar('title') . '</span>: ' . $mod_contenu  . '</small></td></tr>';
            }
        }
        echo '<tr><td valign="top" width="40%"><small><span class="' . ($ams_logourl == $modams_logourl ? 'style_ide' : 'style_dif') . '">' . _AM_AMS_FORMIMG . '</span>:<br /> <img src="' . $uploadurl_shots . $modams_logourl . '" alt="" title=""></small></td></tr>';
        echo '</table>';
        echo '</table>';
        echo '</td></tr></table>';
        //permet de savoir si le fichier est nouveau
        $new_file = ($ams_url == $modams_url ? false : true);
        echo '<table><tr><td>';
        echo myTextForm('modified.php?op=approve&mod_id=' . $_REQUEST['mod_id'] . '&new_file=' . $new_file , _AM_AMS_FORMAPPROVE);
        echo '</td><td>';
        echo myTextForm('ams.php?op=edit_ams&storyid=' . $_REQUEST['storyid'], _AM_AMS_FORMEDIT);
        echo '</td><td>';
        echo myTextForm('modified.php?op=del_modams&mod_id=' . $_REQUEST['mod_id'] . '&new_file=' . $new_file, _AM_AMS_FORMIGNORE);
        echo '</td></tr></table>';
    break;

    // permet de suprimmer le téléchargment modifié
    case "del_modams":
        $obj =& $amsmod_Handler->get($_REQUEST['mod_id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('ams.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($_REQUEST['new_file']==true){
                $urlfile = substr_replace($obj->getVar('url'),'',0,strlen($uploadurl_ams));
                // permet de donner le chemin du fichier
                $urlfile = $uploaddir_ams . $urlfile;
                // si le fichier est sur le serveur il es détruit
                if (is_file($urlfile)){
                    chmod($urlfile, 0777);
                    unlink($urlfile);
                }
            }
            // supression des data des champs sup
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('storyid', $_REQUEST['mod_id']));
            $ams_fielddata = $amsfieldmoddata_Handler->getall( $criteria );
            foreach (array_keys($ams_fielddata) as $i) {
                $objfielddata =& $amsfieldmoddata_Handler->get($ams_fielddata[$i]->getVar('modiddata'));
                $amsfieldmoddata_Handler->delete($objfielddata) or $objvfielddata->getHtmlErrors();
            }
            if ($amsmod_Handler->delete($obj)) {
                redirect_header('modified.php', 1, _AM_AMS_REDIRECT_DELOK);
            }
            echo $objvotedata->getHtmlErrors();
        } else {
            //Affichage de la partie haute de l'administration de Xoops
            xoops_cp_header();
            if (TDMDownloads_checkModuleAdmin()){
                $modified_admin = new ModuleAdmin();
                $modified_admin->addItemButton(_MI_AMS_ADMENU5, 'modified.php', 'list');
                echo $modified_admin->renderButton();
            }
            xoops_confirm(array('ok' => 1, 'mod_id' => $_REQUEST['mod_id'], 'new_file' => $_REQUEST['new_file'], 'op' => 'del_modams'), $_SERVER['REQUEST_URI'], _AM_AMS_MODIFIED_SURDEL . '<br>');
        }
    break;

    // permet d'accépter la modification
    case "approve":
        // choix du téléchargement:
        $view_modams = $amsmod_Handler->get($_REQUEST['mod_id']);
        $obj =& $ams_Handler->get($view_modams->getVar('storyid'));
        // permet d'effacer le fichier actuel si un nouveau fichier proposé est accepté.
        if ($_REQUEST['new_file']==true){
            $urlfile = substr_replace($obj->getVar('url'),'',0,strlen($uploadurl_ams));
            // permet de donner le chemin du fichier
            $urlfile = $uploaddir_ams . $urlfile;
            // si le fichier est sur le serveur il es détruit
            if (is_file($urlfile)){
                chmod($urlfile, 0777);
                unlink($urlfile);
            }
        }
        // mise à jour:
        $obj->setVar('title', $view_modams->getVar('title'));
        $obj->setVar('url', $view_modams->getVar('url'));
        $obj->setVar('cid', $view_modams->getVar('cid'));
        $obj->setVar('homepage', $view_modams->getVar('homepage'));
        $obj->setVar('version', $view_modams->getVar('version'));
        $obj->setVar('size', $view_modams->getVar('size'));
        $obj->setVar('platform', $view_modams->getVar('platform'));
        $obj->setVar('description', $view_modams->getVar('description'));
        $obj->setVar('logourl', $view_modams->getVar('logourl'));
        $obj->setVar('date', time());
        $obj->setVar('status', 2);
        // Récupération des champs supplémentaires:
        $criteria = new CriteriaCompo();
        $criteria->setSort('weight ASC, title');
        $criteria->setOrder('ASC');
        $ams_field = $amsfield_Handler->getall($criteria);
        foreach (array_keys($ams_field) as $i) {
            $contenu = '';
            $iddata = 0;
            if ($ams_field[$i]->getVar('status_def') == 0){
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $view_modams->getVar('requestid')));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfieldmoddata = $amsfieldmoddata_Handler->getall($criteria);
                foreach (array_keys($amsfieldmoddata) as $j) {
                    $contenu = $amsfieldmoddata[$j]->getVar('moddata');
                }
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('storyid', $view_modams->getVar('storyid')));
                $criteria->add(new Criteria('fid', $ams_field[$i]->getVar('fid')));
                $amsfielddata = $amsfielddata_Handler->getall($criteria);
                foreach (array_keys($amsfielddata) as $j) {
                    $iddata = $amsfielddata[$j]->getVar('iddata');
                }
                if ($iddata == 0){
                    $objdata =& $amsfielddata_Handler->create();
                    $objdata->setVar('fid', $ams_field[$i]->getVar('fid'));
                    $objdata->setVar('storyid', $view_modams->getVar('storyid'));
                }else{
                    $objdata =& $amsfielddata_Handler->get($iddata);
                }
                $objdata->setVar('data', $contenu);
                $amsfielddata_Handler->insert($objdata) or $objdata->getHtmlErrors();
            }
        }
        // supression du rapport de modification
        $objmod =& $amsmod_Handler->get($_REQUEST['mod_id']);
        $amsmod_Handler->delete($objmod);
        // supression des data des champs sup
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('storyid', $_REQUEST['mod_id']));
        $ams_fielddata = $amsfieldmoddata_Handler->getall( $criteria );
        foreach (array_keys($ams_fielddata) as $i) {
            $objfielddata =& $amsfieldmoddata_Handler->get($ams_fielddata[$i]->getVar('modiddata'));
            $amsfieldmoddata_Handler->delete($objfielddata) or $objvfielddata->getHtmlErrors();
        }
        // enregistrement
        if ($ams_Handler->insert($obj)){
            redirect_header('modified.php', 1, _AM_AMS_REDIRECT_SAVE);
        }
        echo $obj->getHtmlErrors();
    break;
}
//Affichage de la partie basse de l'administration de Xoops
include "admin_footer.php";
?>