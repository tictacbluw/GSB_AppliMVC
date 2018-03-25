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

$fraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
$fraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFrais = $pdo->getLesFrais();
$montantValide = 0.00; 


$etpQty = floatval($fraisForfait[0]["quantite"]);
$kmQty = floatval($fraisForfait[1]["quantite"]);
$nuiQty =  floatval($fraisForfait[2]["quantite"]);
$repQty = floatval($fraisForfait[3]["quantite"]);




$montantValide += $lesFrais[0]['montant']*$etpQty;
$montantValide += $lesFrais[1]['montant']*$kmQty;
$montantValide += $lesFrais[2]['montant']*$nuiQty;
$montantValide += $lesFrais[3]['montant']*$repQty;



foreach ($fraisHorsForfait as $ligneHorsForfait) {

    if(substr( $ligneHorsForfait["libelle"], 0, 6 ) != "REFUSE"){
     $montantValide +=floatval($ligneHorsForfait["montant"]);
    }

}



$etat = "VA";
$pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);
$pdo->majMontantValide($idVisiteur, $mois, $montantValide);


?>