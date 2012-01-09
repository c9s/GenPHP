<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class MoveOperation extends Operation
{
    function run($from,$to)
    {
        $this->logAction('move',$to);
        rename($from,$to);
    }
}

