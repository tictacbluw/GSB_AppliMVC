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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../class.pdogsb.inc.php');
include('../fct.inc.php');
$pdo = PdoGsb::getPdoGsb();
$idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
$mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);

$fraisForfait = $pdo->getLesFraisForfait("a17", "201803");
$fraisHorsForfait = $pdo->getLesFraisHorsForfait("a17", "201804");
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