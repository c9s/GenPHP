<?php
require 'PHPUnit/TestMore.php';
require 'vendor/pear/Universal/ClassLoader/BasePathClassLoader.php';
define('ROOT_DIR' , dirname(__DIR__) );
$loader = new \Universal\ClassLoader\BasePathClassLoader( array( 
    ROOT_DIR . '/src', 
    ROOT_DIR . '/vendor/pear'
));
$loader->register();
