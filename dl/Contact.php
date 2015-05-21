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

    public function getTokenCredits($tokenVal = '')
    {

        $stmt = $this->db->getStatement('
            SELECT
              getCustomerCredits(co.costumerId)
            FROM
              `contacttoken` t
              inner join   contact co on (co.id=t.contactId)
            WHERE
              val=:val
              and (now() between t.`creationDateTime` and t.`expiry`)
              and (0 = t.`cancelled`)
        ');

        if (!($stmt->execute(array(':val' => $tokenVal)))) {
            throw new NotFoundException();
        }

        return $stmt->fetchColumn();
    }

    public function getTokenContactId($tokenVal = '')
    {

        $stmt = $this->db->getStatement('
            SELECT
              contactId
            FROM
              `contacttoken`
            WHERE
              val=:val
              and (now() between `creationDateTime` and `expiry`)
              and (0 = `cancelled`)
            LIMIT 1
        ');

        if (!($stmt->execute(array(':val' => $tokenVal)))) {
            throw new NotFoundException();
        }

        return $stmt->fetchColumn();
    }

    public function getTokenCustomerId($tokenVal = '')
    {

        $stmt = $this->db->getStatement('
            SELECT
              co.costumerId
            FROM
              `contacttoken` t
              inner join contact co on (co.id=t.contactId)
            WHERE
              val=:val
              and (now() between `creationDateTime` and `expiry`)
              and (0 = `cancelled`)
            LIMIT 1
        ');

        if (!($stmt->execute(array(':val' => $tokenVal)))) {
            throw new NotFoundException();
        }

        return $stmt->fetchColumn();
    }

    public function getTokenContact($tokenVal = '')
    {

        $stmt = $this->db->getStatement('
            SELECT
              co.*
            FROM
              `contacttoken` t
              inner join `contact` co on (co.id=t.contactId)
            WHERE
              t.val=:val
              and (now() between t.`creationDateTime` and t.`expiry`)
              and (0 = t.`cancelled`)
            LIMIT 1
        ');

        if (!($stmt->execute(array(':val' => $tokenVal)))) {
            throw new NotFoundException();
        }

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function findByUsername($username)
    {
        $stmt = $this->db->getStatement('select id, pswd from contact where username=:username limit 1;');
        if (!($stmt->execute(array(':username' => $username)))) {
            return -1;
        }
        return $stmt->fetch();
    }

    public function getOwnedFonts($customerId)
    {
        $stmt = $this->db->getStatement('
            SELECT f.id, fg.name as gname, fw.name as wname, count(f.id) as cnt
            FROM customer cu
              JOIN contact co on (co.costumerId = cu.id)
              JOIN sale p on (p.contactId = co.id)
              JOIN sale_font pp on (pp.sale_id = p.id)
              JOIN font f on (f.id = pp.font_id)
              JOIN fontgroup fg on (fg.id = f.fontGroupId)
              JOIN fontweight fw on (fw.id = f.fontWeightId)
            WHERE cu.id = :customerId
            GROUP BY f.id, fg.name, fw.name
            ORDER BY fg.name, fw.name
        ');

        if (!($stmt->execute(array(':customerId' => $customerId)))) {
            throw new NotFoundException();
        }

        $res = array();
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $res []= $row;
        }

        return $res;
    }
}