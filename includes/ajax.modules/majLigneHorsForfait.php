<?php
/**
 * Module Ajax : Met à jour la ligne hors forfait correspondant à l'id fournis
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

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$date = dateFrancaisVersAnglais(filter_input(INPUT_GET, 'date', FILTER_SANITIZE_URL));
$montant = floatval(filter_input(INPUT_GET, 'montant', FILTER_SANITIZE_STRING));
$libelle = filter_input(INPUT_GET, 'libelle', FILTER_SANITIZE_STRING);
$pdo->majFraisHorsForfait($id, $date, $libelle, $montant);
?>