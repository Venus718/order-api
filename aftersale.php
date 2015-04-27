<?php
/**
 * aftersale.php
 * User: sami
 * Date: 27-Apr-15
 * Time: 10:19 AM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
// set and get session attributes
$visited = $session->get('visited_terms', 'no');

if('yes' !== $visited) {
    $response = new RedirectResponse('terms.php');
    $response->send();
}

?>

aftersale.php