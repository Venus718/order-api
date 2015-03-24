<?php
/**
 * api_routing.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 11:13 AM
 */

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();


$routes->add('catalog_fonts', new Routing\Route(
    '/catalog-fonts',
    array()
));

$routes->add('catalog_formats', new Routing\Route(
    '/catalog-formats',
    array()
));

$routes->add('lead_create', new Routing\Route(
    '/lead/create',
    array()
));


return $routes;