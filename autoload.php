<?php
/**
 * autoload.php
 * Created by PhpStorm.
 * User: sami
 * Date: 4/8/14
 * Time: 2:08 PM
 */

require_once __DIR__ . "/vendor/autoload.php";
use Symfony\Component\ClassLoader\ClassLoader;

$loader = new ClassLoader();
$loader->register();

// to enable searching the include path (e.g. for PEAR packages)
$loader->setUseIncludePath(true);