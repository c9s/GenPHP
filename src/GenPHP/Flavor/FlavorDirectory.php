<?php
namespace GenPHP\Flavor;
use SplFileInfo;

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

    public function getGeneratorClassPath()
    {
        return $this->getPathname() . DIRECTORY_SEPARATOR . 'Generator.php';
    }

    public function hasGeneratorClass()
    {
        return file_exists($this->getGeneratorClassPath());
    }

    public function exists()
    {
        return file_exists($this->getPathname());
    }

}

