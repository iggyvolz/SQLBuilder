<?php
require 'PHPUnit/TestMore.php';
require 'Universal/ClassLoader/BasePathClassLoader.php';
require 'tests/DriverFactory.php';
require 'tests/PHPUnit/PDO/TestCase.php';
$loader = new \Universal\ClassLoader\BasePathClassLoader(array('src','vendor/pear'));
$loader->useIncludePath(false);
$loader->register(true); // use prepend
