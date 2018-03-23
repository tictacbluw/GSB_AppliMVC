<?php
 /** 
 * Module Ajax : Valide une fiche de frais.
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
$idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
$mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);
$etp = filter_input(INPUT_POST, 'etp', FILTER_SANITIZE_STRING);
$km = filter_input(INPUT_POST, 'km', FILTER_SANITIZE_STRING);
$nui = filter_input(INPUT_POST, 'nui', FILTER_SANITIZE_STRING);
$rep = filter_input(INPUT_POST, 'rep', FILTER_SANITIZE_STRING);
$lignesHorsForfait = $_POST['lignesHorsForfait'];
$lesFrais = $pdo->getLesFrais();
$montantValide = 0.00; 

foreach ($lignesHorsForfait[0] as $libelle => $montant) {
   if(substr( $libelle, 0, 5 ) != "REFUSE"){
    $montantValide += floatval($montant);
   }


}

$montantValide += $lesFrais[0]['montant']*$etp;
$montantValide += $lesFrais[1]['montant']*$km;
$montantValide += $lesFrais[2]['montant']*$nui;
$montantValide += $lesFrais[3]['montant']*$rep;


$etat = "VA";
$pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);
$pdo->majMontantValide($idVisiteur, $mois, $montantValide);


?>