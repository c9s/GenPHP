<?php
namespace GenPHP\Operation;
use GenPHP\Operation\Helper;

class CreateOperation extends Operation
{

    /**
     * file create operation
     *
     * @param string $file target file path
     * @param string $content file content
     */
    function run($file,$content)
    {
        $this->logAction('create',$file);
        Helper::put( $file, $content );
    }

}

