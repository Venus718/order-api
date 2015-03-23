<?php
/**
 * DL.php
 * Created by PhpStorm.
 * User: sami
 * Date: 4/8/14
 * Time: 3:23 PM
 */

namespace dl;

use PDO;

class DL
{
    private function getPosInt($n, $d = -1)
    {
        $res = intval($n, 10);
        if (!(0 < $n)) {
            $res = $d;
        }

        return $res;
    }

    public function getSubaccountDetails($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT deposit_subaccount_id, deposit_subaccount_username, deposit_subaccount_pswd FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return -1;
    }

    public function setSubaccountDetails($userId, $username, $pswd)
    {
        $userId = $this->getPosInt($userId);
        $sql = "UPDATE `user` set deposit_subaccount_username = :username, deposit_subaccount_pswd = :pswd  WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pswd', $pswd);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function userExist($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT count(dataId) FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return (1 == $stmt->fetchColumn());
        }

        return false;
    }

    public function userHasSubAccount($userId)
    {
        $subaccountId = $this->getSubAccountId($userId);

        return (0 < $subaccountId);
    }

    public function getSubAccountId($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT deposit_subaccount_id FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }

        return -1;
    }

    public function setSubAccountId($userId, $subaccountId)
    {
        $userId = $this->getPosInt($userId);
        $subaccountId = $this->getPosInt($subaccountId);

        $sql = "UPDATE `user` SET deposit_subaccount_id=:subaccountId WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':subaccountId', $subaccountId);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function registerSubscriptionPurchase($userId, $offerId, $paid = 0, $comments = '')
    {
        $userId = $this->getPosInt($userId);
        $offerId = $this->getPosInt($offerId);
        $paid = floatval($paid);
        $comments = (string)$comments;

        $sql = "INSERT INTO `deposit_subscription_purchase`(userId, offerId, paid, comments) VALUES(:userId, :offerId, :paid, :comments);";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':offerId', $offerId);
        $stmt->bindParam(':paid', $paid);
        $stmt->bindParam(':comments', $comments);
        if ($stmt->execute()) {
            return (1 === $stmt->rowCount());
        }

        return false;
    }

    public function getOldPurchaseReply(
        $userId,
        $mediaId,
        $mediaOption,
        $mediaLicense
    )
    {
        $sql = "SELECT deposit_reply, subaccountId FROM `deposit_media_purchase` WHERE userId=:userId AND mediaId=:mediaId AND mediaOption=:mediaOption AND mediaLicense=:mediaLicense;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':mediaId', $mediaId);
        $stmt->bindParam(':mediaOption', $mediaOption);
        $stmt->bindParam(':mediaLicense', $mediaLicense);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function registerMediaPurchase(
        $userId,
        $mediaId,
        $mediaOption,
        $mediaLicense,
        $purchaseCurrency,
        $subaccountId,
        $depositReply,
        $deposit_timestamp
    ) {
        $userId = $this->getPosInt($userId);
        $mediaId = $this->getPosInt($mediaId);
        $mediaOption = (string)$mediaOption;
        $mediaLicense = (string)$mediaLicense;
        $purchaseCurrency = (string)$purchaseCurrency;
        $subaccountId = $this->getPosInt($subaccountId);
        $depositReply = (string)$depositReply;

        $sql = "INSERT INTO `deposit_media_purchase`(userId, mediaId, mediaOption, mediaLicense, purchaseCurrency, subaccountId, deposit_reply, deposit_timestamp) VALUES(:userId, :mediaId, :mediaOption, :mediaLicense, :purchaseCurrency, :subaccountId, :depositReply, :deposit_timestamp);";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':mediaId', $mediaId);
        $stmt->bindParam(':mediaOption', $mediaOption);
        $stmt->bindParam(':mediaLicense', $mediaLicense);
        $stmt->bindParam(':purchaseCurrency', $purchaseCurrency);
        $stmt->bindParam(':subaccountId', $subaccountId);
        $stmt->bindParam(':depositReply', $depositReply);
        $stmt->bindParam(':deposit_timestamp', $deposit_timestamp);

        if ($stmt->execute()) {
            return (1 === $stmt->rowCount());
        }

        return false;
    }

    public function getOffersList()
    {
        $sql = "SELECT *  FROM `subscription_offer` ORDER BY `price` ASC;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return -1;
    }


    /**
     * @param int $s_amount How many images to download per buyPeriod
     * @param int $s_period How many days the subscription is valid for
     * @param int $s_buyPeriod The user can download $s_amount images per buyPeriod days
     * @param string $s_creationDateTime When the subscription was created (deposit formatted: %M.%d, %Y %H:%i:%s)
     * @param string $p_now
     * @param int $p_userId
     * @return int number of available downloads or -1 if there was an error
     */
    public function availableDownloadsInSubscription(
        $s_amount,
        $s_period,
        $s_buyPeriod,
        $s_creationDateTime,
        $p_now,
        $p_userId
    )
    {
        $sql = "SELECT `getDepositSubscriptionAvailableDownloads`(:s_amount, :s_period, :s_buyPeriod, parseDepositDate(:s_creationDateTime), :p_now, :p_userId);";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':s_amount', $s_amount);
        $stmt->bindParam(':s_period', $s_period);
        $stmt->bindParam(':s_buyPeriod', $s_buyPeriod);
        $stmt->bindParam(':s_creationDateTime', $s_creationDateTime);
        $stmt->bindParam(':p_now', $p_now);
        $stmt->bindParam(':p_userId', $p_userId);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }

        return -1;
    }

    public function setNewMethodsFlag($userId, $v)
    {
        $userId = $this->getPosInt($userId);
        $v = intval($v);

        if(($v != 0) && ($v != 1)) {
            throw new \Exception('Bad value given');
        }

        $sql = "UPDATE `user` SET `use_new_methods`=:v WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':v', $v);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getNewMethodsFlag($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT `use_new_methods` FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }

        return -1;
    }

    public function setCredits($userId, $credits)
    {
        $userId = $this->getPosInt($userId);
        $credits = floatval($credits);
        if(!(0 < $credits)) {
            $credits = 0;
        }
        $sql = "call deposit_newcredits_update(:userId, :credits);";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':credits', $credits);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getCredits($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT `deposit_newcredits` FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }

        return -1;
    }

    public function setCreditExpiry($userId, $expiry)
    {
        $userId = $this->getPosInt($userId);
        $expiry = trim($expiry);
        if(1 !== preg_match('/^\d{4}-\d{1,2}-\d{1,2}([tT\s]\d{1,2}:\d{1,2}(:\d{1,2})?)?$/', $expiry)) {
            return false;
        }
        $sql = "UPDATE `user` SET `deposit_newcredits_expiry`=:expiry WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':expiry', $expiry);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getCreditExpiry($userId)
    {
        $userId = $this->getPosInt($userId);
        $sql = "SELECT DATE_FORMAT(`deposit_newcredits_expiry`, '%Y-%m-%d') FROM `user` WHERE dataId=:userId;";
        $db = new DB();
        $stmt = $db->getStatement($sql);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }

        return -1;
    }
}