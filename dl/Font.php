<?php
/**
 * Font.php
 * User: sami
 * Date: 29-Mar-15
 * Time: 9:54 AM
 */

namespace dl;


class Font extends DLO {
    private $_data = array();

    function __construct(IDB $db, $_data)
    {
        parent::__construct($db);
        $this->_data = $_data;
    }


    public function load($id)
    {

    }
}