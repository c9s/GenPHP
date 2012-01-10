<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class TouchOperation extends Operation
{

    /**
     * touch a file
     *
     * @param string $path
     */
    function run($path)
    {
        $this->logAction('touch',$path);
        touch($path);
    }
}

