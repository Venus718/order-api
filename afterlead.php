<?php
/**
 * afterlead.php
 * User: sami
 * Date: 26-Mar-15
 * Time: 9:28 PM
 */
require __DIR__ . '/header.php';

/** @var \controller\LeadController $leadController */
$leadController = $container->get('controller.lead');
$theLead = $leadController->getLeadAction($leadController->getLastLeadId());
dump($theLead);