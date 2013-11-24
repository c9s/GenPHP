<?php
namespace GenPHP\Flavor;
use SplFileInfo;
use GenPHP\Flavor\GenericGenerator;

class Flavor extends SplFileInfo
{
    private $resourceDir;

    private $loader;

    public function __construct($fileInfo, $loader = null) {
        parent::__construct($fileInfo);
        if ( $loader ) {
            $this->loader = $loader;
        }
    }

    public function getGeneratorClassFile()
    {
        return $this->getPathname() . DIRECTORY_SEPARATOR . 'Generator.php';
    }

    public function hasGeneratorClassFile()
    {
        return file_exists($this->getGeneratorClassFile());
    }

    public function exists()
    {
        return file_exists($this->getPathname());
    }

    public function requireGeneratorClassFile()
    {
        $class = $this->getGeneratorClass();
        if ( class_exists($class) ) {
            return $class;
        }
        require $this->getGeneratorClassFile();
        return $class;
    }

    public function getName()
    {
        return $this->getBasename();
    }


    public function getNamespace()
    {
        $name = $this->getName();
        return preg_replace( '#[-]+#', '_' , $name );
    }

    public function getGeneratorClass()
    {
        return $this->getNamespace() . '\Generator';
    }

    public function createGenericGenerator()
    {
        return new GenericGenerator($this);
    }

    public function getGenerator()
    {
        if( $this->hasGeneratorClassFile() ) {
            $class = $this->requireGeneratorClassFile();
            return new $class( $this );
        } elseif( $this->hasResourceDir() ) {
            return $this->createGenericGenerator();
        }
    }





    /**
     * Set resource directory
     *
     * @param string $dir 
     */
    public function setResourceDir($dir)
    {
        $this->resourceDir = $dir;
    }

    public function setLoader($loader)
    {
        $this->loader = $loader;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Get Flavor Directory from Generator class
     *
     * @return string $path
     */
    public function getResourceDir()
    {
        if( $this->resourceDir )
            return $this->resourceDir;
        return $this->getPathname() . DIRECTORY_SEPARATOR . 'Resource';

# XXX: old path gettter method from generator
#          $refl = new ReflectionObject($this);
#          $flavor = new Flavor( dirname($refl->getFilename()) );
#          return $flavor->getResourceDir();
    }

    public function getResourcePath($path)
    {
        return $this->getResourceDir() . DIRECTORY_SEPARATOR . $path;
    }


    /**
     * return resource file path
     *
     * @param string $path
     * @return SplFileInfo
     */
    public function getResourceFile( $path )
    {
        $file = $this->getResourceDir() . DIRECTORY_SEPARATOR . $path;
        if( file_exists($file) )
            return new SplFileInfo( $file );
        throw new Exception( "$file does not exist." );
    }


    /**
     * return resource file content 
     *
     * @param string $path
     * @return string content
     */
    public function getResourceContent($path)
    {
        return file_get_contents( $this->getResourceFile( $path ) );
    }


    /**
     * check if resource directory exists
     *
     * @return boolean 
     */
    public function hasResourceDir()
    {
        return file_exists($this->getResourceDir());
    }


    /**
     * helper method for getting resource path
     *
     * @code
     *    
     *    $file = $flavor->path('path/to/file');
     *
     * @param string $path
     * @see getResourceFile
     */
    public function path($path)
    {
        return $this->getResourceDir() . DIRECTORY_SEPARATOR . $path;
    }

}

