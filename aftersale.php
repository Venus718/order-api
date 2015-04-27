<?php
/**
 * aftersale.php
 * User: sami
 * Date: 27-Apr-15
 * Time: 10:19 AM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
// set and get session attributes
$visited = $session->get('visited_terms', 'no');

if('yes' !== $visited) {
    $response = new RedirectResponse('terms.php');
    $response->send();
}

/** @var \controller\SaleController $saleController */
$saleController = $container->get('controller.sale');
$theSale = $saleController->getSaleAction($saleController->getLastSaleId());

echo($theSale['fonts'][0]['name']);
echo('<br/>');

dump($theSale);

?>

aftersale.php