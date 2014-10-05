<?php

class FlavorLoaderTest extends PHPUnit_Framework_TestCase
{
    const CHDIR = "tests/root";

    public function testLoader()
    {
        /* use default flavor dirs */
        $loader = new GenPHP\Flavor\FlavorLoader(array( ROOT_DIR . '/tests/flavors' ));
        ok( $loader );

        $flavor = $loader->load('license');
        ok( $flavor );
        return $flavor;
    }

    public function flavorProvider()
    {
        return array(
            array('license', array('MIT'))
        );
    }


    /**
     * @dataProvider flavorProvider
     */
    public function testFlavors($flavorName, $args)
    {
        $loader = new GenPHP\Flavor\FlavorLoader(array( ROOT_DIR . '/tests/flavors', 'flavors' ));
        ok($loader);

        $flavor = $loader->load($flavorName);
        ok( $flavor );
        ok( $flavor->exists() );
        is( $flavorName, $flavor->getName() );

        $dir = $flavor->getResourceDir();
        path_ok( $dir , 'Found resource directory' );

        $generator = $flavor->getGenerator();
        ok( $generator );

        $pwd = getcwd();
        $this->prepareChdir();
        chdir(self::CHDIR);
        $runner = new \GenPHP\GeneratorRunner;
        $runner->run($generator,$args);
        chdir($pwd);
    }

    public function prepareChdir()
    {
        if ( ! file_exists(self::CHDIR) ) {
            mkdir(self::CHDIR,0755,true);
        }
    }

    /**
     * @depends testLoader
     */
    public function testFlavor($flavor) {
        $generator = $flavor->getGenerator();
        ok( $generator );
        ok( $flavor->exists() );

        is( 'license', $flavor->getName() );
        is( 'license', $flavor->getNamespace() );
        $dir = $flavor->getResourceDir();
        path_ok( $dir );

        $pwd = getcwd();
        $root = "tests/root";
        if ( ! file_exists($root) ) {
            mkdir($root,0755,true);
        }
        chdir($root);
        chdir($pwd);
    }
}

