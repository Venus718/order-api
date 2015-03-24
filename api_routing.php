<?php
/**
 * api_routing.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 11:13 AM
 */

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();


$routes->add('fontsCatalog', new Routing\Route(
    '/fonts-catalog',
    array()
));

$routes->add('formatsCatalog', new Routing\Route(
    '/formats-catalog',
    array()
));


return $routes;