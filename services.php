<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

require('consts.php');

$container = new ContainerBuilder();

/** Pswd */
$container
    ->register('pswd', '\utils\Pswd');

/** DB */
$container
    ->register('db', '\dl\DB')
    ->addArgument(DB_HOST)
    ->addArgument(DB_NAME)
    ->addArgument(DB_USER)
    ->addArgument(DB_PSWD)
;


/** Catalog */
$container
    ->register('catalog', '\dl\Catalog')
    ->addArgument(new Reference('db'))
;

/** Lead */
$container
    ->register('lead', '\dl\Lead')
    ->addArgument(new Reference('db'))
;


