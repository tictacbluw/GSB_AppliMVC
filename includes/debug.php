<?php
/**
 * Mini debugger pour developpement
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Thibaut PHILIPPS <th.philipps@laposte.net>   
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$debug = false;

if ($debug == true) {

    echo '<pre>$_SESSION: <br>';
    var_dump($_SESSION);
    echo '</pre>';


    echo '<pre>$_REQUEST: <br>';
    var_dump($_REQUEST);
    echo '</pre>';

	
}

?>