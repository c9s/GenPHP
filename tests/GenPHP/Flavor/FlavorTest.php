<?php

namespace GenPHP\Flavor;
use PHPUnit_Framework_TestCase;
use Exception;

class FlavorTest extends PHPUnit_Framework_TestCase
{
    public function testFunc()
    {
        $fl = new Flavor( 'flavors/command' );
        ok( $fl->getResourceDir() );
        ok( $fl->hasResourceDir() );
        ok( $fl->hasGeneratorClassFile() );
        ok( $fl->getGeneratorClassFile() );
        ok( $fl->exists() );
        is( 'command', $fl->getName());
        is('command\Generator', $fl->getGeneratorClass() );

        ok( $fl->createGenericGenerator() );
    }
}


