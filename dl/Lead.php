<?php
/**
 * Lead.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 12:05 PM
 */

namespace dl;


use Symfony\Component\HttpFoundation\Request;

class Lead extends DLO {

    public function createLead(Request $request)
    {
        $reply = array(
            'success' => false,
            'err' => '',
            'data' => array(),
        );

        return $reply;
    }

}