<?php

namespace GenPHP\Flavor;
use PHPUnit_Framework_TestCase;
use Exception;

class FlavorLoaderTest extends PHPUnit_Framework_TestCase
{
    function testLoader()
    {
        /* use default flavor dirs */
        $loader = new FlavorLoader();
        ok( $loader );

        $flavor = $loader->load('license');
        ok( $flavor );

        $generator = $flavor->getGenerator();
        ok( $generator );
    }
}

