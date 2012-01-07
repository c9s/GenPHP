<?php 
namespace GenPHP\Flavor;
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
            $p = $dir . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'Generator.php';
            if( file_exists($p) ) {
                require $p;
                $class = "\\$name\\Generator";
                return new $class;
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
