<?php 
namespace GenPHP\Flavor;
use GenPHP\Flavor\GenericGenerator;
use GenPHP\Flavor\FlavorDirectory;
use GenPHP\Path;
use Exception;

class FlavorLoader 
{
    /**
     * flavor dir 
     */
    private $dirs;

    function __construct($dirs = null)
    {
        /* get default flavor paths */
        $this->dirs = $dirs ? (array) $dirs : Path::get_flavor_paths();
    }

    function loadGeneratorClass($name) 
    {
        foreach( $this->dirs as $dir ) {
            $flavorDir = $dir . DIRECTORY_SEPARATOR . $name;
            $resourceDir = $flavorDir . DIRECTORY_SEPARATOR . 'Resource';
            $generatorFile = $flavorDir . DIRECTORY_SEPARATOR . 'Generator.php';
            if( file_exists($generatorFile) ) {
                require $generatorFile;
                $class = "\\$name\\Generator";
                return new $class;
            }
            elseif( file_exists($flavorDir) && file_exists($resourceDir) ) {
                // use GenericGenerator
                return $generator = new GenericGenerator( 
                    $flavorDir . DIRECTORY_SEPARATOR . 'Resource' );
            }
            else {
                throw new Exception("Flavor $name not found.");
            }
        }
    }

    function setFlavorDirs($dirs)
    {
        $this->dirs = (array) $dirs;
    }

    function load($name) 
    {
        $generator = $this->loadGeneratorClass($name);
        if( ! $generator ) {
            throw new Exception("Flavor $name not found.");
        }
        return $generator;
    }

}
