<?php
/**
 * Module Ajax : Renvoie la ligne de hors forfait au mois suivant qui correspond à l'id fournis
 * 
 * PHP Version 7
 *
 * @category  PPE
 * @package   AJAX
 * @author    Thibaut PHILIPPS <th.philipps@laposte.net>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 *
 * 
 */
$idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
$tmpdate = str_split($mois, 4);
$tmpdate[1] += 1;
if($tmpdate[1] < 10){
    $tmpdate[1] = "0".$tmpdate[1];
}
$mois = $tmpdate[0].$tmpdate[1];  

if($pdo->estPremierFraisMois($idVisiteur, $mois) == true){
    $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        
}
$ligneHorsForfaitARenvoyer = $pdo->getLesFraisHorsForfaitParId($id);
$pdo->supprimerFraisHorsForfait($id);
$libelle = $ligneHorsForfaitARenvoyer[0]["libelle"];
$date = $ligneHorsForfaitARenvoyer[0]["date"];
$montant = $ligneHorsForfaitARenvoyer[0]["montant"];
$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant);


?>