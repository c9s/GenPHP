<?php 
namespace flavor;
use GenPHP\Flavor\BaseGenerator;
use GenPHP\Path;

class Generator extends BaseGenerator
{
    public function brief() { 
        return "Default Flavor";
    }

    public function generate($name)
    {
        $paths = Path::get_flavor_paths();
        foreach( $paths as $path ) {
            if( file_exists($path) ) {
                $base = $path . DIRECTORY_SEPARATOR . $name;
                $this->createDir( $base . DIRECTORY_SEPARATOR . "Resources");
                $this->render( 'Generator.php.twig',  
                    $base . DIRECTORY_SEPARATOR . 'Generator.php', 
                    array( 'name' => $name ) );
            }
        }
        
    }
}
