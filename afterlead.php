<?php
/**
 * afterlead.php
 * User: sami
 * Date: 26-Mar-15
 * Time: 9:28 PM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
$visited = $session->get('visited_terms', 'no');

if('yes' !== $visited) {
    $response = new RedirectResponse('terms.php');
    $response->send();
}

/** @var \controller\LeadController $leadController */
$leadController = $container->get('controller.lead');
$theLead = $leadController->getLeadAction($leadController->getLastLeadId());
dump($theLead);
?>
afterlead.php