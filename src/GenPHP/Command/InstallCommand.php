<?php
namespace GenPHP\Command;
use GenPHP\Flavor\Flavor;
use GenPHP\Flavor\FlavorLoader;
use GenPHP\Path;
use GenPHP\Operation\Helper;

class InstallCommand extends \CLIFramework\Command 
{
    public $installed = array();


    function brief() { 
        return 'install flavor to your global flavor path';
    }

    function options($opts)
    {
        $opts->add('f|force','force install');
    }

    function installFlavor($flavor)
    {
        if( isset( $this->installed[ $flavor->getName() ] ) )
            return;

        $logger = $this->getLogger();
        $homePath = Path::get_home_flavor_path();

        Helper::mktree( $homePath );

        $logger->info( "Installing " . $flavor->getName() . "..." );
        Helper::copy_dir(
            $flavor->__toString(),
            $homePath . DIRECTORY_SEPARATOR . $flavor->getName(), 
            function($target) use ($logger) {
                $logger->info( "Installing " . $target,1);
        });

        // get dependencies
        $generator = $flavor->getGenerator();
        $depGenerators = $generator->getDependencies();
        foreach( $depGenerators as $depGenerator ) {
            $this->installFlavor( $depGenerator->getFlavor());
        }
    }

    // xxx: should also install dependency flavors
    function execute($nameOrPath)
    {
        if( file_exists($nameOrPath) ) {
            $flavor = new Flavor($nameOrPath);
            $this->installFlavor( $flavor );
        }
        else {
            $loader = new FlavorLoader;
            $flavor = $loader->load( $nameOrPath );
            $this->installFlavor( $flavor );
        }
        $this->getLogger()->info("Done");
    }
}
