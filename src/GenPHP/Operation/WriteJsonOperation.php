<?php 
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class WriteJsonOperation extends Operation
{
    function run($file,$data)
    {
        $this->logAction('create',$file);
        Helper::put($file, json_encode($data));
    }
}

