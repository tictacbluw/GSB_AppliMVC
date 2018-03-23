<?php
/**
 * Module Ajax : Renvoie la liste des frais hors forfait pour un visiteur sous la forme d'un Json.
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
$LesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
echo (json_encode($LesFraisHorsForfait));

?>