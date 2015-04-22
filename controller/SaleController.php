<?php
/**
 * SaleController.php
 * User: sami
 * Date: 22-Apr-15
 * Time: 2:15 PM
 */

namespace controller;

use dl\Sale;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SaleController extends Controller {
    private $saleDO;

    function __construct(Sale $saleDO)
    {
        $this->saleDO = $saleDO;
    }


    public function createSaleAction(Request $request)
    {

    }
}