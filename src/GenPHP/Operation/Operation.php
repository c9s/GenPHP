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

    public function logAction($action,$path,$indent = 1)
    {
        $logger = $this->getLogger();
        if( ! $logger )
            return;
        $formatter = $logger->getFormatter();
        $msg = sprintf( "%-10s %s" , 
            $formatter->format( $action , 'strong_white' ),
            $formatter->format( $path,   'white' )
        );
        $logger->info( $msg, $indent );
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

