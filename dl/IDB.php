<?php
/**
 * IDB.php
 * User: sami
 * Date: 23-Mar-15
 * Time: 7:04 PM
 */

namespace dl;


interface IDB {
    public function getRS($query);

    public function execSql($sql);

    public function getStatement($sql);
}