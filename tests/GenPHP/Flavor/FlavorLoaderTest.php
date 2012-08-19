<?php

namespace GenPHP\Flavor;
use PHPUnit_Framework_TestCase;
use Exception;

class FlavorLoaderTest extends PHPUnit_Framework_TestCase
{
    function testLoader()
    {
        /* use default flavor dirs */
        $loader = new FlavorLoader(array( 'tests/flavors' ));
        ok( $loader );

        $flavor = $loader->load('license');
        ok( $flavor );


        return $flavor;
    }

    /**
     * @depends testLoader
     */
    function testFlavor($flavor) {
        $generator = $flavor->getGenerator();
        ok( $generator );
        ok( $flavor->exists() );

        is( 'license', $flavor->getName() );
        is( 'license', $flavor->getNamespace() );
        is( 'tests/flavors/license/Resource', $flavor->getResourceDir() );
    }
}

