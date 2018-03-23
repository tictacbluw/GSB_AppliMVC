<?php
/**
 * Module Ajax : Refuse la ligne hors forfait correspondant à l'id fournis
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
$idFrais = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$pdo->refuserFraisHorsForfait($idFrais);


?>