<?php 
namespace GenPHP\Operation;
use ReflectionObject;

abstract class Operation 
{
    protected $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;
    }

    public function getResourceDir()
    {
        $refl = new ReflectionObject( $this->generator );
        return $refl->getFilename() . DIRECTORY_SEPARATOR . 'resources';
    }
}

