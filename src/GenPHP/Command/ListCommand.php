<?php
namespace GenPHP\Command;
use GenPHP\Path;
class ListCommand extends \CLIFramework\Command 
{
    function brief() { 
        return 'list flavors';
    }

    function options($opts) 
    {
        // $opts->add('s|string:','description ....');
    }

    function execute()
    {
        $logger = $this->getLogger();

        $logger->info( 'Available flavors:' );

        $paths = Path::get_flavor_paths();
        foreach( $paths as $path ) {
            if ( ! file_exists($path) ) {
                continue;
            }

            if ( $handle = opendir( $path ) ) {
                while (false !== ($entry = readdir($handle))) {
                    if ( $entry[0] == '.' || $entry == '..' )  {
                        continue;
                    }
                    $logger->info( sprintf("%-10s  %s",$entry, $path), 1 );
                }
                closedir($handle);
            }
        }
    }
}
