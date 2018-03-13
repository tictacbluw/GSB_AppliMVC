<?php
/**
 * Test unitaire Gestion de la connexion
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
require_once("/var/www/html/vendor/autoload.php");
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class PdoGsbTest extends PHPUnit_Extensions_Database_TestCase
{
	
	use TestCaseTrait;

	protected function getSetUpOperation() {
        return PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT(TRUE);
	}
	
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;


    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais','userGsb', 'secret');
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'gsb_frais');
        }

        return $this->conn;
    }
    
        public function getDataSet()
    {
        return $this->createMySQLXMLDataSet('/var/www/html/gsb_frais.xml');
    }


    
     public function testgetInfosUtilisateur()
    {
    
    	$this->assertEquals(10, $this->getConnection()->getRowCount('utilisateur'));
    }
    
}

?>