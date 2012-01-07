<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CopyOperation extends Operation
{

    function run($from,$to)
    {

        $this->logAction('copy',$to);
        $rsDir = $this->getResourceDir();

        // do copy
        Helper::copy($rsDir . DIRECTORY_SEPARATOR . $from,$to);
    }

}

