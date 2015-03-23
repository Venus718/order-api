<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

/** Pswd */
$container
    ->register('pswd', '\utils\Pswd');

/** DB */
$container
    ->register('db', '\dl\DB');


/** Catalog */
$container
    ->register('catalog', '\dl\Catalog')
    ->addArgument(new Reference('db'))
;

/** DL */
$container
    ->register('dl', '\dl\DL')
    ->addArgument(new Reference('catalog'))
;

