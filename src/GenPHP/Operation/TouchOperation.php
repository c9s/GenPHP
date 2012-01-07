<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class TouchOperation extends Operation
{
    function run($path)
    {
        $this->logAction('touch',$path);
        touch($path);
    }
}

