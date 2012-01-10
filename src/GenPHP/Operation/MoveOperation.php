<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class MoveOperation extends Operation
{

    /**
     * move files of current working directory
     *
     * @param string $from path to file of current working directory.
     * @param string $to   rename to file.
     */
    function run($from,$to)
    {
        $this->logAction('move',$to);
        rename($from,$to);
    }
}

