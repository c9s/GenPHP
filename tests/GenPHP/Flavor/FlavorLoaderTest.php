<?php

class FlavorLoaderTest extends PHPUnit_Framework_TestCase
{
    function testLoader()
    {
        /* use default flavor dirs */
        $loader = new GenPHP\Flavor\FlavorLoader(array( ROOT_DIR . '/tests/flavors' ));
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
        $dir = $flavor->getResourceDir();
        ok( file_exists($dir) );

        $pwd = getcwd();
        $root = "tests/root";
        if( ! file_exists($root) )
            mkdir($root,0755,true);
        chdir($root);

        $runner = new \GenPHP\GeneratorRunner;
        $runner->run($generator,array('MIT'));

        chdir($pwd);
    }
}

