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


    /**
     * load flavor
     *
     * @param string $name flavor name
     * @return FlavirDirectory object.
     */
    public function load($name)
    {
        foreach( $this->dirs as $dir ) {
            $flavor = new FlavorDirectory($dir . DIRECTORY_SEPARATOR . $name);
            if( $flavor->exists() )
                return $flavor;
        }
        throw new Exception("Flavor $name not found.");
    }


    /**
     * load flavor generator
     */
    public function loadGeneratorClass($name) 
    {
        $flavor = $this->loadFlavor( $name );
        return $flavor->getGenerator();
    }


    /**
     * set flavor directory
     */
    public function setFlavorDirs($dirs)
    {
        $this->dirs = (array) $dirs;
    }

    /**
     * load flavor generator
     */
    public function loadFlavorGenerator($name) 
    {
        $generator = $this->loadGeneratorClass($name);
        if( ! $generator ) {
            throw new Exception("Flavor $name not found.");
        }
        return $generator;
    }

}
