<?php 
namespace GenPHP\Flavor;
use GenPHP\Flavor\GenericGenerator;
use GenPHP\Flavor\Flavor;
use GenPHP\Path;
use Exception;

class FlavorLoader 
{
    /**
     * flavor dir 
     */
    private $dirs;

    public function __construct($dirs = null)
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
            if ( ! file_exists($dir . DIRECTORY_SEPARATOR . $name) ) {
                continue;
            }

            $flavor = new Flavor($dir . DIRECTORY_SEPARATOR . $name, $this);
            if ( $flavor->exists() ) {
                return $flavor;
            }
        }
        throw new Exception("Flavor $name not found.");
    }


    /**
     * load flavor generator
     */
    public function loadGeneratorClass($name) 
    {
        if( $flavor = $this->loadFlavor( $name ) ) {
            return $flavor->getGenerator();
        } else {
            throw new Exception("Flavor $name not found.");
        }
    }


    /**
     * Add flavor path
     *
     * @param string $dir
     */
    public function addPath($dir) 
    {
        $this->dirs[] = $dir;
    }

    /**
     * Set flavor directory paths
     *
     * @param array $dirs
     */
    public function setPaths($dirs)
    {
        $this->dirs = (array) $dirs;
    }

    /**
     * Get flavor generator from flavor name
     *
     * @param string $name flavor name
     */
    public function getFlavorGenerator($name) 
    {
        $generator = $this->loadGeneratorClass($name);
        if( ! $generator ) {
            throw new Exception("Flavor $name not found.");
        }
        return $generator;
    }

}
