<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CopyOperation extends Operation
{
    public function run($from,$to)
    {
        $this->logAction('copy',$to);
        $rsDir = $this->getResourceDir();
        Helper::copy($rsDir . DIRECTORY_SEPARATOR . $from,$to);
    }
}

