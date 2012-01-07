<?php
namespace GenPHP\Flavor;
use SplFileInfo;
use GenPHP\Flavor\GenericGenerator;

class FlavorDirectory extends SplFileInfo
{
    public function getResourceDir()
    {
        return $this->getPathname() . DIRECTORY_SEPARATOR . 'Resource';
    }

    public function hasResourceDir()
    {
        return file_exists($this->getResourceDir());
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
        require $this->getGeneratorClassFile();
        return $this->getGeneratorClass();
    }

    public function getName()
    {
        return $this->getBasename();
    }

    public function getGeneratorClass()
    {
        return "\\{$this->getName()}\\Generator";
    }

    public function createGenericGenerator()
    {
        return new GenericGenerator( $this->getResourceDir() );
    }


    public function getGenerator()
    {
        if( $this->hasGeneratorClassFile() ) {
            $class = $this->requireGeneratorClassFile();
            return new $class;
        } elseif( $this->hasResourceDir() ) {
            return $this->createGenericGenerator();
        }
    }


}

