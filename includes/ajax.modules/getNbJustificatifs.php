<?php
/**
 * Module Ajax : Renvoie le nombre de justificatif pour une fiche de frais d'un visiteur et d'un mois donné sous la forme d'un Json.
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
$LesNbJustificatifs = $pdo->getNbJustificatifs($idVisiteur,$mois);
echo (json_encode($LesNbJustificatifs));

?>