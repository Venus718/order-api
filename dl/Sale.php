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
}