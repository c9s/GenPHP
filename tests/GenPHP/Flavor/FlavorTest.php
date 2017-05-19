<?php

namespace GenPHP\Flavor;
use PHPUnit\Framework\TestCase;
use Exception;

class FlavorTest extends \PHPUnit\Framework\TestCase
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


