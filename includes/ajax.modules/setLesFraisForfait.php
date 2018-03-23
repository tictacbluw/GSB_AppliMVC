<?php
/**
 *Module Ajax : Met à jour la ligne Frais forfait de la fiche de frais pour un visiteur et un mois donnés en paramètres
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
$mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
$etp = filter_input(INPUT_GET, 'ETP', FILTER_SANITIZE_STRING);
$km = filter_input(INPUT_GET, 'KM', FILTER_SANITIZE_STRING);
$nui = filter_input(INPUT_GET, 'NUI', FILTER_SANITIZE_STRING);
$rep = filter_input(INPUT_GET, 'REP', FILTER_SANITIZE_STRING);
$lesFrais = array(
    "ETP" => $etp,
    "KM" => $km,
    "NUI" => $nui,
    "REP" => $rep
    );
$pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);

?>