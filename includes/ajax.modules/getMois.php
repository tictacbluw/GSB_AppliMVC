<?php
/**
 * Module Ajax : Renvoie la liste des mois pour lequel le visiteur à une fiche de frais sous la forme d'un Json.
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
$moisDisponnibles = $pdo->getLesMoisDisponibles($idVisiteur);
echo (json_encode($moisDisponnibles));


?>