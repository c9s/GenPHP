<?php
namespace GenPHP\Flavor;
use SplFileInfo;
use GenPHP\Flavor\GenericGenerator;

class FlavorDirectory extends SplFileInfo
{
    private $resourceDir;



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
        require $this->getGeneratorClassFile();
        return $this->getGeneratorClass();
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
#          $flavor = new FlavorDirectory( dirname($refl->getFilename()) );
#          return $flavor->getResourceDir();
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

