<?php 
namespace GenPHP\Operation;

abstract class Operation 
{
    protected $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;
    }

}

