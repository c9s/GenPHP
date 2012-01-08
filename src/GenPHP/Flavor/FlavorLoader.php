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
            $flavorDir = new FlavorDirectory($dir . DIRECTORY_SEPARATOR . $name);
            if( $flavorDir->exists() ) {
                return $flavorDir->getGenerator();
            }
        }
        throw new Exception("Flavor $name not found.");
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
