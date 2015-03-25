<?php
/**
 * DB.php
 * Created by PhpStorm.
 * User: sami
 * Date: 4/8/14
 * Time: 3:26 PM
 */

namespace dl;

use PDO;

class DB implements IDB
{
    /*private $db_host = "81.218.173.203";
    private $db_name = "fontbit_import";
    private $db_user = "fontbit_order";
    private $db_pswd = "qazwsx12";*/

    /*private $db_host = "127.0.0.1";
    private $db_name = "fontbit_import";
    private $db_user = "fontbit_import";
    private $db_pswd = "123";*/

    function __construct($db_host, $db_name, $db_user, $db_pswd)
    {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pswd = $db_pswd;
    }


    private function getDB()
    {
        $db = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name . ';charset=utf8', $this->db_user, $this->db_pswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $db;
    }

    public function getRS($query)
    {
        $db = $this->getDB();
        $stmt = $db->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execSql($sql)
    {
        $db = $this->getDB();
        $db->exec($sql);
    }

    public function getStatement($sql)
    {
        $db = $this->getDB();
        return $db->prepare($sql);
    }

    public function getStatementAndDb($sql)
    {
        $db = $this->getDB();
        return array($db->prepare($sql), $db);
    }
} 