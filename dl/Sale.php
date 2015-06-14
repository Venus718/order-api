<?php
/**
 * Sale.php
 * User: sami
 * Date: 22-Apr-15
 * Time: 2:17 PM
 */

namespace dl;


class Sale extends DLO {

    const SHIR = 76;
    const FORMAT = 12;

    public function createSale($saleData, $contactId)
    {
        $sql = "
          INSERT INTO `sale`
            (
            `creationDateTime`,
            `type`,
            `initiated`,
            `description`,
            `discountType`,
            `discountValue`,
            `weight_number`,
            `shimush_number`,
            `purchase_report_number`,
            `sum`,
            `pcs`,
            `macs`,
            `others`,
            `paymentMethod`,
            `proposal`,
            `fontkit_id`,
            `contactId`,
            `userId`,
            `ownerId`,
            `interactionId`,
            `dealId`,
            `expirationDateTime`,
            `modificationDateTime`)
            VALUES
            (
            now(),
            2,
            0,
            :description,
            0,
            0,
            :weight_number,
            null,
            null,
            :sum,
            0,
            0,
            0,
            null,
            0,
            null,
            :contactId,
            :userId,
            :userId,
            null,
            :dealId,
            ADDDATE(now(), INTERVAL 5 YEAR),
            now()
            );
        ";
        list($stmt, $db) = $this->db->getStatementAndDb($sql);

        $autoSaleDescription = "השלמה אוטומטית\n" . "הערות לקוח: " . $saleData['remarks'];
        $autoSaleUser = intval(self::SHIR);

        $stmt->bindParam(':description', $autoSaleDescription);
        $stmt->bindParam(':weight_number', $saleData['weight_number']);
        $stmt->bindParam(':sum', $saleData['sum']);
        $stmt->bindParam(':contactId', $contactId);
        $stmt->bindParam(':userId', $autoSaleUser);
        $stmt->bindParam(':dealId', $saleData['dealId']);

        if($stmt->execute()) {
            $id = $db->lastInsertId();
            $this->setSaleFonts($id, $saleData['fonts']);
            $this->setSaleFormats($id);
            return $id;
        }
        return false;
    }

    public function getLastSale($customerId)
    {
        $stmt = $this->db->getStatement('
            select
              s.*
            from
                sale s
                inner join contact co on (co.id = s.contactId and co.costumerId=:customerId)
            order by
                s.id desc
            limit 1
        ');
        if(!$stmt->execute(array(':customerId' => $customerId))) {
            throw new NotFoundException();
        }
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function setSaleFonts($saleId, $fonts = array())
    {
        if(!is_array($fonts) || 0 == count($fonts) || !(0 < $saleId)) {
            return false;
        }

        $sql = 'INSERT INTO sale_font (sale_id, font_id) VALUES ';
        $values = array();
        for($i = 0, $len = count($fonts); $i < $len; $i++) {
            $fontId = intval($fonts[$i], 10);
            if(0 < $fontId) {
                $values []= '('.$saleId.', '.$fontId.')';
            }
        }
        if(!(0 < count($values))) {
            return false;
        }
        return $this->db->execSql($sql . implode(',', $values));
    }

    public function setSaleFormats($saleId)
    {
        $saleId = intval($saleId, 10);
        if(!(0 < $saleId)) {
            return false;
        }

        return $this->db->execSql('INSERT INTO `sale_fontformat`(`sale_id`, `fontformat_id`) VALUES('.$saleId.', '.self::FORMAT.');');
    }

    public function getSale($saleId)
    {
        $saleId = intval($saleId, 10);
        if(!(0 < $saleId)) {
            return -1;
        }

        $stmt = $this->db->getStatement("select * from sale where id=:id");
        if(!$stmt->execute(array(':id' => $saleId))) {
            return -2;
        }
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        $res['fonts'] = array();
        $res['formats'] = array();
        $fontsStmt = $this->db->getStatement("
            select
                f.id id, fg.name `group`, fw.name `weight`, concat(fg.name, ' ', fw.name) `name`
            from
                sale_font l
                inner join font f on(l.sale_id=:sale_id and l.font_id = f.id)
                inner join fontgroup fg on (f.fontGroupId = fg.id)
                inner join fontweight fw on (f.fontWeightId = fw.id)
            order by
                fg.name, fw.ord, fw.name
        ");
        if($fontsStmt->execute(array(':sale_id' => $saleId))) {
            while($row = $fontsStmt->fetch(\PDO::FETCH_ASSOC)) {
                $res['fonts'] []= $row;
            }
        }
        $formatsStmt = $this->db->getStatement("
            select
                f.id id, f.name `name`
            from
                sale_fontformat l
                inner join fontformat f on(l.sale_id=:sale_id and l.fontformat_id = f.id)
            order by
                f.name
        ");
        if($formatsStmt->execute(array(':sale_id' => $saleId))) {
            while($row = $formatsStmt->fetch(\PDO::FETCH_ASSOC)) {
                $res['formats'] []= $row;
            }
        }
        return $res;
    }
}