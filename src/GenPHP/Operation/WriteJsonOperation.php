<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class WriteJsonOperation extends Operation
{
    /**
     * write json file
     *
     * @param string $file path to file
     * @param mixed  structural data
     */
    function run($file,$data)
    {
        $this->logAction('create',$file);
        Helper::put($file, json_encode($data));
    }
}

