<?php
/**
 * Test unitaire des fonctions fct.inc.php
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Thibaut PHILIPPS
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */


use PHPUnit\Framework\TestCase;

require_once(__DIR__ ."/../../includes/fct.inc.php");

final class fctTest extends TestCase
{
   public function testEstConnecte() {
    $this->assertEquals(
        false,
        estconnecte()
    );
   }



public function testDateFrancaisVersAnglais(){

    $this->assertEquals(
        '2018-08-05',
        dateFrancaisVersAnglais('05/08/2018')
    );


}

public function testDateAnglaisVersFrancais(){

    $this->assertEquals(
        '05/09/1914',
        dateAnglaisVersFrancais('1914-09-05')
    );


}

public function testGetMois(){

    $this->assertEquals(
        '201803',
        getMois('17/03/2018')
    );


}


public function testEstEntierPositif(){

    $this->assertEquals(
        true,
        estEntierPositif(rand(0,9999999))
    );

}


}

