<?php
namespace GenPHP\Command;
use GenPHP\Flavor\FlavorDirectory;
use GenPHP\Path;
use GenPHP\Operation\Helper;

class InstallCommand extends \CLIFramework\Command 
{
    function brief() { 
        return 'install flavor to your global flavor path';
    }

    function options($opts)
    {
        $opts->add('f|force','force install');
    }

    function execute($nameOrPath)
    {
        $logger = $this->getLogger();
        $homePath = Path::get_home_flavor_path();
        if( file_exists($nameOrPath) ) {
            Helper::mktree( $homePath );

            $flavor = new FlavorDirectory($nameOrPath);
            $logger->info( "Installing " . $flavor->getName() . "..." );
            Helper::copy_dir(
                $flavor->__toString(),
                $homePath . DIRECTORY_SEPARATOR . $flavor->getName(), 
                function($target) use ($logger) {
                    $logger->info( "Installing " . $target,1);
            });
        }

        $logger->info("Done");
    }
}
