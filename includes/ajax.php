<?php
/**
 * Page d'appel pour module Ajax
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

include('class.pdogsb.inc.php');
include('fct.inc.php');
$pdo = PdoGsb::getPdoGsb();
session_start();

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if(isset($action)){

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $token ===$_SESSION['token']) {

    include("ajax.modules/".$action.".php");

}

}


?>