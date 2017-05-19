<?php
namespace GenPHP\Command;
use GenPHP\Path;
use GenPHP\Operation\Helper;
use GenPHP\Config;
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

        $config = new Config;
        if( $file = $config->getConfigFile() ) {
            if( ! file_exists($file) ) {
                // create default config file content
                $content =<<<EOS
[author]
name = AuthorName
email = your@email
copyright = 
EOS;
                file_put_contents( $file , $content );
                $this->logger->info("Config file is generated at $file");
            }
        }
    }
}
