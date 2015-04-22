<?php
/**
 * api.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 11:00 AM
 */

require __DIR__ . '/header.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/api_routing.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);


try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);

    switch($_route) {
        case 'catalog_fonts':
            $response = new JsonResponse($container->get('catalog')->getFontsCatalog(), 200);
            break;
        case 'catalog_formats':
            $response = new JsonResponse($container->get('catalog')->getFormatsCatalog(), 200);
            break;
        case 'lead_create':
            $response = new JsonResponse($container->get('controller.lead')->createLeadAction($request), 200);
            break;
        case 'sale_create':
            $response = new JsonResponse($container->get('controller.sale')->createSaleAction($request), 200);
            break;
        case 'token_credits':
            $response = new JsonResponse($container->get('controller.contact')->getCreditsFromTokenAction($request), 200);
            break;
        case 'token_get':
            $response = new JsonResponse($container->get('controller.contact')->getTokenAction($request), 200);
            break;
        default:
            $response = new JsonResponse('fuck', 500);
    }

} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new JsonResponse('Not Found', 404);
} catch (Exception $e) {
    $response = new JsonResponse('An error occurred', 500);
}

$response->send();
