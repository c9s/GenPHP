<?php
namespace GenPHP\Command;
use GenPHP\Path;
class ListCommand extends \CLIFramework\Command 
{
    function brief() { 
        return 'list flavors';
    }

    public function options($opts) 
    {
        // $opts->add('s|string:','description ....');
    }


    public function traverseDir($path, $parentPath = null)
    {
        if ( $handle = opendir( $path ) ) {
            while (false !== ($entry = readdir($handle))) {
                if ( $entry[0] == '.' || $entry == '..' )  {
                    continue;
                }
                if ( file_exists($path . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR . 'Resource') ) {
                    $this->getLogger()->info( sprintf("%-20s", $parentPath ? $parentPath . '/' . $entry : $entry), 1 );
                } else {
                    if ( is_dir($path . DIRECTORY_SEPARATOR . $entry) ) {
                        $this->traverseDir(
                            $path . DIRECTORY_SEPARATOR . $entry,
                            $entry 
                        );
                    }
                }
            }
            closedir($handle);
        }
    }

    public function execute()
    {
        $logger = $this->getLogger();
        $paths = Path::get_flavor_paths();
        foreach( $paths as $path ) {
            if ( ! file_exists($path) ) {
                continue;
            }
            $logger->info("flavors in '$path':");
            $this->traverseDir($path);
        }
    }
}
