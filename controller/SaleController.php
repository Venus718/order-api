<?php
/**
 * SaleController.php
 * User: sami
 * Date: 22-Apr-15
 * Time: 2:15 PM
 */

namespace controller;

use dl\Contact;
use dl\NotFoundException;
use dl\Sale;
use fontbit\Diablo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SaleController extends Controller {
    private $saleDO;
    private $contactDO;
    private $diablo;

    function __construct(Sale $saleDO, Contact $contactDO, Diablo $diablo)
    {
        $this->saleDO = $saleDO;
        $this->contactDO = $contactDO;
        $this->diablo = $diablo;
    }


    public function createSaleAction(Request $request)
    {
        $reply = $this->initReply();

        $token = $request->request->get('token', '');
        $credits = intval($this->contactDO->getTokenCredits($token));
        $selectedFontsCount = count($request->request->get('fonts', array()));
        $mailTo = $request->request->get('mailTo', '');

        if(!(0 < $selectedFontsCount)) {
            $reply['success'] = false;
            $reply['err'] = 'No fonts were selected';
            return $reply;
        }

        if($credits < $selectedFontsCount) {
            $reply['success'] = false;
            $reply['err'] = 'Not enough credits';
            return $reply;
        }

        if(!filter_var($mailTo, FILTER_VALIDATE_EMAIL)) {
            $reply['success'] = false;
            $reply['err'] = 'invalid mail';
            return $reply;
        }

        $contact = null;
        try {
            $contact = $this->contactDO->getTokenContact($token);
            if(!$contact) {
                $reply['success'] = false;
                $reply['err'] = 'Failed to get contact from token';
                return $reply;
            }

        } catch ( NotFoundException $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Invalid token';
            return $reply;

        } catch ( \Exception $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Exception';
            $reply['data']['msg'] = $e->getMessage();
            return $reply;
        }

        $contactId = intval($contact['id']);
        $customerId = intval($contact['costumerId']);

        // we now know that the contact is logged in and has enough credits

        $saleId = $this->createSale($request, $contactId, $customerId);
        if(false === $saleId) {
            $reply['success'] = false;
            $reply['err'] = 'Failed to create sale';
            return $reply;
        }

        if(!$this->sendFontsByMail($saleId, $mailTo)) {
            $reply['success'] = false;
            $reply['err'] = 'Failed to send files';
            return $reply;
        }

        $reply['success'] = true;
        return $reply;
    }

    private function createSale(Request $request, $contactId, $customerId)
    {
        $saleData = array();
        $saleData['remarks'] = $request->request->get('remarks', '');
        $saleData['otf'] = $request->request->get('otf', 0);
        $saleData['pc'] = $request->request->get('pc', 0);
        $saleData['mac'] = $request->request->get('mac', 0);
        $saleData['fonts'] = $request->request->get('fonts', array());

        $lastCustomerSale = $this->saleDO->getLastSale($customerId);
        if(false === $lastCustomerSale) {
            return false;
        }
        $saleData['weight_number'] = $lastCustomerSale['weight_number'];
        $saleData['sum'] = $lastCustomerSale['sum'];
        $saleData['dealId'] = $lastCustomerSale['dealId'];

        return $this->saleDO->createSale($saleData, $contactId);
    }

    private function sendFontsByMail($saleId, $mailTo)
    {
        $this->diablo->mailFonts($saleId, $mailTo);
        return true;
    }
}