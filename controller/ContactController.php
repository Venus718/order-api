<?php
/**
 * ContactController.php
 * User: sami
 * Date: 20-Apr-15
 * Time: 12:48 PM
 */

namespace controller;


use dl\Contact;
use dl\DLException;
use dl\NotFoundException;
use fontbit\Diablo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ContactController extends Controller {

    private $contactDO;

    private $diablo;

    function __construct(Contact $contactDO, Diablo $diablo)
    {
        $this->contactDO = $contactDO;
        $this->diablo = $diablo;
    }

    public function getCreditsFromTokenAction(Request $request)
    {
        $tokenVal = $request->request->get('token', $request->query->get('token', ''));

        $reply = $this->initReply();

        try {
            $credits = $this->contactDO->getTokenCredits($tokenVal);

            if (false === $credits) {
                $reply['success'] = false;
                $reply['err'] = 'No token found';
            } else {
                $reply['success'] = true;
                $reply['data']['credits'] = $credits;
            }

        } catch ( NotFoundException $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Did not find valid token matching request';

        } catch ( DLException $e ) {
            $reply['success'] = false;
            $reply['err'] = 'DL exception';
        } catch ( \Exception $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Exception thrown';
            $reply['data']['msg'] = $e->getMessage();
        }

        return $reply;
    }

    public function getTokenAction(Request $request)
    {
        $username = $request->query->get('username', '');
        $password = $request->query->get('password', '');


        $diabloReply = $this->initReply();

        try {
            $diabloReply = json_decode($this->diablo->getToken($username, $password));
        } catch ( \Exception $e ) {
            $diabloReply['success'] = false;
            $diabloReply['err'] = 'Weird reply from diablo';
        }

        return $diabloReply;
    }

    public function getOwnedFontsAction(Request $request)
    {
        $tokenVal = $request->request->get('token', $request->query->get('token', ''));

        $reply = $this->initReply();

        try {
            $customerId = $this->contactDO->getTokenCustomerId($tokenVal);
            $fonts = $this->contactDO->getOwnedFonts($customerId);

            $reply['success'] = true;
            $reply['data']['fonts'] = $fonts;

        } catch ( NotFoundException $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Did not find valid token matching request';

        } catch ( DLException $e ) {
            $reply['success'] = false;
            $reply['err'] = 'DL exception';
        } catch ( \Exception $e ) {
            $reply['success'] = false;
            $reply['err'] = 'Exception thrown';
            $reply['data']['msg'] = $e->getMessage();
        }

        return $reply;
    }


}