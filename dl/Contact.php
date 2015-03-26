<?php
/**
 * Contact.php
 * User: sami
 * Date: 26-Mar-15
 * Time: 11:01 AM
 */

namespace dl;


use utils\Pswd;

class Contact extends DLO {

    protected $pswd;

    function __construct(IDB $db, Pswd $pswd)
    {
        parent::__construct($db);
        $this->pswd = $pswd;
    }

    public function getContactId($username, $password)
    {
        $username = (string)$username;
        $password = (string)$password;

        if((0 == mb_strlen($username)) || (0 == mb_strlen($password))) {
            return -1;
        }

        $rs = $this->findByUsername($username);
        if(-1 === $rs) {
            return -2;
        }

        if($this->pswd->match($password, $rs['pswd'])) {
            return $rs['id'];
        }

        return -3;
    }

    private function findByUsername($username)
    {
        $stmt = $this->db->getStatement('select id, pswd from contact where username=:username limit 1;');
        if (!($stmt->execute(array(':username' => $username)))) {
            return -1;
        }
        return $stmt->fetch();
    }
}