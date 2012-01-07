<?php 
namespace GenPHP\Flavor;
use GenPHP\Flavor\GenericGenerator;

class FlavorLoader 
{
    /**
     * flavor dir 
     */
    private $dirs;

    function __construct()
    {
        $this->dirs = array( 
            'flavors',
            '.flavors',
            getenv('HOME') . DIRECTORY_SEPARATOR . '.genphp' . DIRECTORY_SEPARATOR . 'flavors'
        );
    }

    function loadGeneratorClass($name) 
    {
        foreach( $this->dirs as $dir ) {
            $flavorDir = $dir . DIRECTORY_SEPARATOR . $name;
            $generatorFile = $flavorDir . DIRECTORY_SEPARATOR . 'Generator.php';
            if( file_exists($generatorFile) ) {
                require $generatorFile;
                $class = "\\$name\\Generator";
                return new $class;
            }
            else {
                // use GenericGenerator
                return $generator = new GenericGenerator( 
                    $flavorDir . DIRECTORY_SEPARATOR . 'Resources' );
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
