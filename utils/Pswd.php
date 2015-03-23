<?php
/**
 * Pswd.php
 * User: sami
 * Date: 23-Mar-15
 * Time: 4:26 PM
 */

namespace utils;


class Pswd {
    public function hash($pswd)
    {
        return password_hash($pswd, PASSWORD_BCRYPT);
    }

    public function match($pswd, $hash)
    {
        return password_verify($pswd, $hash);
    }
}