<?php 
namespace GenPHP\Operation;
use ReflectionObject;


/**
 * To create an operation object:
 *
 *   $operation = new $class( $generator it self );
 *
 * An operation class MUST implements a run method to take arguments:
 *
 *   $operation->run( ... );
 */
abstract class Operation 
{
    protected $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;
    }

    public function setGenerator($generator)
    {
        $this->generator = $generator;
    }

    public function logAction($action,$path,$indent = 1)
    {
        $this->generator->logAction( $action,$path,$indent);
    }


    public function getLogger()
    {
        return $this->generator->getLogger();
    }

    public function getResourcePath($path)
    {
        return $this->generator->getResourcePath($path);
    }

    public function getResourceDir()
    {
        return $this->generator->getResourceDir();
    }

}

