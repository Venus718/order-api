<?php
/**
 * DLO.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 12:05 PM
 */

namespace dl;


class DLO {
    /** @var  IDB */
    protected $db;

    function __construct(IDB $db)
    {
        $this->db = $db;
    }
}