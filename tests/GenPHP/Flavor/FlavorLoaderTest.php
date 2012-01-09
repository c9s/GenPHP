<?php

namespace GenPHP\Flavor;
use PHPUnit_Framework_TestCase;
use Exception;

class FlavorLoaderTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        /* use default flavor dirs */
        $loader = new FlavorLoader();
        ok( $loader );

        $flavor = $loader->load('licenses');
        ok( $flavor );

        $generator = $flavor->getGenerator();
        ok( $generator );
    }
}

