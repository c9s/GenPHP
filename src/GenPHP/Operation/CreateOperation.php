<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateOperation extends Operation
{

    function run($file,$content)
    {
        $this->logAction('create',$file);
        Helper::put( $file, $content );
    }

}

