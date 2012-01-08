<?php
namespace GenPHP\Command;
use GenPHP\Path;
use GenPHP\Operation\Helper;
class InitCommand extends \CLIFramework\Command 
{
    function brief() { return 'init genphp'; }

    function options($opts) 
    {
        // $opts->add('s|string:','description ....');
    }

    function execute()
    {
        $logger = $this->getLogger();
        $path = Path::get_home_flavor_path();
        $logger->info( "Creating $path ..." );
        Helper::mktree( $path );

        $logger->info( "Creating flavors/..." );
        Helper::mktree( 'flavors' );
        $logger->info( "Done" );
    }
}
