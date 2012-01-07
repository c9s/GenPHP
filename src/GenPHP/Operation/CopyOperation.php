<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CopyOperation extends Operation
{

    function getLogger()
    {
        return $this->generator->getLogger();
    }

    function run($from,$to)
    {
        Helper::mkdirForFile($to);

        $this->getLogger()->info("copy $to",1);

        // do copy
        copy($from,$to);
    }

}

