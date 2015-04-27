<?php
/**
 * terms.php
 * User: sami
 * Date: 27-Apr-15
 * Time: 9:50 AM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();

// set and get session attributes
$session->set('visited_terms', 'yes');

?>

<h1>terms!</h1>
<h2>and cake!!!!!1!</h2>
<br/>
<marquee width="250" behavior="alternate">click <a href="orderform.php">order</a> to order an order</marquee><br/>
<a href="orderform.php">order</a>