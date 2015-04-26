<?php
/**
 * Diablo.php
 * User: sami
 * Date: 20-Apr-15
 * Time: 2:47 PM
 */

namespace fontbit;


use utils\HttpClient;

class Diablo {

    /** @var HttpClient  */
    private $httpClient;

    private $diabloUrl;

    function __construct(HttpClient $httpClient, $diabloUrl)
    {
        $this->httpClient = $httpClient;
        $this->diabloUrl = $diabloUrl;
    }


    public function getToken($username, $password)
    {
        return $this->httpClient->get($this->diabloUrl . 'contact-token/get', array(
            'username' => $username,
            'password' => $password,
        ));
    }

    public function mailFonts($saleId, $mailTo)
    {
        return $this->httpClient->get($this->diabloUrl . 'out/mail-fonts/' . $saleId, array(
            'mailTo' => $mailTo,
        ));
    }

}