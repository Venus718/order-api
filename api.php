<?php
/**
 * api.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 11:00 AM
 */

require __DIR__ . '/header.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();

$routes = include __DIR__.'/api_routing.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

/** @var \dl\DL $dl */
$dl = $container->get('dl');

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);

    switch($_route) {
        case 'fontsCatalog':
            $response = new JsonResponse($dl->getCatalog()->getFontsCatalog(), 200);
            break;
        case 'formatsCatalog':
            $response = new JsonResponse($dl->getCatalog()->getFormatsCatalog(), 200);
            break;
        default:
            $response = new JsonResponse('fuck', 200);
    }

} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new JsonResponse('Not Found', 404);
} catch (Exception $e) {
    $response = new JsonResponse('An error occurred', 500);
}

$response->send();
