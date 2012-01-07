<?php 
namespace flavor;
use GenPHP\Flavor\BaseGenerator;
use GenPHP\Path;
use Exception;

class Generator extends BaseGenerator
{

    public function brief() { 
        return "GenPHP flavor generator";
    }


    /**
     * generate new flavor 
     *
     * @param string $name flavor name, lower case, alphabets
     * @param string $path your code base path
     */
    public function generate($name,$codeBasePath = null)
    {
        $paths = Path::get_flavor_paths();
        foreach( $paths as $path ) {
            if( file_exists($path) ) {
                $base = $path . DIRECTORY_SEPARATOR . $name;
                $resourceDir = $base . DIRECTORY_SEPARATOR . "Resource";
                $this->createDir($resourceDir);

                if( $codeBasePath ) {
                    if( ! file_exists($codeBasePath) )
                        throw new Exception("$codeBasePath doesn't exist.");
                    $this->copyDir( $codeBasePath , $resourceDir );
                }

                $this->render( 'Generator.php.twig',  
                    $base . DIRECTORY_SEPARATOR . 'Generator.php', 
                    array( 'name' => $name ) );
            }
        }
    }
}
