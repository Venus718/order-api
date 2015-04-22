<?php
/**
 * LeadController.php
 * User: sami
 * Date: 26-Mar-15
 * Time: 4:02 PM
 */

namespace controller;


use dl\Lead;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class LeadController {

    private $leadDO;

    function __construct(Lead $leadDO)
    {
        $this->leadDO = $leadDO;
    }


    public function createLeadAction(Request $request)
    {
        $reply = array(
            'success' => false,
            'err' => '',
            'data' => array(),
        );

        $data['name'] = $request->request->get('name', null);
        $data['company_name_he'] = $request->request->get('company_name_he', null);
        $data['company_name_en'] = $request->request->get('company_name_en', null);
        $data['phone'] = $request->request->get('phone', null);
        $data['ext'] = $request->request->get('ext', null);
        $data['mobile'] = $request->request->get('mobile', null);
        $data['fax'] = $request->request->get('fax', null);
        $data['mail'] = $request->request->get('mail', null);
        $data['address'] = $request->request->get('address', null);
        $data['remarks'] = $request->request->get('remarks', null);
        $data['otf'] = $request->request->get('otf', 0);
        $data['pc'] = $request->request->get('pc', 0);
        $data['mac'] = $request->request->get('mac', 0);
        $data['fonts'] = $request->request->get('fonts', array());

        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');

        if(false === ($id = $this->leadDO->doCreateLead($data))) {
            $reply['success'] = false;
            $reply['err'] = 'Failed to create lead';
        } else {
            $this->storeLeadIdInSession($id);
            $reply['success'] = true;
            $reply['data']['leadId'] = $id;
            $reply['data']['leadCode'] = $id + Lead::CODE_OFFSET;
            $attachedTo = $this->leadDO->attachLeadToContact($id, $username, $password);
            if(0 < $attachedTo) {
                $reply['data']['attachedTo'] = $attachedTo;
            }
        }

        return $reply;
    }

    public function getLeadAction($id)
    {
        return $this->leadDO->getLead($id);
    }

    private function storeLeadIdInSession($leadId)
    {
        $session = new Session();
        $session->set('lastLeadId', $leadId);
    }

    public function getLastLeadId()
    {
        $session = new Session();
        return $session->get('lastLeadId', 0);
    }

}