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

    public function getLogger()
    {
        return $this->generator->getLogger();
    }

    public function getResourceDir()
    {
        return $this->generator->getResourceDir();
    }
}

