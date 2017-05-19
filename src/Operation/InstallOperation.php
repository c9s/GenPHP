<?php
namespace GenPHP\Operation;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use GenPHP\Operation\Helper;

class InstallOperation extends Operation
{
    public function run($paths) 
    {
        if ( ! is_array($paths) ) {
            $paths = array($paths);
        }
        foreach( $paths as $path ) {
            $sourcePath = $this->getResourcePath($path);
            if ( is_dir($sourcePath) ) {
                $this->generator->copyDir($path, $path);
            } else {
                $this->generator->copy($path, $path);
            }
        }
    }

}

