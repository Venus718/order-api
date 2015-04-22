<?php
/**
 * Controller.php
 * User: sami
 * Date: 22-Apr-15
 * Time: 2:20 PM
 */

namespace controller;


class Controller {

    /**
     * @return array
     */
    protected function initReply()
    {
        $reply = array(
            'success' => false,
            'err' => '',
            'data' => array(),
        );

        return $reply;
    }
}